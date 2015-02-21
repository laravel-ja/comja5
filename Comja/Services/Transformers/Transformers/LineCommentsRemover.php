<?php

namespace Comja\Services\Transformers\Transformers;

/**
 * 行コメント削除
 *
 * @author Hirohisa Kawase
 */
class LineCommentsRemover implements TransformerInterface
{

    protected $accessName = '行コメント削除';

    public function transform( $contents )
    {
        return preg_replace( '#^\s*//.*$#m', "", $contents );
    }

    public function getPriority()
    {
        return 3000;
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