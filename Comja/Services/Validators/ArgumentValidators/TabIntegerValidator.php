<?php

namespace Comja\Services\Validators\ArgumentValidators;

/**
 * バリデーション
 *
 * タブの指定値は整数
 */
class TabIntegerValidator implements ArgumentsValidatorInterface
{

    public function validate( $param )
    {
        if( $param['tab'] && preg_match( "/^[0-9]+$/", $param['tab'] ) === 0 ) return false;
    }

    public function getErrorMessage()
    {
        return 'タブオプション(-t|--tab)は整数で指定してください。（省略時デフォルト４文字）';
    }

}