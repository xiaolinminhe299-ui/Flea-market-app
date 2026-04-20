<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>会員登録</title>
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
                width: 100%;
                min-height: 100vh;
                margin: 0;
                padding: 0;
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

            .card {
                background: #ffffff;
                padding: 48px 16px 32px;
            }

            .form-wrap {
                width: min(100%, 372px);
                margin: 0 auto;
            }

            .form-title {
                margin: 0 0 34px;
                text-align: center;
                font-size: 24px;
                font-weight: 700;
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
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 36px;
                margin-top: 44px;
                border: 0;
                background: #ff5555;
                color: #fff;
                font-size: 14px;
                font-weight: 700;
                cursor: pointer;
                text-decoration: none;
            }

            .login-link {
                display: block;
                margin-top: 14px;
                text-align: center;
                color: #3c8dde;
                font-size: 12px;
                text-decoration: none;
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

                .card {
                    padding-top: 36px;
                }

                .form-title {
                    font-size: 20px;
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

            <main class="card">
                <div class="form-wrap">
                    <h2 class="form-title">会員登録</h2>

                    @if ($errors->has('csrf'))
                        <div class="error-text" style="margin-bottom: 12px;">{{ $errors->first('csrf') }}</div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf

                        <div class="field">
                            <label for="name">ユーザー名</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" class="@error('name') error @enderror">
                            @error('name')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="email">メールアドレス</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="@error('email') error @enderror">
                            @error('email')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password">パスワード</label>
                            <input id="password" type="password" name="password" class="@error('password') error @enderror">
                            @error('password')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password_confirmation">確認用パスワード</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="@error('password') error @enderror">
                        </div>

                        <button class="submit" type="submit">登録する</button>
                    </form>

                    <a class="login-link" href="{{ route('login') }}">ログインはこちら</a>
                </div>
            </main>
        </div>
    </body>
</html>
