<?php

use Comja\Repositories\TranslationsJsonRepo as Repo;

class TranslationJsonRepoTest extends TestBase
{

    public function __construct()
    {

    }

    protected function setUp()
    {
        $this->fileMock = Mockery::mock( 'Comja\Services\File' );
    }

    public function testReadAllLines()
    {
        $data = ['file5i583' => ['key9d8d0' => 'value7j8398' ] ];
        $returnData = ['/AAAA/file5i583' => ['key9d8d0' => 'value7j8398' ] ];

        $this->fileMock->shouldReceive( 'getCurrentDir' )
            ->once()
            ->andReturn( '/AAAA' );
        $this->fileMock->shouldReceive( 'readJson' )
            ->once()
            ->with( '/AAAA/vendor/laravel-ja/comja5/' )
            ->andReturn( $data );
        $this->fileMock->shouldReceive( 'getRealPath' )
            ->once()
            ->with( '/AAAA/file5i583' )
            ->andReturn( '/AAAA/file5i583' );

        $repo = new Repo( $this->fileMock );

        $this->assertEquals( $returnData, $repo->readAllLine() );
    }

    public function testGetAllデータ取得()
    {
        $returnData = ['file03dfj8' => ['key1828' => 'value29d838' ] ];

        $repo = new Repo( $this->fileMock );

        // キャッシュデータ設置
        $repo->setCache( $returnData );

        $this->assertEquals( $returnData, $repo->getAll() );
    }

    public function testGet特定ファイルの翻訳情報取得()
    {
        $data1 = ['apple' => 'りんご', 'orange' => 'みかん' ];
        $data2 = ['banana' => 'バナナ' ];
        $transData = [ 'File名1' => $data1, 'File名2' => $data2 ];

        $repo = new Repo( $this->fileMock );

        // キャッシュデータ設置
        $repo->setCache( $transData );

        $this->assertEquals( $data1, $repo->get( 'File名1' ) );
        $this->assertEquals( $data2, $repo->get( 'File名2' ) );

        // キーの不一致
        $this->assertFalse( $repo->get( '存在しないファイル名' ) );
    }

    public function testGet特定英文から和文取得()
    {
        $data1 = ['apple' => 'りんご', 'orange' => 'みかん' ];
        $data2 = ['banana' => 'バナナ' ];
        $transData = [ 'File名1' => $data1, 'File名2' => $data2 ];

        $repo = new Repo( $this->fileMock );

        // キャッシュデータ設置
        $repo->setCache( $transData );

        // 取得内容確認
        $this->assertEquals( 'りんご', $repo->get( 'File名1', 'apple' ) );
        $this->assertEquals( 'みかん', $repo->get( 'File名1', 'orange' ) );
        $this->assertEquals( 'バナナ', $repo->get( 'File名2', 'banana' ) );

        // キーの不一致
        $this->assertFalse( $repo->get( 'File名1', '存在しない英文' ) );
    }

}