<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>商品一覧（ログイン前）</title>
        <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: Arial, sans-serif;
                color: #000;
                background: #f2f2f2;
            }

            .page {
                min-height: 100vh;
                background: #f2f2f2;
            }

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

            .search-form {
                margin: 0;
                width: min(100%, 300px);
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

            .tab-row {
                display: flex;
                align-items: center;
                gap: 48px;
                height: 40px;
                padding: 0 26px;
                border-top: 1px solid #bcbcbc;
                border-bottom: 1px solid #bcbcbc;
                background: #f2f2f2;
            }

            .tab {
                color: #555;
                font-size: 24px;
                font-weight: 700;
                text-decoration: none;
                line-height: 1;
            }

            .tab.active {
                color: #ff5555;
            }

            .items {
                display: flex;
                flex-wrap: wrap;
                gap: 52px 56px;
                padding: 30px 48px 20px;
            }

            .item {
                width: 230px;
            }

            .item-image {
                display: block;
                width: 230px;
                height: 230px;
                object-fit: cover;
                border-radius: 4px;
            }

            .item-image-link {
                display: block;
            }

            .item-image-placeholder {
                display: grid;
                place-items: center;
                background: #d2d2d2;
                color: #000;
                font-size: 44px;
            }

            .item-name {
                margin-top: 6px;
                font-size: 36px;
            }

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

                .logo-mark-text::after {
                    top: 1px;
                    left: 8px;
                    width: 5px;
                }

                .search {
                    order: 3;
                    width: 100%;
                }

                .tab-row {
                    gap: 28px;
                    padding: 0 16px;
                }

                .tab {
                    font-size: 18px;
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
                    height: 150px;
                    font-size: 24px;
                }

                .item-name {
                    font-size: 18px;
                }
            }
        </style>
    </head>
    <body>
        @php
            $fallbackImage = asset('images/items/no-image.svg');
        @endphp
        <div class="page">
            <header class="header">
                <div class="header-inner">
                    <a class="logo-wrap" href="{{ url('/') }}">
                        <span class="logo-mark"><img class="logo-mark-image" src="{{ asset('images/logo-mark.svg') }}" alt="CT" style="display:block;width:100%;height:100%"></span>
                        <span class="logo-text">COACHTECH</span>
                    </a>

                    <form class="search-form" method="GET" action="{{ url('/guest-home-preview') }}">
                        <input class="search" type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="なにをお探しですか？" aria-label="検索">
                    </form>

                    <nav class="nav">
                        <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                        <a class="nav-link" href="{{ route('mypage') }}">マイページ</a>
                        <a class="sell-btn" href="{{ route('items.create') }}">出品</a>
                    </nav>
                </div>
            </header>

            <nav class="tab-row" aria-label="商品タブ">
                <a class="tab active" href="#">おすすめ</a>
                <a class="tab" href="#">マイリスト</a>
            </nav>

            <main class="items">
                @foreach ($items as $item)
                    @php
                        $itemLink = !empty($item->id)
                            ? route('item.show', ['item_id' => $item->id])
                            : route('guest.item.show', ['sessionKey' => $item->session_key]);
                    @endphp
                    <article class="item">
                        <a class="item-image-link" href="{{ $itemLink }}">
                            <img class="item-image" src="{{ $item->image ? (Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) : $fallbackImage }}" alt="{{ $item->name }}" onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                        </a>
                        <div class="item-name">{{ $item->name }}</div>
                    </article>
                @endforeach
            </main>
        </div>
    </body>
</html>
