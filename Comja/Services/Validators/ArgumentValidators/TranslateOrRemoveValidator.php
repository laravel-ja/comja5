<?php

namespace Comja\Services\Validators\ArgumentValidators;

use Comja\Services\Validators\ValidatorInterface;
/**
 * バリデーション
 *
 * コメント翻訳と削除オブションは同時に指定できない
 */
class TranslateOrRemoveValidator implements ValidatorInterface
{

    public function validate( $param )
    {
        if( $param['comment'] && $param['remove'] ) return false;

        return true;
    }

    public function getErrorMessage()
    {
        return 'コメント翻訳オプション(-c|--comment)は、削除オプション(-r|--remove)と同時に指定できません。';
    }

}