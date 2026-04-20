<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>購入確認</title>
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

            .content {
                display: flex;
                gap: 60px;
                width: 100%;
                margin: 0 auto;
                padding: 52px 48px 80px;
            }

            .left {
                flex: 1;
                min-width: 0;
            }

            .right {
                flex: 0 0 500px;
            }

            .item-row {
                display: flex;
                align-items: flex-start;
                gap: 28px;
                padding-top: 14px;
                padding-bottom: 44px;
                border-bottom: 1px solid #8d8d8d;
            }

            .thumb {
                width: 140px;
                height: 140px;
                background: #cfcfd1;
                display: grid;
                place-items: center;
                font-size: 20px;
                color: #555;
            }

            .item-name {
                margin: 0 0 8px;
                font-size: 34px;
                font-weight: 700;
                line-height: 1;
            }

            .item-price {
                margin: 0;
                font-size: 30px;
                font-weight: 400;
                line-height: 1;
            }

            .section {
                border-bottom: 1px solid #8d8d8d;
                padding: 26px 0 24px;
            }

            .label-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 18px;
            }

            .label {
                margin: 0;
                font-size: 30px;
                font-weight: 700;
                line-height: 1;
            }

            .change {
                font-size: 28px;
                color: #0073cc;
                text-decoration: none;
                line-height: 1;
            }

            .payment-select {
                width: 340px;
                height: 52px;
                border: 1px solid #8d8d8d;
                background: #fff;
                font-size: 20px;
                padding: 0 8px;
            }

            .payment-section {
                padding-top: 34px;
                padding-bottom: 34px;
            }

            .address {
                padding-left: 52px;
                line-height: 1.8;
                font-size: 30px;
                font-weight: 700;
            }

            .summary {
                border: 1px solid #8d8d8d;
                margin-bottom: 48px;
            }

            .summary-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                min-height: 100px;
                padding: 0 36px;
                border-bottom: 1px solid #8d8d8d;
                font-size: 30px;
            }

            .summary-row span {
                white-space: nowrap;
            }

            .summary-row:last-child {
                border-bottom: 0;
            }

            .buy-btn {
                display: block;
                width: 100%;
                height: 68px;
                border-radius: 4px;
                border: 0;
                background: #ff5555;
                color: #fff;
                font-size: 42px;
                font-weight: 700;
                line-height: 68px;
                text-align: center;
                text-decoration: none;
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

                .content {
                    flex-direction: column;
                    gap: 24px;
                    padding-top: 20px;
                }

                .right {
                    flex: none;
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

                    <nav class="nav">
                        <a class="nav-link" href="#">ログアウト</a>
                        <a class="nav-link" href="#">マイページ</a>
                        <a class="sell-btn" href="#">出品</a>
                    </nav>
                </div>
            </header>

            <main class="content">
                <section class="left">
                    <div class="item-row">
                        <div class="thumb">商品画像</div>
                        <div>
                            <h1 class="item-name">商品名</h1>
                            <p class="item-price">￥47,000</p>
                        </div>
                    </div>

                    <div class="section payment-section">
                        <h2 class="label">支払い方法</h2>
                        <div style="margin-top: 22px; padding-left: 52px;">
                            <select class="payment-select" name="payment_method">
                                <option>コンビニ払い</option>
                                <option>カード支払い</option>
                            </select>
                        </div>
                    </div>

                    <div class="section">
                        <div class="label-row">
                            <h2 class="label">配送先</h2>
                            <a class="change" href="#">変更する</a>
                        </div>
                        <div class="address">
                            〒 XXX-YYYY<br>
                            ここには住所と建物が入ります
                        </div>
                    </div>
                </section>

                <aside class="right">
                    <div class="summary">
                        <div class="summary-row">
                            <span>商品代金</span>
                            <span>￥47,000</span>
                        </div>
                        <div class="summary-row">
                            <span>支払い方法</span>
                            <span>コンビニ払い</span>
                        </div>
                    </div>

                    <a class="buy-btn" href="#">購入する</a>
                </aside>
            </main>
        </div>
    </body>
</html>
