<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    $keyword = $request->query('keyword', '');
    $activeTab = $request->query('tab') === 'mylist' ? 'mylist' : 'recommend';
    $guestSeedUserId = User::query()->where('email', 'dummy@example.com')->value('id');
    $sessionUserEmail = data_get($request->session()->get('logged_in_user'), 'email');
    $currentViewerUserId = Auth::id() ?: ($sessionUserEmail ? User::query()->where('email', $sessionUserEmail)->value('id') : null);
    $isLoggedIn = !is_null($currentViewerUserId);
    $soldItemIdsForViewer = $currentViewerUserId
        ? DB::table('orders')->where('user_id', $currentViewerUserId)->pluck('item_id')->all()
        : [];

    if ($activeTab === 'mylist' && !$isLoggedIn) {
        $items = collect();

        return view('welcome', compact('items', 'activeTab', 'keyword', 'currentViewerUserId', 'soldItemIdsForViewer'));
    }

    $items = Item::query()
        ->select(['id', 'name', 'image', 'is_sold', 'user_id'])
        ->when(!$isLoggedIn, fn($q) => $q->where('user_id', $guestSeedUserId))
        ->when($keyword !== '', fn($q) => $q->where('name', 'like', '%' . $keyword . '%'))
        ->when(
            $activeTab === 'mylist' && $isLoggedIn,
            fn($q) => $q->whereHas('likes', fn($lq) => $lq->where('user_id', $currentViewerUserId))
        )
        ->when(
            $activeTab === 'recommend' && $isLoggedIn,
            fn($q) => $q->where('user_id', '!=', $currentViewerUserId)
        )
        ->when(
            $isLoggedIn,
            fn($q) => $q
                ->orderByRaw("CASE WHEN name IN ('腕時計', '玉ねぎ3束', 'HDD') THEN 0 ELSE 1 END")
                ->latest('id')
        )
        ->when(!$isLoggedIn, fn($q) => $q->orderBy('id')->take(10))
        ->get();

    return view('welcome', compact('items', 'activeTab', 'keyword', 'currentViewerUserId', 'soldItemIdsForViewer'));
});

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');
Route::post('/item/{item_id}/like', [ItemController::class, 'toggleLike'])->name('item.like.toggle');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/registerde', function () {
    return redirect()->route('verification.notice');
})->name('register.done');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (LoginRequest $request) {
    $validated = $request->validated();

    // DB認証を試みる
    if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
        $request->session()->regenerate();
        $request->session()->forget('profile');
        $request->session()->forget('logged_in_user');

        return redirect('/');
    }

    // セッションベースのフォールバック
    $registeredUser = $request->session()->get('registered_user');
    $demoUsers = [
        ['name' => 'テストユーザー', 'email' => 'test@example.com', 'password' => 'password123'],
    ];

    if (is_array($registeredUser)) {
        $demoUsers[] = $registeredUser;
    }

    foreach ($demoUsers as $user) {
        if ($user['email'] === $validated['email'] && $user['password'] === $validated['password']) {
            $request->session()->forget('profile');
            $request->session()->put('logged_in_user', [
                'name' => $user['name'],
                'email' => $user['email'],
            ]);

            return redirect('/');
        }
    }

    return back()
        ->withErrors(['email' => 'ログイン情報が登録されていません'])
        ->onlyInput('email');
})->name('login.submit');

Route::get('/initial-profile', function () {
    return view('profiles.initial');
})->name('initial.profile');

Route::get('/sell', function () {
    return view('items.create');
})->name('items.create');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/email/verify', function (Request $request) {
    $user = Auth::user();

    if (!$user) {
        $registeredEmail = data_get($request->session()->get('registered_user'), 'email');

        if ($registeredEmail) {
            $user = User::query()->where('email', $registeredEmail)->first();
        }
    }

    $verificationUrl = null;

    if ($user instanceof User) {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
    }

    return view('auth.verify-email', compact('verificationUrl'));
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('initial.profile');
})->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify');

Route::get('/mypage/profile', [ProfileController::class, 'create'])->name('profile.create');
Route::post('/mypage/profile', [ProfileController::class, 'store'])->name('profile.store');
Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage');

