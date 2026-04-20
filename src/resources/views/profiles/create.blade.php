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
                background: #fff;
                color: #000;
            }

            .page {
                min-height: 100vh;
                background: #fff;
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
                padding: 48px 16px 64px;
            }

            .form-wrap {
                width: min(100%, 420px);
                margin: 0 auto;
            }

            .title {
                margin: 0 0 36px;
                text-align: center;
                font-size: 24px;
                font-weight: 700;
            }

            .status {
                margin: 0 0 20px;
                color: #0a7a35;
                font-size: 13px;
                font-weight: 700;
                text-align: center;
            }

            .avatar-row {
                display: flex;
                align-items: center;
                gap: 24px;
                margin-bottom: 32px;
            }

            .avatar {
                width: 96px;
                height: 96px;
                border-radius: 50%;
                background: #d9d9d9;
                object-fit: cover;
                flex-shrink: 0;
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
                cursor: pointer;
            }

            .image-input {
                display: none;
            }

            .field {
                margin-bottom: 22px;
            }

            .field label {
                display: block;
                margin-bottom: 8px;
                font-size: 14px;
                font-weight: 700;
            }

            .field input {
                width: 100%;
                height: 44px;
                padding: 0 12px;
                border: 1px solid #bcbcbc;
                background: #fff;
                font-size: 14px;
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
                width: 100%;
                height: 44px;
                margin-top: 28px;
                border: 0;
                background: #ff5555;
                color: #fff;
                font-size: 16px;
                font-weight: 700;
                cursor: pointer;
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

                .title {
                    font-size: 20px;
                }

                .avatar-row {
                    gap: 16px;
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
                <div class="form-wrap">
                    <h1 class="title">プロフィール設定</h1>

                    @if (session('status') === 'profile-saved')
                        <p class="status">プロフィールを更新しました。</p>
                    @endif

                    <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="avatar-row">
                            <div id="avatar-preview">
                                @if ($profile && $profile->image)
                                    <img class="avatar" src="{{ asset('storage/' . $profile->image) }}" alt="プロフィール画像">
                                @else
                                    <div class="avatar-placeholder"></div>
                                @endif
                            </div>

                            <label class="image-label" for="image">画像を選択する</label>
                            <input class="image-input" id="image" type="file" name="image" accept="image/*">
                        </div>
                        @error('image')
                            <div class="error-text">{{ $message }}</div>
                        @enderror

                        <div class="field">
                            <label for="name">ユーザー名</label>
                            <input id="name" type="text" name="name" value="{{ old('name', ($forceEmptyName ?? false) ? '' : ($user->name ?? '')) }}" class="@error('name') error @enderror">
                            @error('name')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="postal_code">郵便番号</label>
                            <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code', optional($profile)->postal_code) }}" class="@error('postal_code') error @enderror">
                            @error('postal_code')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="address">住所</label>
                            <input id="address" type="text" name="address" value="{{ old('address', optional($profile)->address) }}" class="@error('address') error @enderror">
                            @error('address')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="building">建物名</label>
                            <input id="building" type="text" name="building" value="{{ old('building', optional($profile)->building) }}" class="@error('building') error @enderror">
                            @error('building')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="submit" type="submit">更新する</button>
                    </form>
                </div>
            </main>
        </div>
        <script>
            (function () {
                const fileInput = document.getElementById('image');
                const avatarPreview = document.getElementById('avatar-preview');

                if (!fileInput || !avatarPreview) {
                    return;
                }

                const initialMarkup = avatarPreview.innerHTML;
                let activeObjectUrl = null;

                fileInput.addEventListener('change', function (event) {
                    const [file] = event.target.files || [];

                    if (activeObjectUrl) {
                        URL.revokeObjectURL(activeObjectUrl);
                        activeObjectUrl = null;
                    }

                    if (!file || !file.type.startsWith('image/')) {
                        avatarPreview.innerHTML = initialMarkup;
                        return;
                    }

                    const previewImage = document.createElement('img');
                    previewImage.className = 'avatar';
                    previewImage.alt = 'プロフィール画像プレビュー';

                    activeObjectUrl = URL.createObjectURL(file);
                    previewImage.onload = function () {
                        if (activeObjectUrl) {
                            URL.revokeObjectURL(activeObjectUrl);
                            activeObjectUrl = null;
                        }
                    };
                    previewImage.src = activeObjectUrl;

                    avatarPreview.innerHTML = '';
                    avatarPreview.appendChild(previewImage);
                });
            })();
        </script>
    </body>
</html>
