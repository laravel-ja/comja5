<?php

use Comja\Services\Transformers\Transformers\EmptyLinesRemover;

class EmptyLinesRemoverTest extends TestBase
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
    // この下の空行は削除されます。

    echo \"Hello World!\"
    // この下の空行は先頭にタブがありますが、
    // 削除されます。
\t
}
";
        $result = '<?php
/**
 * テストサンプル
 *
 */
function helloWorld() {
    // この下の空行は削除されます。
    echo "Hello World!"
    // この下の空行は先頭にタブがありますが、
    // 削除されます。
}
';

        $remover = new EmptyLinesRemover();

        $this->assertEquals( $result, $remover->transform( $testData ) );
    }

}