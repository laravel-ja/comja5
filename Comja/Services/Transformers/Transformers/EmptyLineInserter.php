<?php

namespace Comja\Services\Transformers\Transformers;

/**
 * 最終行に空行を追加する
 *
 * @author Hirohisa Kawase
 */
class EmptyLineInserter implements TransformerInterface
{

    protected $accessName = '最後に空白行挿入';

    public function transform( $contents )
    {
        return rtrim( $contents, "\n" )."\n";
    }

    public function getPriority()
    {
        return 4000;
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