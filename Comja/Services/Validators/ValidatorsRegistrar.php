<?php

namespace Comja\Services\Validators;

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
     * バリデーションクラス登録配列取得
     *
     * @return array ArgumentValidatorInterface実装クラスインスタンス
     */
    public function get()
    {
        // 登録順が実行順
        return [
            new NoAllAndAValidator(),
            new NoCommentRemoveWithAllValidator(),
            new NoCommentTranslationWithAValidator(),
            new TranslateOrRemoveValidator(),
            new TabIntegerValidator(),
        ];
    }

}