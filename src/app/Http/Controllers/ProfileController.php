<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Throwable;

class ProfileController extends Controller
{
    private function getSessionProfileForCurrentUser(Request $request): ?array
    {
        if (! $request->session()->has('profile')) {
            return null;
        }

        $sessionProfile = (array) $request->session()->get('profile');
        $sessionOwnerUserId = data_get($sessionProfile, '_owner_user_id');
        $sessionOwnerEmail = data_get($sessionProfile, '_owner_email');
        $currentUserId = $request->user()->id ?? null;
        $currentEmail = $request->user()->email
            ?? data_get($request->session()->get('registered_user'), 'email')
            ?? data_get($request->session()->get('logged_in_user'), 'email');

        if ($currentUserId && $sessionOwnerUserId) {
            return (string) $currentUserId === (string) $sessionOwnerUserId ? $sessionProfile : null;
        }

        if (! $sessionOwnerEmail || ! $currentEmail || $sessionOwnerEmail !== $currentEmail) {
            return null;
        }

        return $sessionProfile;
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $profile = optional($user)->profile;
        $sessionProfile = $this->getSessionProfileForCurrentUser($request);

        if (! $user && $request->session()->has('logged_in_user')) {
            $user = (object) $request->session()->get('logged_in_user');
        }

        if (! $profile && $sessionProfile) {
            $profile = (object) $sessionProfile;
        } elseif ($profile && $sessionProfile) {
            if (empty($profile->image) && ! empty($sessionProfile['image'])) {
                $profile->image = $sessionProfile['image'];
            }
        }

        $tab = $request->query('page', 'sell');

        if ($request->user()) {
            if ($tab === 'sell') {
                $items = Item::where('user_id', $request->user()->id)->latest('id')->get();
            } else {
                $purchasedItemIds = DB::table('orders')
                    ->where('user_id', $request->user()->id)
                    ->pluck('item_id');
                $items = Item::whereIn('id', $purchasedItemIds)->latest('id')->get();
            }
        } else {
            $items = collect($request->session()->get('listed_items', []))
                ->map(fn (array $item) => (object) $item);
        }

        return view('profiles.mypage', [
            'user'    => $user,
            'profile' => $profile,
            'tab'     => $tab,
            'items'   => $items,
        ]);
    }

    public function create(Request $request): View
    {
        $user = $request->user();
        $profile = optional($user)->profile;
        $sessionProfile = $this->getSessionProfileForCurrentUser($request);
        $forceEmptyName = $request->boolean('from_verify');

        if (! $user && $request->session()->has('logged_in_user')) {
            $user = (object) $request->session()->get('logged_in_user');
        }

        if (! $profile && $sessionProfile) {
            $profile = (object) $sessionProfile;
        } elseif ($profile && $sessionProfile) {
            if (empty($profile->image) && ! empty($sessionProfile['image'])) {
                $profile->image = $sessionProfile['image'];
            }
        }

        return view('profiles.create', [
            'user' => $user,
            'profile' => $profile,
            'forceEmptyName' => $forceEmptyName,
        ]);
    }

    public function store(ProfileRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $storedProfile = [
            'image' => optional(optional($request->user())->profile)->image,
            'postal_code' => $validated['postal_code'],
            'address' => $validated['address'],
            'building' => $validated['building'] ?? null,
        ];

        $currentUserId = $request->user()->id ?? null;
        $currentEmail = $request->user()->email
            ?? data_get($request->session()->get('registered_user'), 'email')
            ?? data_get($request->session()->get('logged_in_user'), 'email');

        $request->session()->put('logged_in_user', [
            'name' => $validated['name'],
            'email' => $currentEmail,
        ]);

        if ($request->hasFile('image')) {
            try {
                $storedProfile['image'] = $request->file('image')->store('profiles', 'public');
            } catch (Throwable $exception) {
                $storedProfile['image'] = null;
            }
        }

        $request->session()->put('profile', array_merge($storedProfile, [
            '_owner_user_id' => $currentUserId,
            '_owner_email' => $currentEmail,
        ]));

        if (! $request->user()) {
            return redirect('/')->with('status', 'profile-saved');
        }

        try {
            $request->user()->update([
                'name' => $validated['name'],
            ]);

            $profileAttributes = $storedProfile;
            if (! Schema::hasColumn('profiles', 'image')) {
                unset($profileAttributes['image']);
            }

            $request->user()->profile()->updateOrCreate(
                [],
                $profileAttributes
            );
        } catch (Throwable $exception) {
            return redirect()->route('profile.create')->with('status', 'profile-saved');
        }

        return redirect()->route('profile.create')->with('status', 'profile-saved');
    }
}
