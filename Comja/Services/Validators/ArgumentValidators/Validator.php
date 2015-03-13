<?php

namespace Comja\Services\Validators\ArgumentValidators;

class Validator
{

    /**
     * バリデター実装クラスインスタンスの配列
     *
     * @var array ArgumentValidatorInterfaceの実装インスタンス
     */
    private $validators;

    /**
     * バリデイト失敗時のエラーメッセージ
     *
     * @var string
     */
    private $errorMessage = '';

    public function __construct( $validatorRegistrar )
    {
        $this->validators = $validatorRegistrar->get();
    }

    public function validateArguments( $arguments )
    {
        foreach( $this->validators as $validator )
        {dd($validator, $validator->validate($arguments));
            if( !$validator->validate( $arguments ) )
            {
                $this->errorMessage = $validator->getErrorMessage();
                return false;
            }
        }

        return true;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

}