$previewItem = function () {
    $sessionComments = collect(session('preview_comments', []))
        ->map(function (array $comment) {
            return (object) [
                'body' => $comment['body'],
                'user' => (object) [
                    'name' => $comment['user_name'],
                    'profile' => null,
                ],
            ];
        });

    return (object) [
        'id' => null,
        'name' => '商品名がここに入る',
        'brand' => 'COACHTECH',
        'price' => 47000,
        'description' => '上品なデザインの腕時計です。普段使いからフォーマルまで幅広く使えます。',
        'condition' => '良好',
        'image' => null,
        'categories' => collect([
            (object) ['name' => 'ファッション'],
            (object) ['name' => 'メンズ'],
        ]),
        'comments' => collect([
            (object) [
                'body' => '状態がとても良さそうですね。',
                'user' => (object) [
                    'name' => 'テストユーザー',
                    'profile' => null,
                ],
            ],
        ])->merge($sessionComments),
    ];
};

Route::get('/item-preview-2', function (Request $request) use ($previewItem) {
    $id = $request->query('id');
    $isGuestPreview = $request->boolean('guest');
    $displayComments = null;

    if ($id) {
        $item = Item::with(['categories', 'comments.user.profile'])->findOrFail($id);
        $likeCount = $item->likes()->count();
        $commentCount = $item->comments()->count();
    } else {
        $item = $previewItem();
        $likeCount = 0;
        $commentCount = $item->comments->count();
    }

    if ($isGuestPreview) {
        Comment::query()->delete();
        $request->session()->forget('preview_comments');
        $request->session()->forget('item_comments');
        $displayComments = collect();
        $commentCount = 0;
    }

    return view('items.show', [
        'item'         => $item,
        'likeCount'    => $likeCount,
        'commentCount' => $commentCount,
        'comments' => $displayComments,
        'isGuestPreview' => $isGuestPreview,
    ]);
});

Route::get('/item-preview', function (Request $request) use ($previewItem) {
    $id = $request->query('id');
    if ($id) {
        $item = Item::with(['categories', 'comments.user.profile'])->findOrFail($id);
        $likeCount    = $item->likes()->count();
        $commentCount = $item->comments()->count();
    } else {
        $item         = $previewItem();
        $likeCount    = 0;
        $commentCount = $item->comments->count();
    }

    return view('items.show', [
        'item'         => $item,
        'likeCount'    => $likeCount,
        'commentCount' => $commentCount,
    ]);
});

$resolvePurchaseItem = function (Request $request, ?int $itemId = null) use ($previewItem) {
    $requestedItemId = $itemId ?: (int) $request->query('item_id');
    $sessionItemId = (int) $request->session()->get('purchase_item_id');
    $resolvedItemId = $requestedItemId ?: $sessionItemId;

    if ($resolvedItemId && Item::query()->whereKey($resolvedItemId)->exists()) {
        $item = Item::query()->findOrFail($resolvedItemId);
        $request->session()->put('purchase_item_id', $resolvedItemId);

        return $item;
    }

    return $previewItem();
};

$resolvePurchaseAddress = function (Request $request) {
    return $request->session()->get('purchase_address', [
        'postal_code' => '123-4567',
        'address' => '東京都渋谷区1-2-3',
        'building' => 'コーチテックビル',
    ]);
};

