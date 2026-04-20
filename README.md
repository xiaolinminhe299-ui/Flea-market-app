フリマアプリ
環境構築
A Dockerビルド

A-1 laravel-docker-template.gitをクローンしてリポジトリ名をFlea-market-appに変更。
git clone git@github.com:Estra-Coachtech/laravel-docker-template.git
mv laravel-docker-template Flea-market-app
cd Flea-market-app
git remote set-url origin git@github.com:xiaolinminhe299-ui/Flea-market-app.git

A-2 DockerDesktopアプリを立ち上げる
A-3 docker-compose up -d --build

B Laravel環境構築
B-1 docker-compose exec php bash
B-2 composer install
B-3「.env.example」ファイルを 「.env」ファイルに命名を変更
B-4 「.env」に以下の環境変数を追加
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

B-5 アプリケーションキーの作成
php artisan key:generate

B-6 マイグレーションの実行
php artisan migrate

B-7 シンボリックリンク作成
php artisan storage:link

B-8 シーディングの実行
php artisan db:seed

C使用技術(実行環境)
PHP 8.1.34
Laravel 8.83.8
MySQL 8.0.26

D テーブル設計
下記URLにあります。※No1からご確認いただけますと幸いです。
https://docs.google.com/spreadsheets/d/1K8Z7AhbqfS6dYOFTAKvTEAB_9e6FBeXhYynVsWhSDtQ/edit?gid=1188247583#gid=1188247583
E ER図
下記URLにあります。
https://docs.google.com/spreadsheets/d/1K8Z7AhbqfS6dYOFTAKvTEAB_9e6FBeXhYynVsWhSDtQ/edit?gid=1188247583#gid=1188247583

F URL
開発環境： http://localhost/
phpMyAdmin: http://localhost:8080/
