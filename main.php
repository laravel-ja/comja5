<?php

include_once "vendor/autoload.php";

use Comja\Repositories\TranslationRepo;
use Comja\Services\Translator;

// オプションの取り込み

$options = getopt( "ctf", ["comment", "tab", "file" ] );
if( count( $options ) )
{
    fput( STDERR, "オプション指定がありません。" );
    print "使用法： comja [-c|--comment] [-t|--tab] [-f|--file]".PHP_EOL;
    print "オプション：".PHP_EOL;
    print "-c --cooment：コメント部分の翻訳".PHP_EOL;
    print "-t --tab：タブを4スペースへ変換".PHP_EOL;
    print "-f --file：日本語言語ファイル生成".PHP_EOL;
}

// 翻訳データ読み込み

print '翻訳開始…'.PHP_EOL;

$translationRepo = new TranslationRepo();
$translations = $translationRepo->get();

// 翻訳

$translator = new Translator;
$translator->trans( $translations );

print '翻訳終了'.PHP_EOL;

return 0;
