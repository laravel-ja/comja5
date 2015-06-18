# comja5

A translation command for comments in files of laravel/laravel repository to Japanese. In addition

Laravel5のlaravel/laravelリポジトリーに含まれているファイルのコメントを日本語に翻訳します。

そのほか、おまけ機能として、タブの４空白変換とja言語ファイル生成ができます。

> 注意：コマンドはインストール直後のプロジェクトで実行してください。翻訳機能は英語の文字列を日本語へ変換しています。既にコーディングしたプロジェクトでは、意図しない箇所が変換される可能性があります。

### インストール

**プロジェクトのみにインストールする**

プロジェクトのルートディレクトリ(composer.jsonファイルがある場所)で実行してください。

~~~
composer require laravel-ja/comja5
~~~

修正後、composer updateを実行してください。

**グローバルにインストールする**

~~~
composer global require laravel-ja/comja5
~~~

ホームディレクトリーの.composer/vendor/binに実行パスが通っていることを確認してください。

> 注意："dev-master"は開発/デバッグ中のリポジトリのため、動作しないことがあります。

### 実行

コマンドの実行は、Laravelをインストールしたディレクトリーのトップで行います。

**プロジェクトにインストールした場合**

vendor/binの中にcomja5コマンドが作成されています。プロジェクトのルートディレクトリーで以下のように実行してください。オプションの説明が表示されます。

~~~
vendor/bin/comja5
~~~

**グローバルにインストールした場合**

~~~
comja5
~~~

Windowsの場合、コマンドがプロンプトやパワーシェルに出力するコードはSJISです。

翻訳したファイルの日本語はUTF8、改行コードは*nix形式です。

### 実行時オプション

#### -c もしくは --comment

laravel/laravelリポジトリーに含まれている、コメントを翻訳します。

#### -t[=空白数] もしくは --tab[=空白数]

タブを指定した数の空白に変換します。デフォルトは４文字です。

#### -f もしくは --file

日本語の言語ファイルをresouces/lang/jaディレクトリー下に生成します。

#### -r もしくは --remove

コメント行、空行を削除します。

#### -a もしくは --all

コメント翻訳、タブ変換、言語ファイル生成を実行します。

#### -A

コメント削除、タブ変換、言語ファイル生成を実行します。

### アンインストール

翻訳すれば、後は用済みです。インストール時にrequireセクションに付け加えたパッケージ指定を削除し、再度composer.jsonを実行します。

### 不具合の報告

GitHubでも良いですが、Twitterの@HiroKwsでも、Laravelに関するチャットを行っているlarachat-jp.slack.com（招待制：招待状はlarachat.jp@gmail.comまで）でも結構です。

### Licence/Rights

Copyright by Hirohisa Kawase

Licensed by MIT License
