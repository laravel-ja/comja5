# comja5

A translation command for comments in files of laravel/laravel repository to Japanese. In addition

Laravel5のlaravel/laravelリポジトリーに含まれているファイルのコメントを日本語に翻訳します。

その他、おまけ機能として、タブの４空白変換とja言語ファイル生成ができます。

### インストール

composer.jsonのrequireセクションに以下の1行を加えてください。

~~~
"laravel-ja/comja5": "~1"
~~~

修正後、composer updateを行います。

### 実行

コマンドの実行は、Laravelをインストールしたディレクトリーのトップで行います。

**Linux/Mac:**

vendor/binの中にcomjaコマンドが作成されています。プロジェクトのルートディレクトリーで、それを実行してください。オプションの説明が表示されます。

~~~
vendor/bin/comja5
~~~

**Windows:**

環境がないため直接動作テストできていません。

コマンドプロンプトか、パワーシェルで実行してください。

~~~
php vendor\laravel-ja\comja5\main.php
~~~

変換する日本語はUTF8です。通常のプログラムエディターであれば、問題なく開けるかと思いますが、必要ならばファイルの文字形式を指定してください。

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

### Licence/Rights

Copyright by Hirohisa Kawase

Licensed by MIT License
