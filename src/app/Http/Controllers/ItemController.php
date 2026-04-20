<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function show(Request $request, int $item_id): View
    {
        $item = Item::with(['user', 'categories', 'likes', 'comments.user.profile'])->findOrFail($item_id);

        $sessionLikeIds = collect($request->session()->get('item_likes', []))->map(fn($id) => (int) $id);
        $sessionLiked = $sessionLikeIds->contains($item->id);
        $dbLiked = Auth::check() ? $item->likes->contains('user_id', Auth::id()) : false;
        $likedByCurrentUser = $dbLiked || $sessionLiked;

        $sessionComments = collect($request->session()->get("item_comments.{$item_id}", []))
            ->map(function (array $comment) {
                return (object) [
                    'body' => $comment['body'],
                    'user' => (object) [
                        'name' => $comment['user_name'],
                        'profile' => null,
                    ],
                ];
            });

        $comments = collect($item->comments)->map(function ($comment) {
            return (object) [
                'body' => $comment->body,
                'user' => (object) [
                    'name' => optional($comment->user)->name ?? 'ユーザー',
                    'profile' => optional($comment->user)->profile,
                ],
            ];
        })->concat($sessionComments)->values();

        $likeCount    = $item->likes->count() + ($sessionLiked && !$dbLiked ? 1 : 0);
        $commentCount = $comments->count();

        return view('items.show', [
            'item'         => $item,
            'comments'     => $comments,
            'likeCount'    => $likeCount,
            'likedByCurrentUser' => $likedByCurrentUser,
            'commentCount' => $commentCount,
        ]);
    }

    public function toggleLike(Request $request, int $item_id): RedirectResponse
    {
        $item = Item::findOrFail($item_id);

        if (Auth::check()) {
            $like = Like::query()
                ->where('item_id', $item->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($like) {
                $like->delete();
            } else {
                Like::create([
                    'item_id' => $item->id,
                    'user_id' => Auth::id(),
                ]);
            }

            return back();
        }

        $likes = collect($request->session()->get('item_likes', []))->map(fn($id) => (int) $id)->values();

        if ($likes->contains($item->id)) {
            $likes = $likes->reject(fn($id) => $id === $item->id)->values();
        } else {
            $likes->push($item->id);
        }

        $request->session()->put('item_likes', $likes->all());

        return back();
    }
}
