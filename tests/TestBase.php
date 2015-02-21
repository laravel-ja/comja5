<?php

/**
 * PHPUnitテストベース
 */

class TestBase extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
}