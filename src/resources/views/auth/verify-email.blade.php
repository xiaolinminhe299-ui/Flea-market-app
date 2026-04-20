<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>メール認証</title>
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
                background: #ffffff;
            }

            .brand-bar {
                display: flex;
                align-items: center;
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

            .content {
                display: flex;
                align-items: flex-start;
                justify-content: center;
                padding: 140px 16px 32px;
            }

            .notice {
                width: min(100%, 420px);
                text-align: center;
            }

            .message {
                margin: 0;
                font-size: 18px;
                font-weight: 700;
                line-height: 1.7;
            }

            .verify-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 160px;
                height: 44px;
                margin-top: 52px;
                padding: 0 24px;
                border: 1px solid #8a8a8a;
                border-radius: 4px;
                background: linear-gradient(#f6f6f6, #d9d9d9);
                box-shadow: inset 0 1px 0 #fff;
                color: #000;
                font-size: 16px;
                font-weight: 700;
                text-decoration: none;
            }

            .resend-link,
            .resend-button {
                display: inline-block;
                margin-top: 36px;
                padding: 0;
                border: 0;
                background: transparent;
                color: #3c8dde;
                font-size: 14px;
                text-decoration: none;
                cursor: pointer;
            }

            .resend-form {
                margin: 0;
            }

            @media (max-width: 520px) {
                .brand-bar {
                    height: 40px;
                    padding: 0 10px;
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

                .content {
                    padding-top: 112px;
                }

                .message {
                    font-size: 16px;
                }
            }
        </style>
    </head>
    <body>
        <div class="page">
            <div class="brand-bar">
                <a class="brand-logo-wrap" href="{{ url('/') }}">
                    <span class="brand-mark"><img class="brand-mark-image" src="{{ asset('images/logo-mark.svg') }}" alt="CT" style="display:block;width:100%;height:100%"></span>
                    <span class="brand-logo">COACHTECH</span>
                </a>
            </div>

            <main class="content">
                <section class="notice">
                    <p class="message">
                        登録していただいたメールアドレスに認証メールを送付しました。<br>
                        メール認証を完了してください。
                    </p>

                    <a class="verify-button" href="{{ route('profile.create', ['from_verify' => 1]) }}">認証はこちらから</a>

                    @if (Route::has('verification.send'))
                        <form class="resend-form" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button class="resend-button" type="submit">認証メールを再送する</button>
                        </form>
                    @else
                        <a class="resend-link" href="#">認証メールを再送する</a>
                    @endif
                </section>
            </main>
        </div>
    </body>
</html>
