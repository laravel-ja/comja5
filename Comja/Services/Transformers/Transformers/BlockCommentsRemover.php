<?php

namespace Comja\Services\Transformers\Transformers;

/**
 * ブロックコメント削除
 *
 * 制限：行コメントの範囲にブロックコメントが存在すると
 * 正しく処理できません。また、ブロックコメントの中に
 * #が含まれている場合も、正しく処理できないことがあります。
 *
 * @author Hirohisa Kawase
 */
class BlockCommentsRemover implements TransformerInterface
{

    protected $accessName = 'ブロックコメント削除';

    public function transform( $contents )
    {
        return preg_replace( '#/\*.+\*/#sU', '', $contents );
    }

    public function getPriority()
    {
        return 3100;
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