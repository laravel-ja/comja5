<?php

use Comja\Services\Transformers\Transformers\BlockCommentsRemover;

class BlockCommentsRemoverTest extends TestBase
{

    public function __construct()
    {

    }

    protected function setUp()
    {

    }

    public function testTransforme()
    {
        $testData = '<?php
/**
 * テストサンプル
 *
 */
function helloWorld() {
    #/* ブロックコメント */
    echo "Hello World!"
    # これは残る
  #/* 左の空白２つは
  削除されません。*/
}
';
        $result = '<?php

function helloWorld() {
    #
    echo "Hello World!"
    # これは残る
  #
}
';

        $remover = new BlockCommentsRemover();

        $this->assertEquals( $result, $remover->transform( $testData ) );
    }

}