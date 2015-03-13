<?php

namespace Comja\Services\Validators\ArgumentValidators;

/**
 * バリデーション
 *
 * Aとコメント翻訳オブションは同時に指定できない
 */
class NoCommentTranslationWithAValidator implements ArgumentsValidatorInterface
{

    public function validate( $param )
    {
        if( $param['A'] && $param['comment'] ) return false;
    }

    public function getErrorMessage()
    {
        return '-Aオプションはコメント翻訳オプション(-c|--comment)と同時に指定できません。';
    }

}