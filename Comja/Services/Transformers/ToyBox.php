<?php

namespace Comja\Services\Transformers;

/**
 * コンテンツ整形管理
 *
 * 「そりゃー、トランスフォーマーしまっておくのは、おもちゃ箱でしょーがーあ」
 *
 * @author Hirohisa Kawase
 */
use Comja\Services\Transformers\Transformers\TransformerInterface;
use ArrayAccess;

class ToyBox implements ArrayAccess
{

    /**
     * 整形クラス(Transformer)を保持する
     *
     * @var array
     */
    private $box = [ ];

    /**
     * 整形クラスの保存
     *
     * @param TransformerInterface $transformer 整形クラスインスタンス
     * @param type $accessName アクセス名、デフォルト値を変更したい場合
     */
    public function push( TransformerInterface $transformer, $accessName = null )
    {
        if( !is_null( $accessName ) )
        {
            $transformer->setAccessName( $accessName );
        }
        $this->box[$transformer->getPriority()] = $transformer;
    }

    /**
     * コンテンツに対し、保存中の整形処理を行う
     *
     * @param string $contents コンテンツ
     * @return string 整形適用後のコンテンツ
     */
    public function play( $contents )
    {
        foreach( $this->box as $transfomer )
        {
            $contents = $transfomer->transform( $contents );
        }

        return $contents;
    }

    /**
     * 整形クラスをクリアする
     */
    public function clear()
    {
        $this->box = [ ];
    }

    /**
     * 配列アクセス存在チェック
     *
     * @param integer|string $offset プライオリティーかアクセス名
     * @return boolean 存在していればtrue
     */
    public function offsetExists( $offset )
    {
        foreach( $this->box as $priority => $transformer )
        {
            if( $priority === $offset ||
                $transformer->getAccessName() === $offset )
            {
                return true;
            }
        }

        return false;
    }

    /**
     * 配列アクセスインスタンス取得
     *
     * @param integer|string $offset プライオリティーかアクセス名
     * @return Comja\Services\Transformers\Transformers\TransformerInterface|null
     */
    public function offsetGet( $offset )
    {
        foreach( $this->box as $priority => $transformer )
        {
            if( $priority === $offset ||
                $transformer->getAccessName() === $offset )
            {
                return $transformer;
            }
        }

        return null;
    }

    /**
     * 配列アクセスインスタンス設置
     *
     * @param integer|string|null $offset プライオリティーかアクセス名、未指定時はnullが入ってくる
     * @param Comja\Services\Transformers\Transformers\TransformerInterface $value インスタンス
     */
    public function offsetSet( $offset, $value )
    {
        if( is_null( $offset ) )
        {
            // 配列要素未指定時
            $this->push( ($value ) );
            return;
        }

        if( intval( $offset ) )
        {
            // プライオリティー指定時
            $this->box[$offset] = $value;
            return;
        }

        // アクセス名指定時
        foreach( $this->box as $priority => $transformer )
        {
            if( $transformer->getAccessName() === $offset )
            {
                unset( $this->box[$priority] );
                break;
            }
        }
        $value->setAccessName( $offset );
        $this->box[$value->getPriority()] = $value;
    }

    /**
     * 配列アクセス要素削除
     *
     * @param integer|string $offset プライオリティーかアクセス名
     */
    public function offsetUnset( $offset )
    {
        if( array_key_exists( $offset, $this->box ) )
        {
            unset( $this->box[$offset] );
            return;
        }

        foreach( $this->box as $priority => $transformer )
        {
            if( $transformer->getAccessName() === $offset )
            {
                unset( $this->box[$priority] );
                return;
            }
        }
    }

    /**
     * セッター
     *
     * @param array $box TransformerInterface実装インスタンスの配列
     */
    public function setBox( $box )
    {
        $this->box = $box;
    }

    /**
     * ゲッター
     *
     * @return array TransformerInterface実装インスタンスの配列
     */
    public function getBox()
    {
        return $this->box;
    }

}