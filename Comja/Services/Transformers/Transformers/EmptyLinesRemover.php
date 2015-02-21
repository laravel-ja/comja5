<?php

namespace Comja\Services\Transformers\Transformers;

/**
 * 空白行削除
 *
 * @author Hirohisa Kawase
 */
class EmptyLinesRemover implements TransformerInterface
{

    protected $accessName = '空白行削除';

    public function transform( $contents )
    {
        return preg_replace( '/^\s*\n/m', '', $contents );
    }

    public function getPriority()
    {
        return 3200;
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