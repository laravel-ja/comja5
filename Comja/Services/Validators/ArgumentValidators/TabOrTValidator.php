<?php

namespace Comja\Services\Validators\ArgumentsValidators;

/**
 * バリデーション
 *
 * コメント翻訳と削除オブションは同時に指定できない
 */
class TabOrTValidator implements ArgumentsValidatorInterface
{

    public function validate( $param )
    {
        if( $param['comment'] && $param['remove'] ) return false;
    }

    public function getErrorMessage()
    {
        return 'タブ指定オプションは-tか--tabのどちらか一つだけ指定してください。';
    }

}