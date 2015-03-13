<?php

namespace Comja\Services\Validators\ArgumentValidators;

/**
 * コマンド引数バリデター登録クラス
 */
class ValidatorsRegistrar
{

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