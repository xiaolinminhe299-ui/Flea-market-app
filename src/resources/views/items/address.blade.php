<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>住所の変更</title>
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

            /* ── Content ── */
            .content {
                padding: 40px 16px 64px;
            }

            .form-wrap {
                width: min(100%, 540px);
                margin: 0 auto;
            }

            .title {
                margin: 0 0 40px;
                text-align: center;
                font-size: 22px;
                font-weight: 700;
            }

            .field {
                margin-bottom: 28px;
            }

            .field label {
                display: block;
                margin-bottom: 8px;
                font-size: 13px;
                font-weight: 700;
            }

            .field input {
                width: 100%;
                height: 40px;
                padding: 0 12px;
                border: 1px solid #bcbcbc;
                background: #fff;
                font-size: 14px;
                font-family: inherit;
                outline: none;
            }

            .field input.error {
                border-color: #ff5555;
            }

            .error-text {
                margin-top: 6px;
                color: #ff5555;
                font-size: 11px;
                font-weight: 700;
            }

            .submit {
                display: block;
                width: 100%;
                height: 44px;
                margin-top: 48px;
                border: 0;
                border-radius: 4px;
                background: #ff5555;
                color: #fff;
                font-size: 15px;
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

                .search { order: 3; width: 100%; }
            }
        </style>
    </head>
    <body>
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
            <div class="form-wrap">
                <h1 class="title">住所の変更</h1>

                <form method="POST" action="{{ route('purchase.address.update', ['item_id' => ($itemId ?? session('purchase_item_id'))]) }}">
                    @csrf

                    <div class="field">
                        <label for="postal_code">郵便番号</label>
                        <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code', $postalCode ?? '') }}" class="@error('postal_code') error @enderror">
                        @error('postal_code')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="address">住所</label>
                        <input id="address" type="text" name="address" value="{{ old('address', $address ?? '') }}" class="@error('address') error @enderror">
                        @error('address')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="building">建物名</label>
                        <input id="building" type="text" name="building" value="{{ old('building', $building ?? '') }}" class="@error('building') error @enderror">
                        @error('building')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="submit">更新する</button>
                </form>
            </div>
        </main>
    </body>
</html>
