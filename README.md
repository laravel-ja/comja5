# comja5

A translator command for comments in files of laravel/laravel repository to Japanese.

Laravel5のlaravel/laravelリポジトリーに含まれているファイルのコメントを日本語に翻訳します。

本当はsedで十分なのですが、Windows環境も考慮し、PHPで変換しています。

### インストール

composer.jsonのrequireセクションに以下の1行を加えてください。

~~~
"laravel-ja/comja5": "~1"
~~~

修正後、composer updateを行います。

### 実行

vendor/binの中にcomjaコマンドが作成されます。プロジェクトのルートディレクトリーで、それを実行してください。

**Linux/Mac:**

~~~
vendor/bin/comja
~~~

**Windows:**

~~~
vendor/bin/comja.bat
~~~

### アンインストール

翻訳すれば、後は用済みです。インストール時にrequireセクションに付け加えたパッケージ指定を削除し、再度composer.jsonを実行します。

### Licence/Rights

Copyright by Hirohisa Kawase
Licensed by MIT License
