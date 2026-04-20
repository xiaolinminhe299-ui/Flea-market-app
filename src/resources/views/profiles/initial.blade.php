<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>プロフィール設定</title>
        <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: Arial, sans-serif;
                background: #ffffff;
                color: #000;
            }

            .page {
                min-height: 100vh;
            }

            .header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                height: 46px;
                padding: 0 14px;
                background: #000;
            }

            .logo {
                flex-shrink: 0;
                width: 180px;
                text-decoration: none;
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
                display: block;
                color: #fff;
                font-size: 20px;
                font-weight: 700;
                letter-spacing: 1px;
                line-height: 1;
                text-decoration: none;
            }

            .search {
                width: min(100%, 360px);
                height: 30px;
                padding: 0 12px;
                border: 0;
                border-radius: 4px;
                font-size: 14px;
            }

            .nav {
                display: flex;
                align-items: center;
                gap: 20px;
                flex-shrink: 0;
            }

            .nav-link {
                color: #fff;
                font-size: 15px;
                text-decoration: none;
            }

            .sell-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 52px;
                height: 30px;
                border-radius: 4px;
                background: #fff;
                color: #000;
                font-size: 14px;
                text-decoration: none;
            }

            .content {
                padding: 48px 16px 32px;
            }

            .form-wrap {
                width: min(100%, 372px);
                margin: 0 auto;
            }

            .title {
                margin: 0 0 34px;
                text-align: center;
                font-size: 24px;
                font-weight: 700;
            }

            .avatar-row {
                display: flex;
                align-items: center;
                gap: 24px;
                margin-bottom: 22px;
            }

            .avatar-placeholder {
                width: 96px;
                height: 96px;
                border-radius: 50%;
                background: #d9d9d9;
                flex-shrink: 0;
            }

            .image-label {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 140px;
                height: 42px;
                padding: 0 16px;
                border: 1px solid #ff5555;
                border-radius: 8px;
                color: #ff5555;
                font-size: 14px;
                font-weight: 700;
                text-decoration: none;
            }

            .field {
                margin-bottom: 20px;
            }

            .field label {
                display: block;
                margin-bottom: 8px;
                font-size: 12px;
                font-weight: 700;
            }

            .field input {
                width: 100%;
                height: 32px;
                padding: 0 10px;
                border: 1px solid #bcbcbc;
                background: #fff;
                font-size: 13px;
                outline: none;
            }

            .submit {
                width: 100%;
                height: 36px;
                margin-top: 44px;
                border: 0;
                background: #ff5555;
                color: #fff;
                font-size: 14px;
                font-weight: 700;
                cursor: pointer;
            }

            @media (max-width: 900px) {
                .header {
                    flex-wrap: wrap;
                    height: auto;
                    padding: 8px 12px;
                }

                .logo {
                    width: 150px;
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

                .nav {
                    gap: 12px;
                    margin-left: auto;
                }

                .title {
                    font-size: 20px;
                }
            }

            @media (max-width: 520px) {
                .content {
                    padding-top: 36px;
                }

                .avatar-row {
                    gap: 16px;
                }
            }
        </style>
    </head>
    <body>
        <div class="page">
            <header class="header">
                <a class="logo" href="/">
                    <span class="logo-wrap">
                        <span class="logo-mark"><img class="logo-mark-image" src="{{ asset('images/logo-mark.svg') }}" alt="CT" style="display:block;width:100%;height:100%"></span>
                        <span class="logo-text">COACHTECH</span>
                    </span>
                </a>

                <input class="search" type="text" placeholder="なにをお探しですか？" aria-label="検索">

                <nav class="nav">
                    <a class="nav-link" href="#">ログアウト</a>
                    <a class="nav-link" href="#">マイページ</a>
                    <a class="sell-btn" href="{{ route('items.create') }}">出品</a>
                </nav>
            </header>

            <main class="content">
                <div class="form-wrap">
                    <h1 class="title">プロフィール設定</h1>

                    <form>
                        <div class="avatar-row">
                            <div class="avatar-placeholder"></div>
                            <a class="image-label" href="#">画像を選択する</a>
                        </div>

                        <div class="field">
                            <label for="name">ユーザー名</label>
                            <input id="name" type="text" name="name">
                        </div>

                        <div class="field">
                            <label for="postal_code">郵便番号</label>
                            <input id="postal_code" type="text" name="postal_code">
                        </div>

                        <div class="field">
                            <label for="address">住所</label>
                            <input id="address" type="text" name="address">
                        </div>

                        <div class="field">
                            <label for="building">建物名</label>
                            <input id="building" type="text" name="building">
                        </div>

                        <button class="submit" type="submit">更新する</button>
                    </form>
                </div>
            </main>
        </div>
    </body>
</html>
