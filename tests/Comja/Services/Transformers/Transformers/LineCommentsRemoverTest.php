<?php

use Comja\Services\Transformers\Transformers\LineCommentsRemover;

class LineCommentsRemoverTest extends TestBase
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
    // ラインコメント
    echo "Hello World!"
    // 左側の空白は削除されません。
}
';
        $result = '<?php
/**
 * テストサンプル
 *
 */
function helloWorld() {

    echo "Hello World!"

}
';

        $remover = new LineCommentsRemover();

        $this->assertEquals( $result, $remover->transform( $testData ) );
    }

}