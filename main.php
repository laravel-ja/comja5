<?php

include_once "vendor/autoload.php";

use Comja\Repositories\TranslationRepo;
use Comja\Services\Translator;
use Comja\Services\File;
use Comja\Services\TabFormatter;
use Comja\Services\CommentsFormatter;

// オプションの取り込み

$options = getopt( "ctfarA", ["comment", "tab", "file", "remove", "all" ] );

if( $options === false || count( $options ) < 1 )
{
    fputs( STDERR, "オプション指定がありません。".PHP_EOL );
    print "使用法： comja [-c|--comment] [-t|--tab] [-f|--file] [-r|--remove] [-a|--all] [-A]".PHP_EOL;
    print "オプション：".PHP_EOL;
    print "-c --comment：コメント部分の翻訳".PHP_EOL;
    print "-t --tab：タブを4スペースへ変換".PHP_EOL;
    print "-f --file：日本語言語ファイル生成".PHP_EOL;
    print "-r --remove：コメント／空行削除".PHP_EOL;
    print "-a --all：翻訳、タブ変換、言語ファイル追加を行います".PHP_EOL;
    print "-A：コメント削除、タブ変換、言語ファイル追加を行います".PHP_EOL;
}

if( (array_key_exists( 'c', $options ) || array_key_exists( 'comment', $options )) &&
    (array_key_exists( 'r', $options ) || array_key_exists( 'remove', $options )) )
{
    fputs( STDERR, 'コメント翻訳とコメント削除は、同時に指定できません。'.PHP_EOL );
    return 1;
}

if( (array_key_exists( 'a', $options ) || array_key_exists( 'all', $options )) &&
    count( $options ) != 1 )
{
    fputs( STDERR, '-aまたは--allオプションは他のオプションと同時に指定できません。'.PHP_EOL );
    return 1;
}

if( array_key_exists( 'A', $options ) && count( $options ) != 1 )
{
    fputs( STDERR, '-Aオプションは他のオプションと同時に指定できません。'.PHP_EOL );
    return 1;
}

if( array_key_exists( 'c', $options ) || array_key_exists( 'comment', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) )
{
    print '翻訳開始…'.PHP_EOL;

    $translationRepo = new TranslationRepo();

    // 本当はリポジトリの使用側が、保管場所を与えるのはよくないんだけど。
    $translations = $translationRepo->get( __DIR__.'/translation.txt' );

    $translator = new Translator;

    foreach( $translations as $fileName => $transArray )
    {
        $translator->trans( $fileName, $transArray );
    }

    print '翻訳終了'.PHP_EOL;
}

if( array_key_exists( 't', $options ) || array_key_exists( 'tab', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) ||
    array_key_exists( 'A', $options ) )
{
    print 'タブ変換開始…'.PHP_EOL;

    $file = new File();
    $files = array_merge(
        $file->globAll( __DIR__.'/../../../app', '*' ), $file->globAll( __DIR__.'/../../../bootstrap', '*' ), $file->globAll( __DIR__.'/../../../config', '*' ), $file->globAll( __DIR__.'/../../../database', '*' ), $file->globAll( __DIR__.'/../../../resources/lang', '*' ), $file->globAll( __DIR__.'/../../../resources/views', '*' ), $file->globAll( __DIR__.'/../../../tests', '*' ) ); // NetBeansの整形が…
    $files[] = __DIR__.'/../../../artisan';
    $files[] = __DIR__.'/../../../server.php';

    $tabFormatter = new TabFormatter();

    foreach( $files as $targetFile )
    {
        $tabFormatter->tabToSpace( $targetFile, 4 );
    }

    print 'タブ変換終了'.PHP_EOL;
}

if( array_key_exists( 'f', $options ) || array_key_exists( 'file', $options ) ||
    array_key_exists( 'a', $options ) || array_key_exists( 'all', $options ) ||
    array_key_exists( 'A', $options ) )
{
    print '言語ファイル生成開始…'.PHP_EOL;

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

    print '言語ファイル生成終了'.PHP_EOL;
}

if( array_key_exists( 'r', $options ) || array_key_exists( 'remove', $options ) ||
    array_key_exists( 'A', $options ) )
{
    print 'コメント削除開始…'.PHP_EOL;

    $file = new File();
    $files = array_merge(
        $file->globAll( __DIR__.'/../../../app', '*' ), $file->globAll( __DIR__.'/../../../bootstrap', '*' ), $file->globAll( __DIR__.'/../../../config', '*' ), $file->globAll( __DIR__.'/../../../database', '*' ), $file->globAll( __DIR__.'/../../../resources/lang', '*' ), $file->globAll( __DIR__.'/../../../resources/views', '*' ), $file->globAll( __DIR__.'/../../../tests', '*' ) ); // NetBeansの整形が…
    $files[] = __DIR__.'/../../../artisan';
    $files[] = __DIR__.'/../../../server.php';

    $commentsFormatter = new CommentsFormatter();

    foreach( $files as $targetFile )
    {
        $commentsFormatter->remove( $targetFile );
    }

    print 'コメント削除終了'.PHP_EOL;
}

return 0;
