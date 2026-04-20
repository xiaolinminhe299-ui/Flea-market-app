<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>商品一覧</title>
        <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: Arial, sans-serif;
                color: #000;
                background: #ffffff;
            }

            .page {
                min-height: 100vh;
                background: #ffffff;
            }

            .brand-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                height: 46px;
                padding: 0 14px;
                background: #000;
            }

            .brand-logo-wrap {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                text-decoration: none;
            }

            .brand-mark {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 20px;
            }

            .brand-mark-text {
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

            .brand-mark-text::after {
                content: "";
                position: absolute;
                top: 2px;
                left: 11px;
                width: 6px;
                height: 1px;
                background: rgba(255, 255, 255, 0.85);
            }

            .brand-mark-c,
            .brand-mark-t {
                display: block;
            }

            .brand-mark-t {
                margin-left: -3px;
            }

            .brand-logo {
                color: #fff;
                font-size: 20px;
                font-weight: 700;
                letter-spacing: 1px;
                line-height: 1;
            }

            .header-nav {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .search-form {
                margin: 0;
                padding: 0;
            }

            .search {
                width: min(100%, 300px);
                height: 28px;
                padding: 0 10px;
                border: 0;
                border-radius: 3px;
                font-size: 12px;
            }

            .header-link {
                color: #fff;
                font-size: 12px;
                text-decoration: none;
                white-space: nowrap;
            }

            .header-button {
                padding: 0;
                border: 0;
                background: none;
                cursor: pointer;
                font-family: inherit;
                line-height: 1;
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
                height: 32px;
                padding: 0 64px;
                border-bottom: 1px solid #bcbcbc;
                background: #fff;
            }

            .tab {
                color: #000;
                font-size: 12px;
                text-decoration: none;
            }

            .tab.active {
                color: #ff5555;
                font-weight: 700;
            }

            .items {
                display: flex;
                flex-wrap: wrap;
                gap: 26px;
                padding: 28px 24px;
            }

            .item {
                width: 104px;
            }

            .item-link {
                position: relative;
                display: block;
                text-decoration: none;
                color: inherit;
            }

            .item-image {
                display: block;
                width: 104px;
                height: 104px;
                object-fit: cover;
                border-radius: 2px;
            }


            .sold-badge {
                position: absolute;
                top: 6px;
                left: 6px;
                z-index: 1;
                padding: 2px 8px;
                border-radius: 999px;
                background: #ff5555;
                color: #fff;
                font-size: 10px;
                font-weight: 700;
                letter-spacing: 0.3px;
                line-height: 1.4;
            }

            .item-name {
                margin-top: 6px;
                font-size: 12px;
            }

            @media (max-width: 680px) {
                .brand-bar {
                    flex-wrap: wrap;
                    height: auto;
                    padding: 8px 10px;
                }

                .brand-logo {
                    font-size: 16px;
                }

                .brand-mark {
                    width: 30px;
                    height: 16px;
                }

                .brand-mark-text {
                    font-size: 16px;
                }

                .brand-mark-text::after {
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

                .items {
                    gap: 16px;
                    padding: 20px 16px;
                }
            }
        </style>
    </head>
    <body>
        @php
            $fallbackImage = asset('images/items/no-image.svg');
            $headerSessionUser = session('logged_in_user');
            $isHeaderLoggedIn = Auth::check() || (is_array($headerSessionUser) && !empty($headerSessionUser['email']));
        @endphp
        <div class="page">
            <header class="brand-bar">
                <a class="brand-logo-wrap" href="{{ url('/') }}">
                    <span class="brand-mark"><img class="brand-mark-image" src="{{ asset('images/logo-mark.svg') }}" alt="CT" style="display:block;width:100%;height:100%"></span>
                    <span class="brand-logo">COACHTECH</span>
                </a>

                <div class="header-nav">
                    <form class="search-form" method="GET" action="{{ url('/') }}">
                        <input type="hidden" name="tab" value="{{ $activeTab ?? 'recommend' }}">
                        <input class="search" type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="なにをお探しですか？" aria-label="検索">
                    </form>
                    @if ($isHeaderLoggedIn)
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="header-link header-button">ログアウト</button>
                        </form>
                    @else
                        <a class="header-link" href="{{ route('login') }}">ログイン</a>
                    @endif
                    <a class="header-link" href="{{ route('mypage') }}">マイページ</a>
                    <a class="sell-btn" href="{{ route('items.create') }}">出品</a>
                </div>
            </header>

            <nav class="tab-row" aria-label="商品タブ">
                 <a class="tab {{ ($activeTab ?? 'recommend') === 'recommend' ? 'active' : '' }}" href="{{ url('/') }}?tab=recommend&keyword={{ urlencode($keyword ?? '') }}">おすすめ</a>
                 <a class="tab {{ ($activeTab ?? 'recommend') === 'mylist' ? 'active' : '' }}" href="{{ url('/') }}?tab=mylist&keyword={{ urlencode($keyword ?? '') }}">マイリスト</a>
            </nav>

            <main class="items">
                @foreach (($items ?? collect()) as $item)
                    <article class="item">
                        @php
                            $displayName = $item->name;
                            $rawImage = (string) ($item->image ?? '');
                            $isSoldForCurrentViewer = in_array($item->id, $soldItemIdsForViewer ?? [], true);

                            if ($rawImage === '') {
                                $itemImageUrl = $fallbackImage;
                            } elseif (Str::startsWith($rawImage, 'http')) {
                                $itemImageUrl = $rawImage;
                            } elseif (Str::startsWith($rawImage, ['images/', '/images/'])) {
                                $itemImageUrl = asset(ltrim($rawImage, '/'));
                            } else {
                                $itemImageUrl = asset('storage/' . ltrim($rawImage, '/'));
                            }
                        @endphp
                        <a class="item-link" href="{{ route('item.show', ['item_id' => $item->id]) }}">
                            @if ($isSoldForCurrentViewer)
                                <span class="sold-badge">Sold</span>
                            @endif
                            <img class="item-image" src="{{ $itemImageUrl }}" alt="{{ $displayName }}" onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                            <div class="item-name">{{ $displayName }}</div>
                        </a>
                    </article>
                @endforeach
            </main>
        </div>
    </body>
</html>
