<?php

include_once "vendor/autoload.php";

use Comja\Repositories\TranslationRepo;
use Comja\Services\Translator;
use Comja\Services\File;
use Comja\Services\TabFormatter;
use Comja\Services\CommentsFormatter;

// オプションの取り込み

$options = getopt( "ct::farA", ["comment", "tab::", "file", "remove", "all" ] );

if( $options === false || count( $options ) < 1 )
{
    fputs( STDERR, _( "オプション指定がありません。" ).PHP_EOL );
    print _( "使用法： comja [-c|--comment] [-t|--tab[=スペース数] [-f|--file] [-r|--remove] [-a|--all] [-A]" ).PHP_EOL;
    print _( "オプション：" ).PHP_EOL;
    print _( "-c --comment：コメント部分の翻訳" ).PHP_EOL;
    print _( "-t --tab：タブをスペースへ変換（デフォルト４空白）" ).PHP_EOL;
    print _( "-f --file：日本語言語ファイル生成" ).PHP_EOL;
    print _( "-r --remove：コメント／空行削除" ).PHP_EOL;
    print _( "-a --all：翻訳、タブ変換、言語ファイル追加を行います" ).PHP_EOL;
    print _( "-A：コメント削除、タブ変換、言語ファイル追加を行います" ).PHP_EOL;
}

if( (array_key_exists( 'c', $options ) || array_key_exists( 'comment', $options )) &&
    (array_key_exists( 'r', $options ) || array_key_exists( 'remove', $options )) )
{
    fputs( STDERR, _( 'コメント翻訳とコメント削除は、同時に指定できません。' ).PHP_EOL );
    return 1;
}

if( (array_key_exists( 'a', $options ) || array_key_exists( 'all', $options )) &&
    count( $options ) != 1 )
{
    fputs( STDERR, _( '-aまたは--allオプションは他のオプションと同時に指定できません。' ).PHP_EOL );
    return 1;
}

if( array_key_exists( 'A', $options ) && count( $options ) != 1 )
{
    fputs( STDERR, _( '-Aオプションは他のオプションと同時に指定できません。' ).PHP_EOL );
    return 1;
}

if( array_key_exists( 't', $options ) && array_key_exists( 'tab', $options ) )
{
    fputs( STDERR, _( '-tと--tabオプションは同時に指定できません。' ).PHP_EOL );
    return 1;
}

$sp = false;
$sp = array_key_exists( 't', $options ) ? $options['t'] : $sp;
$sp = array_key_exists( 'tab', $options ) ? $options['tab'] : $sp;

if( (array_key_exists( 't', $options ) || array_key_exists( 'tab', $options ) ) &&
    $sp !== false && preg_match( "/^[0-9]+$/", $sp ) === 0 )
{
    fputs( STDERR, _( '-t/--tabオプションはスペースの数を整数で指定してください。（デフォルト４文字）' ).PHP_EOL );
    return 1;
}

$sp = $sp === false ? 4 : intval( $sp );

if( array_key_exists( 'c', $options ) || array_key_exists( 'comment', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) )
{
    print _( '翻訳開始…' ).PHP_EOL;

    $translationRepo = new TranslationRepo();

    // 本当はリポジトリの使用側が、保管場所を与えるのはよくないんだけど。
    $translations = $translationRepo->get( __DIR__.'/translation.txt' );

    $translator = new Translator;

    foreach( $translations as $fileName => $transArray )
    {
        $translator->trans( $fileName, $transArray );
    }

    print _( '翻訳終了' ).PHP_EOL;
}

if( array_key_exists( 't', $options ) || array_key_exists( 'tab', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) ||
    array_key_exists( 'A', $options ) )
{
    print _( 'タブ変換開始…' ).PHP_EOL;

    $file = new File();
    $files = array_merge(
        $file->globAll( __DIR__.'/../../../app', '*' ),
        $file->globAll( __DIR__.'/../../../bootstrap', '*' ),
        $file->globAll( __DIR__.'/../../../config', '*' ),
        $file->globAll( __DIR__.'/../../../database', '*' ),
        $file->globAll( __DIR__.'/../../../resources/lang', '*' ),
        $file->globAll( __DIR__.'/../../../resources/views', '*' ),
        $file->globAll( __DIR__.'/../../../tests', '*' ) );
    $files[] = __DIR__.'/../../../artisan';
    $files[] = __DIR__.'/../../../server.php';

    $tabFormatter = new TabFormatter();

    foreach( $files as $targetFile )
    {
        $tabFormatter->tabToSpace( $targetFile, $sp );
    }

    print _( 'タブ変換終了' ).PHP_EOL;
}

if( array_key_exists( 'f', $options ) || array_key_exists( 'file', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) ||
    array_key_exists( 'A', $options ) )
{
    print _( '言語ファイル生成開始…' ).PHP_EOL;

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

    print _( '言語ファイル生成終了' ).PHP_EOL;
}

if( array_key_exists( 'r', $options ) || array_key_exists( 'remove', $options ) ||
    array_key_exists( 'A', $options ) )
{
    print _( 'コメント削除開始…' ).PHP_EOL;

    $file = new File();
    $files = array_merge(
        $file->globAll( __DIR__.'/../../../app', '*' ),
        $file->globAll( __DIR__.'/../../../bootstrap', '*' ),
        $file->globAll( __DIR__.'/../../../config', '*' ),
        $file->globAll( __DIR__.'/../../../database', '*' ),
        $file->globAll( __DIR__.'/../../../resources/lang', '*' ),
        $file->globAll( __DIR__.'/../../../resources/views', '*' ),
        $file->globAll( __DIR__.'/../../../tests', '*' ) );
    $files[] = __DIR__.'/../../../artisan';
    $files[] = __DIR__.'/../../../server.php';

    $commentsFormatter = new CommentsFormatter();

    foreach( $files as $targetFile )
    {
        $commentsFormatter->remove( $targetFile );
    }

    print _( 'コメント削除終了' ).PHP_EOL;
}

return 0;
