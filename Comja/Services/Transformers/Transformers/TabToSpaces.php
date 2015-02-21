<?php

namespace Comja\Services\Transformers\Transformers;

/**
 * タブの空白変換
 *
 * @author Hirohisa Kawase
 */
class TabToSpaces implements TransformerInterface
{

    /**
     * タブを空白へ変換
     *
     * @var integer 変換するスペース数
     */
    private $space = 4;

    protected $accessName = 'タブのスペース変換';

    public function transform( $contents )
    {
        return str_replace( "\t", str_repeat( ' ', $this->space ), $contents );
    }

    public function getPriority()
    {
        return 2000;
    }

    public function setSpace( $space )
    {
        $this->space = $space;
    }

    public function getAccessName()
    {
        return $this->accessName;
    }

    public function setAccessName( $accessName )
    {
        $this->accessName = $accessName;
    }

}