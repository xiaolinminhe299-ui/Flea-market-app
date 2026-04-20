<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>購入手続き</title>
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
            .header { background: #000; }

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
            .logo-mark-t { display: block; }

            .logo-mark-t { margin-left: -3px; }

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
                gap: 40px;
                width: min(100%, 960px);
                margin: 0 auto;
                padding: 40px 16px 64px;
                align-items: flex-start;
            }

            .col-main {
                flex: 1;
                min-width: 0;
            }

            .col-side {
                flex: 0 0 260px;
            }

            /* ── Item summary ── */
            .item-row {
                display: flex;
                align-items: center;
                gap: 16px;
                padding-bottom: 20px;
                border-bottom: 1px solid #bcbcbc;
            }

            .item-thumb {
                display: grid;
                place-items: center;
                width: 100px;
                height: 100px;
                background: #d2d2d2;
                font-size: 11px;
                color: #555;
                flex-shrink: 0;
                overflow: hidden;
            }

            .item-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .item-info {}

            .item-name {
                margin: 0 0 8px;
                font-size: 16px;
                font-weight: 700;
            }

            .item-price {
                margin: 0;
                font-size: 16px;
                font-weight: 700;
            }

            /* ── Sections ── */
            .section {
                padding: 20px 0;
                border-bottom: 1px solid #bcbcbc;
            }

            .section-title {
                margin: 0 0 14px;
                font-size: 13px;
                font-weight: 700;
            }

            /* Payment method */
            .select-wrap {
                position: relative;
                display: inline-block;
                width: 200px;
            }

            .select-wrap select {
                width: 100%;
                height: 32px;
                padding: 0 28px 0 10px;
                border: 1px solid #bcbcbc;
                background: #fff;
                font-size: 12px;
                font-family: inherit;
                appearance: none;
                -webkit-appearance: none;
                cursor: pointer;
                outline: none;
            }

            .select-wrap select.error {
                border-color: #ff5555;
            }

            .select-wrap::after {
                content: "▼";
                position: absolute;
                right: 8px;
                top: 50%;
                transform: translateY(-50%);
                font-size: 10px;
                pointer-events: none;
                color: #555;
            }

            /* Shipping address */
            .address-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 14px;
            }

            .address-header .section-title {
                margin: 0;
            }

            .change-link {
                font-size: 12px;
                color: #ff5555;
                text-decoration: none;
            }

            .address-body {
                padding-left: 16px;
                font-size: 13px;
                line-height: 1.8;
            }

            .error-text {
                margin-top: 8px;
                color: #ff5555;
                font-size: 11px;
                font-weight: 700;
            }

            .status {
                margin: 0 0 12px;
                color: #0073cc;
                font-size: 12px;
                font-weight: 700;
            }

            /* ── Side panel ── */
            .summary-box {
                border: 1px solid #bcbcbc;
            }

            .summary-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px 20px;
                font-size: 13px;
                border-bottom: 1px solid #bcbcbc;
            }

            .summary-row:last-child {
                border-bottom: none;
            }

            .summary-label {
                font-weight: 700;
            }

            .summary-value {
                font-weight: 700;
            }

            .buy-btn {
                display: block;
                width: 100%;
                height: 40px;
                margin-top: 16px;
                border: 0;
                border-radius: 4px;
                background: #ff5555;
                color: #fff;
                font-size: 15px;
                font-weight: 700;
                text-align: center;
                line-height: 40px;
                text-decoration: none;
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

                .search { order: 3; width: 100%; }

                .content {
                    flex-direction: column;
                    gap: 24px;
                    padding: 20px 16px 48px;
                }

                .col-side {
                    flex: none;
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        @php
            $rawItemImage = data_get($item, 'image');
            $itemImageUrl = null;

            if (!empty($rawItemImage)) {
                $itemImageUrl = preg_match('/^https?:\/\//', (string) $rawItemImage)
                    ? $rawItemImage
                    : asset('storage/' . ltrim((string) $rawItemImage, '/'));
            }
        @endphp

        <header class="header">
            <div class="header-inner">
                <a class="logo-wrap" href="{{ url('/') }}">
                    <span class="logo-mark"><img class="logo-mark-image" src="{{ asset('images/logo-mark.svg') }}" alt="CT" style="display:block;width:100%;height:100%"></span>
                    <span class="logo-text">COACHTECH</span>
                </a>

                <input class="search" type="text" placeholder="なにをお探しですか？" aria-label="検索">

                <nav class="nav">
                    @auth
                        <form class="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-btn">ログアウト</button>
                        </form>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                    @endauth
                    <a class="nav-link" href="{{ route('mypage') }}">マイページ</a>
                    <a class="sell-btn" href="{{ route('items.create') }}">出品</a>
                </nav>
            </div>
        </header>

        <main class="content">
            <form method="POST" action="{{ route('purchase.store', ['item_id' => ($itemId ?? $item->id)]) }}" style="display: contents;">
                @csrf
            <!-- 左：入力エリア -->
            <div class="col-main">
                <!-- 商品情報 -->
                <div class="item-row">
                    <div class="item-thumb">
                        @if ($itemImageUrl)
                            <img src="{{ $itemImageUrl }}" alt="{{ $item->name }}">
                        @else
                            商品画像
                        @endif
                    </div>
                    <div class="item-info">
                        <p class="item-name">{{ $item->name }}</p>
                        <p class="item-price">￥{{ number_format($item->price) }}</p>
                    </div>
                </div>

                <!-- 支払い方法 -->
                <div class="section">
                    <h2 class="section-title">支払い方法</h2>
                    @if (session('status') === 'purchase-complete')
                        <p class="status">購入が完了しました。</p>
                    @endif
                    <div class="select-wrap">
                        <select name="payment_method" class="@error('payment_method') error @enderror">
                            <option value="">選択してください</option>
                            <option value="convenience" {{ old('payment_method', session('purchase_payment_method', 'convenience')) === 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                            <option value="card" {{ old('payment_method', session('purchase_payment_method')) === 'card' ? 'selected' : '' }}>カード払い</option>
                        </select>
                    </div>
                    @error('payment_method')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 配送先 -->
                <div class="section">
                    <div class="address-header">
                        <h2 class="section-title">配送先</h2>
                        <a class="change-link" href="{{ route('purchase.address', ['item_id' => ($itemId ?? $item->id)]) }}">変更する</a>
                    </div>
                    <div class="address-body">
                        <div>〒 {{ $postalCode }}</div>
                        <div>{{ $address }}</div>
                        @if (!empty($building))
                            <div>{{ $building }}</div>
                        @endif
                    </div>
                    <input type="hidden" name="postal_code" value="{{ $postalCode }}">
                    <input type="hidden" name="address" value="{{ $address }}">
                    <input type="hidden" name="building" value="{{ $building ?? '' }}">
                    <input type="hidden" name="shipping_address" value="{{ trim($postalCode . ' ' . $address . ' ' . ($building ?? '')) }}">
                    @error('shipping_address')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- 右：サマリー -->
            <div class="col-side">
                <div class="summary-box">
                    <div class="summary-row">
                        <span class="summary-label">商品代金</span>
                        <span class="summary-value">￥{{ number_format($item->price) }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">支払い方法</span>
                        <span class="summary-value">{{ $paymentLabel }}</span>
                    </div>
                </div>

                <button class="buy-btn" type="submit">購入する</button>
            </div>
            </form>
        </main>
    </body>
</html>
