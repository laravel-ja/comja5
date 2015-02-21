<?php

class UsedFileRepositoryTraitDummy
{

    use Comja\Repositories\FileRepositoryTrait;

}

class FileRepositoryTraitTest extends TestBase
{

    public function __construct()
    {

    }

    protected function setUp()
    {

    }

    public function testIsCached未キャッシュ時()
    {
        $repo = new UsedFileRepositoryTraitDummy( );
        $repo->setCache( [ ] );

        $this->assertFalse( $repo->isCached() );
    }

    public function testIsCachedキャッシュ済み時()
    {

        $repo = new UsedFileRepositoryTraitDummy( );
        $repo->setCache( [ '済！' ] );

        $this->assertTrue( $repo->isCached() );
    }

    public function testFeachAll未キャッシュ時readAllLine呼び出し()
    {
        $data = ['読み込み内容' ];

        $selfMock = Mockery::mock( 'UsedFileRepositoryTraitDummy' )->makePartial();

        // 未キャッシュ状態
        $selfMock->shouldReceive( 'isCached' )->once()->andReturn( false );
        // readAllLineの呼び出しチェック
        $selfMock->shouldReceive( 'readAllLine' )->once()->andReturn( $data );

        $selfMock->feachAll();

        // キャッシュの設置チェック
        $this->assertEquals( $data, $selfMock->getCache() );
    }

    public function testFeachAllキャシュ済み時()
    {
        $selfMock = Mockery::mock( 'UsedFileRepositoryTraitDummy' )->makePartial();

        // キャッシュ済み状態
        $selfMock->shouldReceive( 'isCached' )->once()->andReturn( true );
        // readAllLineを呼び出さないチェック
        $selfMock->shouldReceive( 'readAllLine' )->never();

        $selfMock->feachAll();
    }

}