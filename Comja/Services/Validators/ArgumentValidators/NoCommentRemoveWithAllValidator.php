<?php

namespace Comja\Services\Validators\ArgumentValidators;

/**
 * バリデーション
 *
 * Allオプションとコメント削除オブションは同時に指定できない
 */
class NoCommentRemoveWithAllValidator implements ArgumentsValidatorInterface
{

    public function validate( $param )
    {
        if( $param['all'] && $param['remove'] ) return false;

        return true;
    }

    public function getErrorMessage()
    {
        return '-aまたは--allオプションはコメント削除オプション(-r|--remove)と同時に指定できません。';
    }

}