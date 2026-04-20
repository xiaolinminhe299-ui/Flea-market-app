<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $item->name }}</title>
        <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: Arial, sans-serif;
                background: #fff;
                color: #000;
            }

            /* ── Header ── */
            .header {
                background: #000;
            }

            .header-inner {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                height: 46px;
                width: min(100%, 1540px);
                margin: 0 auto;
                padding: 0 14px;
            }

            .logo-wrap {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                text-decoration: none;
            }

            .logo-mark {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 20px;
            }

            .logo-mark-text {
                position: relative;
                display: inline-flex;
                align-items: flex-start;
                color: #fff;
                font-size: 20px;
                font-weight: 900;
                font-style: italic;
                letter-spacing: 0;
                line-height: 0.9;
                transform: skewX(-18deg) scaleY(0.82);
            }

            .logo-mark-text::after {
                content: "";
                position: absolute;
                top: 2px;
                left: 11px;
                width: 6px;
                height: 1px;
                background: rgba(255, 255, 255, 0.85);
            }

            .logo-mark-c,
            .logo-mark-t {
                display: block;
            }

            .logo-mark-t {
                margin-left: -3px;
            }

            .logo-text {
                color: #fff;
                font-size: 20px;
                font-weight: 700;
                letter-spacing: 1px;
                line-height: 1;
                text-decoration: none;
            }

            .search {
                width: min(100%, 300px);
                height: 28px;
                padding: 0 10px;
                border: 0;
                border-radius: 3px;
                font-size: 12px;
            }

            .nav {
                display: flex;
                align-items: center;
                gap: 16px;
                flex-shrink: 0;
            }

            .nav-link {
                color: #fff;
                font-size: 12px;
                text-decoration: none;
                white-space: nowrap;
                line-height: 1;
            }

            .logout-form {
                display: inline-flex;
                align-items: center;
                margin: 0;
            }

            .logout-btn {
                color: #fff;
                font-size: 12px;
                line-height: 1;
                text-decoration: none;
                white-space: nowrap;
                background: none;
                border: none;
                cursor: pointer;
                padding: 0;
                font-family: inherit;
                font-weight: 400;
                appearance: none;
                -webkit-appearance: none;
            }

            .sell-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 48px;
                height: 28px;
                border-radius: 3px;
                background: #fff;
                color: #000;
                font-size: 12px;
                text-decoration: none;
            }

            /* ── Layout ── */
            .content {
                display: flex;
                gap: 48px;
                width: min(100%, 960px);
                margin: 0 auto;
                padding: 32px 16px 64px;
            }

            .col-image {
                flex: 0 0 360px;
            }

            .item-image {
                display: grid;
                place-items: center;
                width: 100%;
                aspect-ratio: 1;
                background: #d2d2d2;
                font-size: 14px;
                color: #555;
                overflow: hidden;
            }

            .item-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .col-detail {
                flex: 1;
                min-width: 0;
            }

            /* ── Item info ── */
            .item-name {
                margin: 0 0 4px;
                font-size: 22px;
                font-weight: 700;
                line-height: 1.3;
            }

            .item-brand {
                margin: 0 0 12px;
                font-size: 12px;
                color: #555;
            }

            .item-price {
                margin: 0 0 12px;
                font-size: 26px;
                font-weight: 700;
            }

            .item-price span {
                font-size: 14px;
                font-weight: 400;
            }

            .meta-row {
                display: flex;
                align-items: center;
                gap: 20px;
                margin-bottom: 18px;
            }

            .meta-item {
                display: flex;
                align-items: center;
                gap: 5px;
                font-size: 13px;
            }

            .like-form {
                margin: 0;
            }

            .like-btn {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 0;
                border: 0;
                background: none;
                cursor: pointer;
                color: inherit;
                font: inherit;
            }

            .like-btn.active .meta-icon {
                color: #ff5555;
            }

            .meta-icon {
                font-size: 18px;
                line-height: 1;
            }

            .buy-btn {
                display: block;
                width: 100%;
                height: 40px;
                margin-bottom: 24px;
                border: 0;
                border-radius: 4px;
                background: #ff5555;
                color: #fff;
                font-size: 14px;
                font-weight: 700;
                text-align: center;
                line-height: 40px;
                text-decoration: none;
                cursor: pointer;
            }

            /* ── Sections ── */
            .section-title {
                margin: 0 0 10px;
                font-size: 16px;
                font-weight: 700;
            }

            .section + .section {
                margin-top: 24px;
            }

            .item-description {
                font-size: 13px;
                line-height: 1.7;
                white-space: pre-line;
                margin: 0;
            }

            /* info table */
            .info-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 13px;
            }

            .info-table tr {
                border-bottom: 1px solid #e8e8e8;
            }

            .info-table th {
                width: 120px;
                padding: 8px 0;
                text-align: left;
                font-weight: 700;
                color: #333;
                vertical-align: top;
            }

            .info-table td {
                padding: 8px 0;
                vertical-align: top;
            }

            .chips {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
            }

            .chip {
                display: inline-flex;
                align-items: center;
                height: 22px;
                padding: 0 10px;
                border: 1px solid #bcbcbc;
                border-radius: 999px;
                font-size: 11px;
                background: #f5f5f5;
            }

            /* ── Comments ── */
            .comment-list {
                display: flex;
                flex-direction: column;
                gap: 14px;
                margin-bottom: 24px;
            }

            .comment-item {
                display: flex;
                gap: 10px;
                align-items: flex-start;
            }

            .comment-avatar {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: #d2d2d2;
                flex-shrink: 0;
                overflow: hidden;
            }

            .comment-avatar img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .comment-body {
                flex: 1;
            }

            .comment-username {
                font-size: 12px;
                font-weight: 700;
                margin-bottom: 4px;
            }

            .comment-text {
                font-size: 12px;
                line-height: 1.6;
                background: #f5f5f5;
                padding: 8px 10px;
                border-radius: 4px;
                white-space: pre-line;
            }

            .comment-form textarea {
                width: 100%;
                height: 100px;
                padding: 8px 10px;
                border: 1px solid #bcbcbc;
                font-size: 13px;
                font-family: inherit;
                resize: none;
                outline: none;
                background: #fff;
            }

            .comment-submit {
                display: block;
                width: 100%;
                height: 36px;
                margin-top: 10px;
                border: 0;
                border-radius: 4px;
                background: #ff5555;
                color: #fff;
                font-size: 14px;
                font-weight: 700;
                cursor: pointer;
            }

            /* ── Responsive ── */
            @media (max-width: 680px) {
                .header-inner {
                    flex-wrap: wrap;
                    height: auto;
                    padding: 8px 10px;
                }

                .logo-text { font-size: 16px; }
                .logo-mark { width: 30px; height: 16px; }
                .logo-mark-text { font-size: 16px; }
                .logo-mark-text::after { top: 1px; left: 8px; width: 5px; }

                .search {
                    order: 3;
                    width: 100%;
                }

                .content {
                    flex-direction: column;
                    gap: 24px;
                    padding: 20px 16px 48px;
                }

                .col-image {
                    flex: none;
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <div class="page">
            <header class="header">
                <div class="header-inner">
                    <a class="logo-wrap" href="{{ url('/') }}">
                        <span class="logo-mark"><img class="logo-mark-image" src="{{ asset('images/logo-mark.svg') }}" alt="CT" style="display:block;width:100%;height:100%"></span>
                        <span class="logo-text">COACHTECH</span>
                    </a>

                    <input class="search" type="text" placeholder="なにをお探しですか？" aria-label="検索">

                    @php
                        $isGuestPreviewMode = !empty($isGuestPreview);
                        $headerSessionUser = session('logged_in_user');
                        $isHeaderLoggedIn = !$isGuestPreviewMode && (Auth::check() || (is_array($headerSessionUser) && !empty($headerSessionUser['email'])));
                    @endphp

                    <nav class="nav">
                        @if ($isHeaderLoggedIn)
                            <form class="logout-form" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="logout-btn">ログアウト</button>
                            </form>
                        @else
                            <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                        @endif
                        <a class="nav-link" href="{{ route('mypage') }}">マイページ</a>
                        <a class="sell-btn" href="{{ route('items.create') }}">出品</a>
                    </nav>
                </div>
            </header>

            <main class="content">
                <!-- 左：商品画像 -->
                <div class="col-image">
                    <div class="item-image">
                        @if ($item->image)
                            <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        @else
                            商品画像
                        @endif
                    </div>
                </div>

                <!-- 右：商品詳細 -->
                <div class="col-detail">
                    <h1 class="item-name">{{ $item->name }}</h1>
                    @if (in_array($item->name, ['玉ねぎ3束', 'マイク', 'タンブラー'], true))
                        <p class="item-brand">なし</p>
                    @elseif ($item->brand)
                        <p class="item-brand">{{ $item->brand }}</p>
                    @endif

                    <p class="item-price">¥{{ number_format($item->price) }}<span>（税込）</span></p>

                    <div class="meta-row">
                        <div class="meta-item">
                            @if (!empty($item->id))
                                <form class="like-form" method="POST" action="{{ route('item.like.toggle', ['item_id' => $item->id]) }}">
                                    @csrf
                                    <button type="submit" class="like-btn {{ !empty($likedByCurrentUser) ? 'active' : '' }}" aria-label="いいね">
                                        <span class="meta-icon">{{ !empty($likedByCurrentUser) ? '❤' : '♡' }}</span>
                                        <span>{{ $likeCount }}</span>
                                    </button>
                                </form>
                            @else
                                <span class="meta-icon">♡</span>
                                <span>{{ $likeCount }}</span>
                            @endif
                        </div>
                        <div class="meta-item">
                            <span class="meta-icon">💬</span>
                            <span>{{ $commentCount }}</span>
                        </div>
                    </div>

                    <a class="buy-btn" href="{{ route('purchase.show', ['item_id' => $item->id]) }}">購入手続きへ</a>

                    <!-- 商品説明 -->
                    <div class="section">
                        <h2 class="section-title">商品説明</h2>
                        <p class="item-description">{{ $item->description }}</p>
                    </div>

                    <!-- 商品の情報 -->
                    <div class="section">
                        <h2 class="section-title">商品の情報</h2>
                        <table class="info-table">
                            <tr>
                                <th>カテゴリー</th>
                                <td>
                                    <div class="chips">
                                        @foreach ($item->categories as $category)
                                            <span class="chip">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>商品の状態</th>
                                <td>{{ $item->condition }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- コメント -->
                    <div class="section">
                        <h2 class="section-title">コメント({{ $commentCount }})</h2>

                        @php
                            $displayComments = $comments ?? $item->comments;
                        @endphp

                        @if ($displayComments->isNotEmpty())
                            <div class="comment-list">
                                @foreach ($displayComments as $comment)
                                    <div class="comment-item">
                                        <div class="comment-avatar">
                                            @if (optional(optional($comment->user)->profile)->image)
                                                <img src="{{ asset('storage/' . $comment->user->profile->image) }}" alt="{{ data_get($comment, 'user.name') }}">
                                            @endif
                                        </div>
                                        <div class="comment-body">
                                            <div class="comment-username">{{ data_get($comment, 'user.name') }}</div>
                                            <div class="comment-text">{{ $comment->body }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <h2 class="section-title">商品へのコメント</h2>
                        @if (session('status') === 'comment-saved')
                            <p style="margin: 0 0 10px; color: #0073cc; font-size: 12px;">コメントを送信しました。</p>
                        @endif
                        @php
                            $sessionUser = session('logged_in_user');
                            $canPostComment = !$isGuestPreviewMode && (Auth::check() || (is_array($sessionUser) && !empty($sessionUser['email'])));
                        @endphp

                        @if ($canPostComment)
                            <form class="comment-form" method="POST" action="{{ route('item.comments.store') }}">
                                @csrf
                                @if (!empty($item->id))
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                @endif
                                <textarea name="body" maxlength="254" placeholder="" class="@if($errors->has('body')) error @endif">{{ old('body') }}</textarea>
                                @if($errors->has('body'))
                                    <div style="margin-top: 6px; color: #ff5555; font-size: 11px; font-weight: 700;">{{ $errors->first('body') }}</div>
                                @endif
                                <button type="submit" class="comment-submit">コメントを送信する</button>
                            </form>
                        @else
                            <form class="comment-form" action="{{ route('item.comments.store') }}" method="POST">
                                @csrf
                                @if (!empty($item->id))
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                @endif
                                <textarea maxlength="254" placeholder="" aria-label="コメント入力欄（ログイン前）"></textarea>
                                <button type="submit" class="comment-submit">コメントを送信</button>
                            </form>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
