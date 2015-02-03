<?php

include_once "vendor/autoload.php";

use Comja\Repositories\TranslationRepo;
use Comja\Services\Translator;
use Comja\Services\File;

// オプションの取り込み

$options = getopt( "ctf", ["comment", "tab", "file" ] ); var_dump( $options );
if( $options === false || count( $options ) < 1 )
{
    fputs( STDERR, "オプション指定がありません。".PHP_EOL );
    print "使用法： comja [-c|--comment] [-t|--tab] [-f|--file] [-a|--all]".PHP_EOL;
    print "オプション：".PHP_EOL;
    print "-c --cooment：コメント部分の翻訳".PHP_EOL;
    print "-t --tab：タブを4スペースへ変換".PHP_EOL;
    print "-f --file：日本語言語ファイル生成".PHP_EOL;
    print "-a --all：上記の3アクションを行います".PHP_EOL;
}
if( array_key_exists( 'c', $options ) || array_key_exists( 'comment', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) )
{
    print '翻訳開始…'.PHP_EOL;

    $translationRepo = new TranslationRepo();
    $translations = $translationRepo->get();

    $translator = new Translator;
    $translator->trans( $translations );

    print '翻訳終了'.PHP_EOL;
}

if( array_key_exists( 't', $options ) || array_key_exists( 'tab', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) )
{
    print 'タブ変換開始…'.PHP_EOL;

    $file = new File();
    $files = $file->globAll( __DIR__.'/../../../app', '*' );
    $files[] = $file->globAll( __DIR__.'/../../../bootstrap', '*' );
    $files[] = $file->globAll( __DIR__.'/../../../config', '*' );
    $files[] = $file->globAll( __DIR__.'/../../../database', '*' );
    $files[] = $file->globAll( __DIR__.'/../../../resources/lang', '*' );
    $files[] = $file->globAll( __DIR__.'/../../../resources/views', '*' );
    $files[] = $file->globAll( __DIR__.'/../../../tests', '*' );
    $files[] = [ __DIR__.'/../../../artisan' ];
    $files[] = [ __DIR__.'/../../../server.php' ];

    var_dump( $files ); die();

    print 'タブ変換終了'.PHP_EOL;
}

if( array_key_exists( 'f', $options ) || array_key_exists( 'file', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) )
{
    print '言語ファイル生成開始…'.PHP_EOL;

    print '言語ファイル生成終了'.PHP_EOL;
}
return 0;