Route::middleware('auth')->group(function () use ($resolvePurchaseItem, $resolvePurchaseAddress) {
    Route::get('/purchase/{item_id}', function (Request $request, int $item_id) use ($resolvePurchaseItem, $resolvePurchaseAddress) {
        $item = $resolvePurchaseItem($request, $item_id);
        $purchaseAddress = $resolvePurchaseAddress($request);

        return view('items.purchase', [
            'item' => $item,
            'itemId' => $item_id,
            'postalCode' => $purchaseAddress['postal_code'],
            'address' => $purchaseAddress['address'],
            'building' => $purchaseAddress['building'] ?? '',
            'paymentLabel' => session('purchase_payment_method', 'convenience') === 'card' ? 'カード払い' : 'コンビニ払い',
        ]);
    })->name('purchase.show');

    Route::post('/purchase/{item_id}', function (PurchaseRequest $request, int $item_id) {
        $validated = $request->validated();
        $item = Item::query()->findOrFail($item_id);

        $alreadyPurchasedByCurrentUser = DB::table('orders')
            ->where('user_id', Auth::id())
            ->where('item_id', $item_id)
            ->exists();

        if ($alreadyPurchasedByCurrentUser) {
            return redirect()->route('purchase.show', ['item_id' => $item_id])
                ->withErrors(['item' => 'この商品はすでに購入済みです']);
        }

        $request->session()->put('purchase_payment_method', $validated['payment_method']);
        $purchaseAddress = [
            'postal_code' => $validated['postal_code'],
            'address' => $validated['address'],
            'building' => $validated['building'] ?? null,
        ];
        $request->session()->put('purchase_address', $purchaseAddress);

        DB::transaction(function () use ($item, $purchaseAddress, $validated) {
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'payment_method' => $validated['payment_method'],
                'price' => $item->price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('order_addresses')->insert([
                'order_id' => $orderId,
                'postal_code' => $purchaseAddress['postal_code'],
                'address' => $purchaseAddress['address'],
                'building' => $purchaseAddress['building'] ?? null,
            ]);
        });

        $request->session()->forget('purchase_address');
        $request->session()->forget('purchase_item_id');

        return redirect('/')->with('status', 'purchase-complete');
    })->name('purchase.store');

    Route::get('/purchase/address/{item_id}', function (Request $request, int $item_id) use ($resolvePurchaseAddress) {
        $request->session()->put('purchase_item_id', $item_id);
        $purchaseAddress = $resolvePurchaseAddress($request);

        return view('items.address', [
            'itemId' => $item_id,
            'postalCode' => $purchaseAddress['postal_code'],
            'address' => $purchaseAddress['address'],
            'building' => $purchaseAddress['building'],
        ]);
    })->name('purchase.address');

    Route::post('/purchase/address/{item_id}', function (AddressRequest $request, int $item_id) {
        $validated = $request->validated();
        $request->session()->put('purchase_address', $validated);
        $request->session()->put('purchase_item_id', $item_id);

        return redirect()->route('purchase.show', ['item_id' => $item_id]);
    })->name('purchase.address.update');
});

Route::get('/purchase-preview', function (Request $request) {
    $itemId = (int) ($request->query('item_id') ?: $request->session()->get('purchase_item_id'));

    if ($itemId > 0) {
        return redirect()->route('purchase.show', ['item_id' => $itemId]);
    }

    return redirect('/');
});

Route::get('/item-address', function (Request $request) {
    $itemId = (int) $request->session()->get('purchase_item_id');

    if ($itemId > 0) {
        return redirect()->route('purchase.address', ['item_id' => $itemId]);
    }

    return redirect('/');
})->name('item.address');

Route::post('/item-address', function (AddressRequest $request) {
    $itemId = (int) $request->session()->get('purchase_item_id');

    if ($itemId <= 0) {
        return redirect('/');
    }

    $validated = $request->validated();
    $request->session()->put('purchase_address', $validated);

    return redirect()->route('purchase.show', ['item_id' => $itemId]);
})->name('item.address.update');

Route::post('/item-comments', function (Request $request) {
    // ログイン確認
    $sessionUser = $request->session()->get('logged_in_user');
    $isLoggedIn = Auth::check() || (is_array($sessionUser) && !empty($sessionUser['email']));

    if (!$isLoggedIn) {
        return back()->withErrors(['body' => 'コメントを送信するにはログインしてください']);
    }

    // バリデーション実行 - 失敗時は自動的に例外発生
    $validated = $request->validate([
        'body' => 'required|string|max:254',
        'item_id' => 'required|integer|exists:items,id',
    ], [
        'body.required' => 'コメントを入力してください',
        'body.max' => 'コメントは254文字以内で入力してください',
        'item_id.required' => 'コメント送信先の商品が見つかりません',
        'item_id.exists' => 'コメント送信先の商品が見つかりません',
    ]);

    // ここに到達できるのはバリデーション成功時のみ
    if (Auth::check()) {
        Comment::create([
            'item_id' => (int) $validated['item_id'],
            'user_id' => Auth::id(),
            'comment' => $validated['body'],
        ]);
    } else {
        $user = User::firstOrCreate(
            ['email' => $sessionUser['email']],
            [
                'name' => data_get($sessionUser, 'name', 'テストユーザー'),
                'password' => Hash::make(Str::random(32)),
            ]
        );

        Comment::create([
            'item_id' => (int) $validated['item_id'],
            'user_id' => $user->id,
            'comment' => $validated['body'],
        ]);
    }

    return back()->with('status', 'comment-saved');
})->name('item.comments.store');

