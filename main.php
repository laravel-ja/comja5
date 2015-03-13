<?php

include_once "vendor/autoload.php";

use Comja\Services\File;
use Comja\Processors\Converter;
use Comja\Services\Transformers\ToyBox;
use Comja\Services\Validators\ArgumentValidators\Validator;
use Comja\Services\Validators\ArgumentValidators\ValidatorsRegistrar;
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

    return 1;
}

// オプションをチェックしやすいようにシンプルに変換

$opts['comment'] = false;
$opts['file'] = false;
$opts['tab'] = false;
$opts['remove'] = false;
$opts['all'] = false;
$opts['A'] = false;

if( isset( $options['a'] ) || isset( $options['all'] ) )
{
    $opts['all'] = true;
    $opts['comment'] = true;
    $opts['tab'] = 4;
    $opts['file'] = true;
}

if( isset( $options['A'] ) )
{
    $opts['A'] = true;
    $opts['tab'] = 4;
    $opts['file'] = true;
    $opts['remove'] = true;
}

if( isset( $options['c'] ) || isset( $options['comment'] ) )
{
    $opts['comment'] = true;
}

if( isset( $options['f'] ) || isset( $options['file'] ) )
{
    $opts['file'] = true;
}

if( isset( $options['t'] ) )
{
    $opts['tab'] = $options['t'] === false ? 4 : $options['t'];
}

if( isset( $options['tab'] ) )
{
    $opts['tab'] = $options['tab'] === false ? 4 : $options['tab'];
}

if( isset( $options['r'] ) || isset( $options['remove'] ) )
{
    $opts['remove'] = true;
}

// オプションのバリデーション
$validator = new Validator( new ValidatorsRegistrar() );
if( $validator->validateArguments( $opts ) )
{
    print __( $validator->getErrorMessage() );
    return 1;
}

// 変換処理

$file = new File();
$converter = new Converter( $file, new ToyBox(), new CommentTranslationsRepo( $file ),
    new LangFilesTranslationsRepo( $file ) );
$converter->format( $opts );

return 0;

