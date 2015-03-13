<?php

namespace Comja\Services\Validators\ArgumentValidators;

use Comja\Services\Validators\ValidatorInterface;
/**
 * バリデーション
 *
 * Aとコメント翻訳オブションは同時に指定できない
 */
class NoCommentTranslationWithAValidator implements ValidatorInterface
{

    public function validate( $param )
    {
        if( $param['A'] && $param['comment'] ) return false;

        return true;
    }

    public function getErrorMessage()
    {
        return '-Aオプションはコメント翻訳オプション(-c|--comment)と同時に指定できません。';
    }

}