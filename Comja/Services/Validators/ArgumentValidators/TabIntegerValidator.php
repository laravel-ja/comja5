<?php

namespace Comja\Services\Validators\ArgumentValidators;

use Comja\Services\Validators\ValidatorInterface;

/**
 * バリデーション
 *
 * タブの指定値は整数
 */
class TabIntegerValidator implements ValidatorInterface
{

    public function validate( $param )
    {
        if( $param['tab'] && preg_match( "/^[0-9]+$/", $param['tab'] ) === 0 ) return false;

        return true;
    }

    public function getErrorMessage()
    {
        return 'タブオプション(-t|--tab)は整数で指定してください。（省略時デフォルト４文字）';
    }

}