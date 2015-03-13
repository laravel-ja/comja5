<?php

namespace Comja\Services\Validators;

use Comja\Services\File;
use Comja\Services\Validators\CurrentDirValidator;
use Comja\Services\Validators\ArgumentValidators\NoAllAndAValidator;
use Comja\Services\Validators\ArgumentValidators\NoCommentRemoveWithAllValidator;
use Comja\Services\Validators\ArgumentValidators\NoCommentTranslationWithAValidator;
use Comja\Services\Validators\ArgumentValidators\TranslateOrRemoveValidator;
use Comja\Services\Validators\ArgumentValidators\TabIntegerValidator;

/**
 * コマンド引数バリデタークラスインスタンス生成
 */
class ValidatorsRegistrar
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
     * バリデーションクラス登録配列取得
     *
     * @return array ArgumentValidatorInterface実装クラスインスタンス
     */
    public function get()
    {
        // 登録順が実行順
        return [
            new CurrentDirValidator( $this->file ),
            new NoAllAndAValidator(),
            new NoCommentRemoveWithAllValidator(),
            new NoCommentTranslationWithAValidator(),
            new TranslateOrRemoveValidator(),
            new TabIntegerValidator(),
        ];
    }

}