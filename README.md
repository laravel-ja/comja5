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

vendor/binの中にcomjaコマンドが作成されます。プロジェクトのルートディレクトリーで、それを実行してください。オプションの説明が表示されます。

**Linux/Mac:**

~~~
vendor/bin/comja
~~~

**Windows:**

~~~
vendor/bin/comja.bat
~~~

### 実行時オプション

#### -c もしくは --comment

laravel/laravelリポジトリーに含まれている、コメントを翻訳します。

#### -t もしくは --tab

タブを空白４つに変換します。

#### -f もしくは --file

日本語の言語ファイルをresouces/lang/jaディレクトリー下に生成します。

#### -a もしくは --all

上記３機能をまとめて実行します。

### アンインストール

翻訳すれば、後は用済みです。インストール時にrequireセクションに付け加えたパッケージ指定を削除し、再度composer.jsonを実行します。

### Licence/Rights

Copyright by Hirohisa Kawase

Licensed by MIT License
