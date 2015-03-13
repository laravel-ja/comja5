<?php

namespace Comja\Services\Validators;

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

    /**
     * コンストラクター
     *
     * @param ValidatorsRegistrar $validatorRegistrar
     */
    public function __construct( ValidatorsRegistrar $validatorRegistrar )
    {
        $this->validators = $validatorRegistrar->get();
    }

    /**
     * コマンドラインバリデーション実行
     *
     * @param array $arguments コマンドラインオプション
     * @return boolean 結果
     */
    public function validateArguments( $arguments )
    {
        foreach( $this->validators as $validator )
        {
            if( !$validator->validate( $arguments ) )
            {
                $this->errorMessage = $validator->getErrorMessage();
                return false;
            }
        }

        return true;
    }

    /**
     * エラー時メッセージ取得
     *
     * @return string エラーメッセージ
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

}