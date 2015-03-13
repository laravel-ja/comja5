<?php

namespace Comja\Services\Validators\ArgumentValidators;

use Comja\Services\Validators\ValidatorInterface;

/**
 * バリデーション
 *
 * Allオプションと-Aは同時に指定できない
 */
class NoAllAndAValidator implements ValidatorInterface
{

    public function validate( $param )
    {
        if( $param['all'] && $param['A'] ) return false;

        return true;
    }

    public function getErrorMessage()
    {
        return '-aまたは--allオプションと、-Aオプションは同時に指定できません。';
    }

}