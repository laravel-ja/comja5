<?php

use Comja\Services\Transformers\Transformers\Translator;

class TranslatorTest extends TestBase
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

\$a = [
        'key1' => 'Apple Pie',
        'key2' => 'Orange Tree',
     ]
";

        $result = "<?php

\$a = [
        'key1' => 'アップルパイ',
        'key2' => '蜜柑の木',
     ]
";

        $translation = [
            'Apple Pie'   => 'アップルパイ',
            'Orange Tree' => '蜜柑の木',
        ];

        $translator = new Translator();
        $translator->setTranslations( $translation );

        $this->assertEquals( $result, $translator->transform( $testData ) );
    }

}