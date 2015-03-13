<?php

namespace Comja\Services\Validators\ArgumentsValidators;

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
        dd($this->validators);
    }

    public function validateArguments( $arguments )
    {
        foreach( $this->validators as $validator )
        {
            if( $validator->validate( $arguments ) === false )
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