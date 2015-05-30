<?php

namespace Comja\Processors;

use Comja\Services\File;
use Comja\Services\Transformers\ToyBox;
use Comja\Services\Transformers\Transformers\BlockCommentsRemover;
use Comja\Services\Transformers\Transformers\EmptyLineInserter;
use Comja\Services\Transformers\Transformers\EmptyLinesRemover;
use Comja\Services\Transformers\Transformers\LineCommentsRemover;
use Comja\Services\Transformers\Transformers\TabToSpaces;
use Comja\Services\Transformers\Transformers\Translator;
use Comja\Repositories\CommentTranslationsRepo;
use Comja\Repositories\LangFilesTranslationsRepo;

/**
 * 指定されたオプションに基づき
 * ルートディレクトリー下のファイルを
 * 変換する
 *
 * 変換作業のメインロジック
 */
class Converter
{

    /**
     * 整形クラスマネージャー
     *
     * @var ToyBox
     */
    private $box;

    /**
     * コンストラクタ
     *
     * 依存ファイルの注入
     *
     * @param File $file
     * @param ToyBox $box
     * @param CommentTranslationsRepo $commentRepo
     * @param LangFilesTranslationsRepo $langRepo
     */
    public function __construct( File $file, ToyBox $box, CommentTranslationsRepo $commentRepo, LangFilesTranslationsRepo $langRepo )
    {
        $this->file = $file;
        $this->box = $box;
        $this->commentRepo = $commentRepo;
        $this->langRepo = $langRepo;
    }

    /**
     * 整形処理メインロジック
     *
     * @param type $options オプション
     */
    function format( $options )
    {
        // 指定されたオプションに従い変換ロジッククラス登録
        $this->registerCommentTranslator( $options );
        $this->registerTabToSpace( $options );
        $this->registerCommentRemover( $options );
        $this->registerEmptyLineInserter();

        // 既存ファイルの変換
        $this->formatExistedFiles();

        if( $options['file'] )
        {
            // コメント翻訳が指定されていない場合、翻訳クラスが未登録のため
            // 改めて翻訳クラスを登録
            $this->box->push( new Translator() );

            // 言語ディレクトリーenをjaへコピー
            $this->file->copyDir( $this->file->getCurrentDir().'/resources/lang/en',
                $this->file->getCurrentDir().'/resources/lang/ja' );

            // 新規生成したファイルの変換
            $this->formatNewFiles();
        }
    }

    /**
     * 指定されたオプションに従い
     * 既存ファイル内容の変換処理を行う
     */
    public function formatExistedFiles()
    {
        $cwd = $this->file->getCurrentDir();

        // 変換対象ファイル一覧取得
        $files = array_merge(
            $this->file->globFiles( $cwd.'/app', '*' ),
            $this->file->globFiles( $cwd.'/bootstrap', '*' ),
            $this->file->globFiles( $cwd.'/config', '*' ),
            $this->file->globFiles( $cwd.'/database', '*' ),
            $this->file->globFiles( $cwd.'/resources', '*.php' ),
            $this->file->globFiles( $cwd.'/tests', '*' ) );
        $files[] = $cwd.'/public/index.php';
        $files[] = $cwd.'/artisan';
        $files[] = $cwd.'/server.php';
        $files[] = $cwd.'/gulpfile.js';

        foreach( $files as $targetFile )
        {
            // 翻訳データ（英和）セット
            if( isset( $this->box['翻訳'] ) )
            {
                // $targetFileは絶対パス
                $translation = $this->commentRepo->get( $targetFile );

                if( $translation !== false )
                {
                    $this->box['翻訳']->setTranslations( $translation );
                }
            }
            // 変換
            $contens = $this->file->getContents( $targetFile );
            $converted = $this->box->play( $contens );
            $this->file->putContents( $targetFile, $converted );
        }
    }

    /**
     * 指定されたオプションに従い
     * 新規作成した言語ファイルの変換を行う
     */
    public function formatNewFiles()
    {
        $cwd = $this->file->getCurrentDir();
        $files = $this->file->globFiles( $cwd.'/resources/lang/ja', '*' );

        foreach( $files as $targetFile )
        {
            // $targetFileは絶対パス
            $translation = $this->langRepo->get( $targetFile );

            if( $translation !== false )
            {
                $this->box['翻訳']->setTranslations( $translation );
            }

            // 変換
            $contens = $this->file->getContents( $targetFile );
            $converted = $this->box->play( $contens );
            $this->file->putContents( $targetFile, $converted );
        }
    }

    function registerCommentTranslator( $options )
    {
        if( $options['comment'] )
        {
            $this->box->push( new Translator() );
        }
    }

    function registerTabToSpace( $options )
    {
        if( $options['tab'] )
        {
            $tabToSpace = new TabToSpaces();
            $tabToSpace->setSpace( $options['tab'] );
            $this->box->push( $tabToSpace );
        }
    }

    function registerCommentRemover( $options )
    {
        if( $options['remove'] )
        {
            $this->box->push( new LineCommentsRemover() );
            $this->box->push( new BlockCommentsRemover() );
            $this->box->push( new EmptyLinesRemover() );
        }
    }

    function registerEmptyLineInserter()
    {
        $this->box->push( new EmptyLineInserter() );
    }

}