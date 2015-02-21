<?php

use Comja\Services\Transformers\Transformers\TabToSpaces;

class TabToSpacesTest extends TestBase
{

    public function __construct()
    {

    }

    protected function setUp()
    {

    }

    public function testTransformeデフォルト４スペース()
    {
        $testData = "<?php
/**
 * テストサンプル
 */
function helloWorld() {
\techo \"Hello World!\"
}";

        $result = "<?php
/**
 * テストサンプル
 */
function helloWorld() {
    echo \"Hello World!\"
}";

        $remover = new TabToSpaces();

        $this->assertEquals( $result, $remover->transform( $testData ) );
    }

    public function testTransformeタブ数指定()
    {
        $testData = "<?php
/**
 * テストサンプル
 */
function helloWorld() {
\techo \"Hello World!\"
}";

        $result = "<?php
/**
 * テストサンプル
 */
function helloWorld() {
       echo \"Hello World!\"
}";

        $remover = new TabToSpaces();
        $remover->setSpace( 7 );

        $this->assertEquals( $result, $remover->transform( $testData ) );
    }

}