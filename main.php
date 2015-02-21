<?php

include_once "vendor/autoload.php";

use Comja\Services\File;
use Comja\Processors\Converter;
use Comja\Services\Transformers\ToyBox;
use Comja\Repositories\CommentTranslationsRepo;
use Comja\Repositories\LangFilesTranslationsRepo;

// オプションの取り込み

$optsions = getopt( "ct::farA", ["comment", "tab::", "file", "remove", "all" ] );

if( count( $optsions ) < 1 )
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


// オプションをチェックしやすいようにシンプルに
if( isset( $optsions['c'] ) || isset( $optsions['comment'] ) )
{
    $opts['comment'] = true;
}

if( isset( $optsions['f'] ) || isset( $optsions['file'] ) )
{
    $opts['file'] = true;
}

if( isset( $optsions['t'] ) )
{
    $opts['tab'] = $optsions['t'];
}

if( isset( $optsions['tab'] ) )
{
    $opts['tab'] = $optsions['tab'];
}

if( isset( $optsions['f'] ) || isset( $optsions['file'] ) )
{
    $opts['file'] = true;
}

if( isset( $optsion['r'] ) || isset( $optsions['remove'] ) )
{
    $opts['remove'] = true;
}

if( isset( $optsion['a'] ) || isset( $optsion['all'] ) )
{
    $opts['all'] = true;
    $opts['comment'] = true;
    $opts['tab'] = true;
    $opts['file'] = true;
}

if( isset( $optsion['A'] ) )
{
    $opts['A'] = true;
    $opts['tab'] = true;
    $opts['file'] = true;
    $opts['remove'] = true;
}

var_dump( $opts ); die();

// オプションのバリデーション
// 変換処理

$file = new File();
$converter = new Converter( $file, new ToyBox(), new CommentTranslationsRepo( $file ),
    new LangFilesTranslationsRepo( $file ) );
$converter->format( $opts );

return 0;
