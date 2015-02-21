<?php

use Comja\Services\Transformers\Transformers\EmptyLineInserter;

class EmptyLineInserterTest extends TestBase
{

    public function __construct()
    {

    }

    protected function setUp()
    {

    }

    public function testTransforme()
    {
        $testData = "<?php
/**
 * テストサンプル
 *
 */
function helloWorld() {
    echo \"Hello World!\"
}";

        $result = "<?php
/**
 * テストサンプル
 *
 */
function helloWorld() {
    echo \"Hello World!\"
}
";

        $remover = new EmptyLineInserter();

        $this->assertEquals( $result, $remover->transform( $testData ) );
    }

}