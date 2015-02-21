<?php

include_once "vendor/autoload.php";

use Comja\Services\File;
use Comja\Processors\Converter;
use Comja\Services\Transformers\ToyBox;
use Comja\Repositories\CommentTranslationsRepo;
use Comja\Repositories\LangFilesTranslationsRepo;

// オプションの取り込み

$options = getopt( "ct::farA", ["comment", "tab::", "file", "remove", "all" ] );

if( count( $options ) < 1 )
{
    fputs( STDERR, __( "オプション指定がありません。" ).PHP_EOL );
    print __( "使用法： comja [-c|--comment] [-t|--tab[=スペース数] [-f|--file] [-r|--remove] [-a|--all] [-A]" ).PHP_EOL;
    print __( "オプション：" ).PHP_EOL;
    print __( "-c --comment：コメント部分の翻訳" ).PHP_EOL;
    print __( "-t --tab：タブをスペースへ変換（デフォルト４空白）" ).PHP_EOL;
    print __( "-f --file：日本語言語ファイル生成" ).PHP_EOL;
    print __( "-r --remove：コメント／空行削除" ).PHP_EOL;
    print __( "-a --all：翻訳、タブ変換、言語ファイル追加を行います" ).PHP_EOL;
    print __( "-A：コメント削除、タブ変換、言語ファイル追加を行います" ).PHP_EOL;
}

$opt = [ ];

// オプションをチェックしやすいようにシンプルに
if( isset( $options['c'] ) || isset( $options['comment'] ) )
{
    $opt['comment'] = true;
}

if( isset( $options['f'] ) || isset( $options['file'] ) )
{
    $opt['file'] = true;
}

if( isset( $options['t'] ) )
{
    $opt['tab'] = $options['t'];
}

if( isset( $options['tab'] ) )
{
    $opt['tab'] = $options['tab'];
}

if( isset( $options['f'] ) || isset( $options['file'] ) )
{
    $opt['file'] = true;
}

if( isset( $option['r'] ) || isset( $options['remove'] ) )
{
    $opt['remove'] = true;
}

if( isset( $option['a'] ) || isset( $option['all'] ) )
{
    $opt['all'] = true;
    $opt['comment'] = true;
    $opt['tab'] = true;
    $opt['file'] = true;
}

if( isset( $option['A'] ) )
{
    $opt['A'] = true;
    $opt['tab'] = true;
    $opt['file'] = true;
    $opt['remove'] = true;
}


// オプションのバリデーション
// 変換処理

$file = new File();
$converter = new Converter( $file, new ToyBox(), new CommentTranslationsRepo( $file ),
    new LangFilesTranslationsRepo( $file ) );

$converter->format( $opt );

return 0;
