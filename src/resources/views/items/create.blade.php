<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>商品の出品</title>
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
            }

            .logout-form {
                margin: 0;
            }

            .logout-btn {
                border: none;
                background: transparent;
                padding: 0;
                color: #fff;
                font-size: 12px;
                cursor: pointer;
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

            .content {
                width: min(100%, 1540px);
                margin: 0 auto;
                padding: 48px 16px 32px;
            }

            .form-wrap {
                width: min(100%, 620px);
                margin: 0 auto;
            }

            .title {
                margin: 0 0 34px;
                text-align: center;
                font-size: 24px;
                font-weight: 700;
            }

            .label {
                display: block;
                margin-bottom: 8px;
                font-size: 12px;
                font-weight: 700;
            }

            .image-box {
                margin-bottom: 22px;
            }

            .image-area {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 120px;
                border: 1px dashed #bcbcbc;
                background: #f2f2f2;
                overflow: hidden;
            }

            .image-preview {
                display: none;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .image-area.has-preview .image-preview {
                display: block;
            }

            .image-area.has-preview .image-btn {
                position: absolute;
                right: 8px;
                bottom: 8px;
                min-width: auto;
                height: 30px;
                padding: 0 10px;
                background: rgba(255, 255, 255, 0.92);
            }

            .image-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 140px;
                height: 36px;
                border: 1px solid #ff5555;
                border-radius: 8px;
                color: #ff5555;
                font-size: 12px;
                font-weight: 700;
                text-decoration: none;
                cursor: pointer;
            }

            .image-input {
                display: none;
            }

            .section {
                margin-bottom: 22px;
            }

            .section-title {
                margin: 0 0 8px;
                padding-bottom: 6px;
                border-bottom: 1px solid #bcbcbc;
                color: #666;
                font-size: 18px;
                font-weight: 700;
            }

            .field {
                margin-bottom: 14px;
            }

            .field-name {
                display: block;
                margin-bottom: 7px;
                font-size: 12px;
                font-weight: 700;
            }

            .chips {
                display: grid;
                grid-template-columns: repeat(6, minmax(0, 1fr));
                gap: 8px;
            }

            .chip {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 24px;
                padding: 0 12px;
                border: 1px solid #ff5555;
                border-radius: 999px;
                color: #ff5555;
                font-size: 11px;
                text-decoration: none;
                cursor: pointer;
            }

            .chip input {
                display: none;
            }

            .chip.selected {
                background: #ff5555;
                color: #fff;
            }

            .chip.no-wrap {
                white-space: nowrap;
            }

            .select,
            .text,
            .textarea,
            .price-input {
                width: 100%;
                border: 1px solid #bcbcbc;
                background: #fff;
                font-size: 13px;
                outline: none;
            }

            .select,
            .text,
            .price-input {
                height: 32px;
                padding: 0 10px;
            }

            .textarea {
                height: 86px;
                padding: 8px 10px;
                resize: none;
            }

            .price-wrap {
                position: relative;
            }

            .price-mark {
                position: absolute;
                left: 8px;
                top: 50%;
                transform: translateY(-50%);
                font-size: 12px;
            }

            .price-input {
                padding-left: 22px;
            }

            .select.error,
            .text.error,
            .textarea.error,
            .price-input.error {
                border-color: #ff5555;
            }

            .error-text {
                margin-top: 6px;
                color: #ff5555;
                font-size: 11px;
                font-weight: 700;
            }

            .status {
                margin: 0 0 16px;
                color: #0073cc;
                font-size: 12px;
                text-align: center;
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

            @media (min-width: 1400px) and (max-width: 1540px) {
                .header-inner,
                .content {
                    width: min(100%, 1500px);
                }

                .search {
                    width: 320px;
                }
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

                .form-wrap {
                    width: 100%;
                }

                .chips {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }
        </style>
    </head>
    <body>
        <div class="page">
            <header class="header">
                <div class="header-inner">
                    <a class="logo-wrap" href="/">
                        <span class="logo-mark"><img class="logo-mark-image" src="{{ asset('images/logo-mark.svg') }}" alt="CT" style="display:block;width:100%;height:100%"></span>
                        <span class="logo-text">COACHTECH</span>
                    </a>

                    <input class="search" type="text" placeholder="なにをお探しですか？" aria-label="検索">

                    <nav class="nav">
                        <form class="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-btn">ログアウト</button>
                        </form>
                        <a class="nav-link" href="{{ route('mypage') }}">マイページ</a>
                        <a class="sell-btn" href="{{ route('items.create') }}">出品</a>
                    </nav>
                </div>
            </header>

            <main class="content">
                <div class="form-wrap">
                    <h1 class="title">商品の出品</h1>

                    @if (session('status') === 'item-listed')
                        <p class="status">商品を出品しました。</p>
                    @endif

                    @php
                        $categories = ['ファッション', '家電', 'インテリア', 'レディース', 'メンズ', 'コスメ', '本', 'ゲーム', 'スポーツ', 'キッチン', 'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'];
                        $selectedCategories = old('categories', []);
                    @endphp

                    <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
                        @csrf

                    <div class="image-box">
                        <label class="label">商品画像</label>
                        <div class="image-area" id="image-area">
                            <img class="image-preview" id="image-preview" alt="選択した商品画像のプレビュー">
                            <label class="image-btn" for="image">画像を選択する</label>
                            <input class="image-input" id="image" type="file" name="image" accept="image/*">
                        </div>
                        @error('image')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <section class="section">
                        <h2 class="section-title">商品の詳細</h2>

                        <div class="field">
                            <label class="field-name">カテゴリー</label>
                            <div class="chips">
                                @foreach ($categories as $category)
                                    <label class="chip {{ in_array($category, $selectedCategories, true) ? 'selected' : '' }} {{ $category === 'ベビー・キッズ' ? 'no-wrap' : '' }}">
                                        <input type="checkbox" name="categories[]" value="{{ $category }}" {{ in_array($category, $selectedCategories, true) ? 'checked' : '' }}>
                                        {{ $category }}
                                    </label>
                                @endforeach
                            </div>
                            @error('categories')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="field-name">商品の状態</label>
                            <select class="select @error('condition') error @enderror" name="condition">
                                <option value="">選択してください</option>
                                <option value="新品・未使用" {{ old('condition') === '新品・未使用' ? 'selected' : '' }}>新品・未使用</option>
                                <option value="未使用に近い" {{ old('condition') === '未使用に近い' ? 'selected' : '' }}>未使用に近い</option>
                                <option value="目立った傷や汚れなし" {{ old('condition') === '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                            </select>
                            @error('condition')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </section>

                    <section class="section">
                        <h2 class="section-title">商品名と説明</h2>

                        <div class="field">
                            <label class="field-name">商品名</label>
                            <input class="text @error('name') error @enderror" type="text" name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="field-name">ブランド名</label>
                            <input class="text" type="text" name="brand" value="{{ old('brand') }}">
                        </div>

                        <div class="field">
                            <label class="field-name">商品の説明</label>
                            <textarea class="textarea @error('description') error @enderror" name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="field-name">販売価格</label>
                            <div class="price-wrap">
                                <span class="price-mark">¥</span>
                                <input class="price-input @error('price') error @enderror" type="text" name="price" value="{{ old('price') }}">
                            </div>
                            @error('price')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </section>

                    <button class="submit" type="submit">出品する</button>
                    </form>
                </div>
            </main>
        </div>
        <script>
            (function () {
                const fileInput = document.getElementById('image');
                const previewImage = document.getElementById('image-preview');
                const imageArea = document.getElementById('image-area');
                const categoryInputs = document.querySelectorAll('.chip input[type="checkbox"]');

                if (!fileInput || !previewImage || !imageArea) {
                    return;
                }

                fileInput.addEventListener('change', function (event) {
                    const [file] = event.target.files || [];

                    if (!file || !file.type.startsWith('image/')) {
                        previewImage.removeAttribute('src');
                        imageArea.classList.remove('has-preview');
                        return;
                    }

                    const objectUrl = URL.createObjectURL(file);
                    previewImage.onload = function () {
                        URL.revokeObjectURL(objectUrl);
                    };
                    previewImage.src = objectUrl;
                    imageArea.classList.add('has-preview');
                });

                categoryInputs.forEach(function (input) {
                    const chip = input.closest('.chip');

                    if (!chip) {
                        return;
                    }

                    chip.classList.toggle('selected', input.checked);

                    input.addEventListener('change', function () {
                        chip.classList.toggle('selected', input.checked);
                    });
                });
            })();
        </script>
    </body>
</html>
