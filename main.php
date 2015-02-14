<?php

include_once "vendor/autoload.php";

use Comja\Repositories\TranslationRepo;
use Comja\Services\Translator;
use Comja\Services\File;
use Comja\Services\TabFormatter;
use Comja\Services\CommentsFormatter;

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

// 引数のエラーチェック

if( (array_key_exists( 'c', $options ) || array_key_exists( 'comment', $options )) &&
    (array_key_exists( 'r', $options ) || array_key_exists( 'remove', $options )) )
{
    fputs( STDERR, __( 'コメント翻訳とコメント削除は、同時に指定できません。' ).PHP_EOL );
    return 1;
}

if( (array_key_exists( 'a', $options ) || array_key_exists( 'all', $options )) &&
    count( $options ) != 1 )
{
    fputs( STDERR, __( '-aまたは--allオプションは他のオプションと同時に指定できません。' ).PHP_EOL );
    return 1;
}

if( array_key_exists( 'A', $options ) && count( $options ) != 1 )
{
    fputs( STDERR, __( '-Aオプションは他のオプションと同時に指定できません。' ).PHP_EOL );
    return 1;
}

if( array_key_exists( 't', $options ) && array_key_exists( 'tab', $options ) )
{
    fputs( STDERR, __( '-tと--tabオプションは同時に指定できません。' ).PHP_EOL );
    return 1;
}

// タブ指定時、カラム数の指定がない場合は４カラムデフォルト

$sp = false;
$sp = array_key_exists( 't', $options ) ? $options['t'] : $sp;
$sp = array_key_exists( 'tab', $options ) ? $options['tab'] : $sp;

if( (array_key_exists( 't', $options ) || array_key_exists( 'tab', $options ) ) &&
    $sp !== false && preg_match( "/^[0-9]+$/", $sp ) === 0 )
{
    fputs( STDERR, __( '-t/--tabオプションはスペースの数を整数で指定してください。（デフォルト４文字）' ).PHP_EOL );
    return 1;
}

$sp = $sp === false ? 4 : intval( $sp );

// 必要なファイルの英語コメントを翻訳

if( array_key_exists( 'c', $options ) || array_key_exists( 'comment', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) )
{
    print __( '翻訳開始…' ).PHP_EOL;

    $translationRepo = new TranslationRepo();

    // 本当はリポジトリの使用側が、保管場所を与えるのはよくないんだけど。
    $translations = $translationRepo->get( __DIR__.'/translation.txt' );

    $translator = new Translator;

    foreach( $translations as $fileName => $transArray )
    {
        $translator->trans( $fileName, $transArray );
    }

    print __( '翻訳終了' ).PHP_EOL;
}

// タブをスペースに変換

if( array_key_exists( 't', $options ) || array_key_exists( 'tab', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) ||
    array_key_exists( 'A', $options ) )
{
    print __( 'タブ変換開始…' ).PHP_EOL;

    $file = new File();
    $files = array_merge(
        $file->globFiles( __DIR__.'/../../../app', '*' ),
        $file->globFiles( __DIR__.'/../../../bootstrap', '*' ),
        $file->globFiles( __DIR__.'/../../../config', '*' ),
        $file->globFiles( __DIR__.'/../../../database', '*' ),
        $file->globFiles( __DIR__.'/../../../resources/lang', '*' ),
        $file->globFiles( __DIR__.'/../../../resources/views', '*' ),
        $file->globFiles( __DIR__.'/../../../tests', '*' ) );
    $files[] = __DIR__.'/../../../artisan';
    $files[] = __DIR__.'/../../../server.php';

    $tabFormatter = new TabFormatter();

    foreach( $files as $targetFile )
    {
        $tabFormatter->tabToSpace( $targetFile, $sp );
    }

    print __( 'タブ変換終了' ).PHP_EOL;
}

// jaの言語ファイル生成

if( array_key_exists( 'f', $options ) || array_key_exists( 'file', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) ||
    array_key_exists( 'A', $options ) )
{
    print __( '言語ファイル生成開始…' ).PHP_EOL;

    $file = new File();

    $file->copyDir( __DIR__.'/../../../resources/lang/en', __DIR__.'/../../../resources/lang/ja' );

    $translationRepo = new TranslationRepo();

    // ここで再利用。
    $translations = $translationRepo->get( __DIR__.'/language_lines.txt' );

    $translator = new Translator;

    foreach( $translations as $fileName => $transArray )
    {
        $translator->trans( __DIR__.'/../../../resources/lang/ja/'.$fileName, $transArray );
    }

    print __( '言語ファイル生成終了' ).PHP_EOL;
}

// コメント行・ブロックコメント・空白行削除

if( array_key_exists( 'r', $options ) || array_key_exists( 'remove', $options ) ||
    array_key_exists( 'A', $options ) )
{
    print __( 'コメント削除開始…' ).PHP_EOL;

    $file = new File();
    $files = array_merge(
        $file->globFiles( __DIR__.'/../../../app', '*' ),
        $file->globFiles( __DIR__.'/../../../bootstrap', '*' ),
        $file->globFiles( __DIR__.'/../../../config', '*' ),
        $file->globFiles( __DIR__.'/../../../database', '*' ),
        $file->globFiles( __DIR__.'/../../../resources/lang', '*' ),
        $file->globFiles( __DIR__.'/../../../resources/views', '*' ),
        $file->globFiles( __DIR__.'/../../../tests', '*' ) );
    $files[] = __DIR__.'/../../../artisan';
    $files[] = __DIR__.'/../../../server.php';

    $commentsFormatter = new CommentsFormatter();

    foreach( $files as $targetFile )
    {
        $commentsFormatter->remove( $targetFile );
    }

    print __( 'コメント削除終了' ).PHP_EOL;
}

return 0;