Route::post('/sell', function (ExhibitionRequest $request) {
    $validated = $request->validated();
    $selectedCategories = collect($validated['categories'] ?? []);

    $categoryIds = $selectedCategories
        ->when(
            $selectedCategories->every(fn($value) => is_numeric($value)),
            fn($collection) => $collection->map(fn($value) => (int) $value),
            fn($collection) => $collection
                ->map(fn($value) => trim((string) $value))
                ->filter(fn($value) => $value !== '')
                ->map(fn($name) => Category::firstOrCreate(['name' => $name])->id)
        )
        ->unique()
        ->values()
        ->all();

    $path = $request->file('image')->store('items', 'public');

    if (Auth::check()) {
        $item = Item::create([
            'user_id'     => Auth::id(),
            'name'        => $validated['name'],
            'brand'       => $validated['brand'] ?? null,
            'price'       => $validated['price'],
            'description' => $validated['description'],
            'condition'   => $validated['condition'],
            'image'       => $path,
        ]);

        $item->categories()->sync($categoryIds);
    } else {
        $listedItems = $request->session()->get('listed_items', []);
        $listedItems[] = [
            'session_key' => (string) Str::uuid(),
            'name' => $validated['name'],
            'brand' => $validated['brand'] ?? null,
            'price' => (int) $validated['price'],
            'description' => $validated['description'],
            'condition' => $validated['condition'],
            'categories' => $validated['categories'],
            'image' => $path,
        ];
        $request->session()->put('listed_items', $listedItems);
    }

    return redirect('/guest-home-preview');
})->name('items.store');

Route::post('/purchase-preview', function (PurchaseRequest $request) {
    $validated = $request->validated();
    $request->session()->put('purchase_payment_method', $validated['payment_method']);

    $itemId = (int) $request->session()->get('purchase_item_id');

    if ($itemId > 0) {
        return redirect()->route('purchase.show', ['item_id' => $itemId]);
    }

    return redirect('/');
})->name('purchase.preview.store');

Route::view('/item-checkout', 'items.checkout');
Route::get('/item-guest-home', function () {
    $items = Item::query()
        ->select(['id', 'name', 'image'])
        ->latest('id')
        ->take(10)
        ->get();

    return view('items.guest-home', compact('items'));
});

Route::get('/guest-home-preview', function (Request $request) {
    $keyword = $request->query('keyword', '');

    $dbItems = Item::query()
        ->select(['id', 'name', 'image', 'price', 'description'])
        ->whereHas('user', fn($q) => $q->where('email', 'dummy@example.com'))
        ->when($keyword !== '', fn($q) => $q->where('name', 'like', '%' . $keyword . '%'))
        ->latest('id')
        ->take(10)
        ->get();

    $items = $dbItems;

    return view('items.guest-home', compact('items', 'keyword'));
});

Route::get('/guest-home-preview/item/{sessionKey}', function (Request $request, string $sessionKey) {
    $sessionItem = collect($request->session()->get('listed_items', []))
        ->values()
        ->first(function ($item, $index) use ($sessionKey) {
            $resolvedKey = $item['session_key'] ?? ('legacy-' . $index);
            return $resolvedKey === $sessionKey;
        });

    abort_unless(is_array($sessionItem), 404);

    $item = (object) [
        'id' => null,
        'name' => $sessionItem['name'] ?? '',
        'brand' => $sessionItem['brand'] ?? null,
        'price' => (int) ($sessionItem['price'] ?? 0),
        'description' => $sessionItem['description'] ?? '',
        'condition' => $sessionItem['condition'] ?? '',
        'image' => $sessionItem['image'] ?? null,
        'categories' => collect($sessionItem['categories'] ?? [])->map(fn($name) => (object) ['name' => $name]),
        'comments' => collect(),
    ];

    return view('items.show', [
        'item' => $item,
        'likeCount' => 0,
        'commentCount' => 0,
        'comments' => collect(),
        'isGuestPreview' => true,
    ]);
})->name('guest.item.show');
Route::view('/item-create', 'items.create');
Route::view('/verify-email', 'auth.verify-email');
Route::view('/profile-initial', 'profiles.initial');
Route::view('/profile-edit', 'profiles.create');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->forget('logged_in_user');
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

Route::post('/email/verification-notification', function (Request $request) {
    return back()->with('status', 'verification-link-sent');
})->name('verification.send');
