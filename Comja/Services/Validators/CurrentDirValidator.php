<?php

namespace Comja\Services\Validators;

use RuntimeException;
use Comja\Services\File;
use Comja\Services\Validators\ValidatorInterface;

/**
 * バリデーション
 *
 * カレントディレクトリーがLaravelインストールディレクトリーか確認
 */
class CurrentDirValidator implements ValidatorInterface
{

    /**
     * ファイル操作クラスインスタンス
     *
     * @var File
     */
    private $file;

    /**
     * コンストラクタ
     *
     * @param File $file
     */
    public function __construct( File $file )
    {
        $this->file = $file;
    }

    /**
     * バリデーション実行
     *
     * @param array $param コマンドライン引数
     * @return boolean バリデーション結果
     */
    public function validate( $param )
    {
        try
        {
            $composerJson = $this->file->readJson( $this->file->getCurrentDir().'/composer.json' );
        }
        catch( RuntimeException $e )
        {
            return false;
        }

        return isset( $composerJson['require']['laravel/framework'] );
    }

    /**
     * エラー時メッセージ取得
     *
     * @return string エラーメッセージ
     */
    public function getErrorMessage()
    {
        return 'このコマンドはcomposer.jsonが存在している、Laravelのインストールディレクトリーで実行してください。';
    }

}