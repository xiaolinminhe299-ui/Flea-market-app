<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>マイページ</title>
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

            .page {
                min-height: 100vh;
                background: #fff;
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

            .nav {
                display: flex;
                align-items: center;
                gap: 16px;
                flex-shrink: 0;
            }

            .search {
                width: min(100%, 300px);
                height: 28px;
                padding: 0 10px;
                border: 0;
                border-radius: 3px;
                font-size: 12px;
            }

            .nav-link {
                color: #fff;
                font-size: 12px;
                text-decoration: none;
                white-space: nowrap;
                line-height: 1;
                font-weight: 400;
                display: inline-block;
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
                display: inline-block;
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

            /* ── Profile section ── */
            .profile-section {
                display: flex;
                align-items: center;
                gap: 24px;
                padding: 28px 64px 20px;
            }

            .avatar {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background: #d2d2d2;
                overflow: hidden;
                flex-shrink: 0;
            }

            .avatar img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .profile-name {
                font-size: 20px;
                font-weight: 700;
                flex: 1;
            }

            .edit-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                height: 32px;
                padding: 0 18px;
                border: 1px solid #ff5555;
                border-radius: 6px;
                color: #ff5555;
                font-size: 12px;
                font-weight: 700;
                text-decoration: none;
                white-space: nowrap;
            }

            /* ── Tabs ── */
            .tab-row {
                display: flex;
                align-items: center;
                gap: 0;
                border-bottom: 1px solid #bcbcbc;
                padding: 0 64px;
            }

            .tab {
                padding: 8px 20px;
                font-size: 13px;
                font-weight: 700;
                color: #000;
                text-decoration: none;
                border-bottom: 2px solid transparent;
                margin-bottom: -1px;
            }

            .tab.active {
                color: #ff5555;
                border-bottom-color: #ff5555;
            }

            /* ── Items grid ── */
            .items {
                display: flex;
                flex-wrap: wrap;
                gap: 26px;
                padding: 28px 64px;
            }

            .item {
                width: 160px;
            }

            .item-image {
                display: grid;
                place-items: center;
                width: 160px;
                height: 160px;
                background: #d2d2d2;
                color: #000;
                font-size: 12px;
                border-radius: 4px;
                overflow: hidden;
            }

            .item-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .item-name {
                margin-top: 6px;
                font-size: 12px;
            }

            .empty-message {
                padding: 40px 64px;
                font-size: 13px;
                color: #888;
            }

            /* ── Responsive ── */
            @media (max-width: 680px) {
                .header-inner {
                    flex-wrap: wrap;
                    height: auto;
                    padding: 8px 10px;
                }

                .logo-text {
                    font-size: 16px;
                }

                .logo-mark {
                    width: 30px;
                    height: 16px;
                }

                .logo-mark-text {
                    font-size: 16px;
                }

                .search {
                    order: 3;
                    width: 100%;
                }

                .profile-section {
                    padding: 20px 16px 14px;
                }

                .tab-row {
                    padding: 0 16px;
                }

                .items {
                    gap: 16px;
                    padding: 20px 16px;
                }

                .item {
                    width: calc(50% - 8px);
                }

                .item-image {
                    width: 100%;
                    height: 0;
                    padding-bottom: 100%;
                    position: relative;
                }

                .item-image img {
                    position: absolute;
                    top: 0;
                    left: 0;
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

                    <div class="nav">
                        @auth
                            <form class="logout-form" method="POST" action="{{ route('logout') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="logout-btn">ログアウト</button>
                            </form>
                        @else
                            <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                        @endauth

                        <a class="nav-link" href="{{ route('mypage') }}">マイページ</a>
                        <a class="sell-btn" href="{{ route('items.create') }}">出品</a>
                    </div>
                </div>
            </header>

            <section class="profile-section">
                <div class="avatar">
                    @if ($profile && $profile->image)
                        <img src="{{ asset('storage/' . $profile->image) }}" alt="プロフィール画像">
                    @endif
                </div>
                <div class="profile-name">{{ $user->name ?? 'ユーザー名' }}</div>
                <a class="edit-btn" href="{{ route('profile.create') }}">プロフィールを編集</a>
            </section>

            <nav class="tab-row" aria-label="商品タブ">
                <a class="tab {{ $tab === 'sell' ? 'active' : '' }}" href="{{ route('mypage', ['page' => 'sell']) }}">出品した商品</a>
                <a class="tab {{ $tab === 'buy' ? 'active' : '' }}" href="{{ route('mypage', ['page' => 'buy']) }}">購入した商品</a>
            </nav>

            <main>
                @if (count($items) > 0)
                    <div class="items">
                        @foreach ($items as $item)
                            <article class="item">
                                <div class="item-image">
                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                                    @else
                                        商品画像
                                    @endif
                                </div>
                                <div class="item-name">{{ $item->name }}</div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <p class="empty-message">商品がありません。</p>
                @endif
            </main>
        </div>
    </body>
</html>
