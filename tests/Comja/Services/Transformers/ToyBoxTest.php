<?php

use Comja\Services\Transformers\ToyBox;

class ToyBoxTest extends TestBase
{

    protected function setUp()
    {

    }

    public function testPushプライオリティーをキーに保存()
    {
        $transformerMock = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock->shouldReceive( 'getPriority' )->once()->andReturn( 1234 );

        $box = new ToyBox();
        $box->push( $transformerMock );

        $this->assertEquals( [1234 => $transformerMock ], $box->getBox() );
    }

    public function testPushプライオリティーをキーに複数保存()
    {
        $transformerMock1 = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock1->shouldReceive( 'getPriority' )->once()->andReturn( 2324 );

        $transformerMock2 = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock2->shouldReceive( 'getPriority' )->once()->andReturn( 5507 );

        $box = new ToyBox();

        // 降順に登録
        $box->push( $transformerMock2 );
        $box->push( $transformerMock1 );

        // 昇順に登録されているか
        $this->assertEquals( [2324 => $transformerMock1, 5507 => $transformerMock2 ],
            $box->getBox() );
    }

    public function testPushアクセス名を指定した保存()
    {
        $transformerMock = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock->shouldReceive( 'getPriority' )->once()->andReturn( 75987 );
        $transformerMock->shouldReceive( 'setAccessName' )->once()->with( 'アクセス名アクセス' );

        $box = new ToyBox();
        $box->push( $transformerMock, 'アクセス名アクセス' );

        $this->assertEquals( [75987 => $transformerMock ], $box->getBox() );
    }

    public function testPlay整形クラスが指定されていない場合は内容を変更しない()
    {
        $contens = "テスト\nストリング\n1234\nApple\Orange";

        $box = new ToyBox();

        $this->assertEquals( $contens, $box->play( $contens ) );
    }

    public function testPlay整形クラスをプライオリティー順に実行()
    {
        $contents = 'Test Data';
        $formatted1 = 'Change Data';
        $formatted2 = 'Final Data';

        $transformerMock1 = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock1->shouldReceive( 'getPriority' )->once()->andReturn( 1000 );
        $transformerMock1->shouldReceive( 'transform' )->once()->with( $contents )->andReturn( $formatted1 );

        $transformerMock2 = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock2->shouldReceive( 'getPriority' )->once()->andReturn( 2000 );
        $transformerMock2->shouldReceive( 'transform' )->once()->with( $formatted1 )->andReturn( $formatted2 );

        $box = new ToyBox();
        $box->push( $transformerMock1 );
        $box->push( $transformerMock2 );

        $this->assertEquals( $formatted2, $box->play( $contents ) );
    }

    public function testClear整形クラスのパージ()
    {
        $transformerMock1 = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock2 = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );

        $box = new ToyBox();
        $box->setBox( [1 => $transformerMock1, 2 => $transformerMock2 ] );
        $box->clear();

        $this->assertEquals( [ ], $box->getBox() );
    }

    public function testOffsetExists配列アクセス存在チェック()
    {
        $transformerMock = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock->shouldReceive( 'getPriority' )->once()->andReturn( 3008 );
        $transformerMock->shouldReceive( 'setAccessName' )->once()->with( 'テストアクセス名' );
        // プライオリティーで一致しない場合に呼び出されるため、３回
        $transformerMock->shouldReceive( 'getAccessName' )->times( 3 )->andReturn( 'テストアクセス名' );

        $box = new ToyBox();
        $box->push( $transformerMock, 'テストアクセス名' );

        $this->assertTrue( isset( $box[3008] ) );
        $this->assertTrue( isset( $box['テストアクセス名'] ) );
        $this->assertFalse( isset( $box[3109] ) );
        $this->assertFalse( isset( $box['存在しない名前'] ) );
    }

    public function testOffsetGet配列取得アクセス()
    {
        $transformerMock = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock->shouldReceive( 'getPriority' )->once()->andReturn( 9931 );
        $transformerMock->shouldReceive( 'setAccessName' )->once()->with( '試験アクセス名' );
        // プライオリティーで一致しない場合に呼び出されるため、３回
        $transformerMock->shouldReceive( 'getAccessName' )->times( 3 )->andReturn( '試験アクセス名' );

        $box = new ToyBox();
        $box->push( $transformerMock, '試験アクセス名' );

        $this->assertEquals( $transformerMock, $box[9931] );
        $this->assertEquals( $transformerMock, $box['試験アクセス名'] );
        $this->assertNull( $box[1212] );
        $this->assertNull( $box['あり得ない名前'] );
    }

    public function testOffsetSet配列アクセス追加時()
    {
        $transformerMock = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock->shouldReceive( 'getPriority' )->once()->andReturn( 20 );

        $data = [ 1 => new stdClass(), 30 => new stdClass() ];
        $result = $data;
        $result[20] = $transformerMock;

        $box = new ToyBox();
        $box->setBox( $data );
        // テスト対象構文、対象のオブジェクトがもつプライオリティに基づき追加
        $box[] = $transformerMock;

        $this->assertEquals( $result, $box->getBox() );
    }

    public function testOffsetSet配列アクセスプライオリティ指定時()
    {
        $transformerMock = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );

        $data = [20 => new stdClass() ];
        $result1 = $data;
        $result1[77] = $transformerMock;
        $result2 = $result1;
        $result2[88] = $transformerMock;

        $box = new ToyBox();
        $box->setBox( $data );
        // テスト対象（７７:新規プライオリティー追加）
        $box[77] = $transformerMock;

        $this->assertEquals( $result1, $box->getBox() );

        // テスト対象（８８:既存プライオリティー上書き）
        $box[88] = $transformerMock;

        $this->assertEquals( $result2, $box->getBox() );
    }

    public function testOffsetSet配列アクセス名指定新規追加時()
    {
        $mock = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $mock->shouldReceive( 'getAccessName' )->once()->andReturn( 'デフォルト名' );

        $transformerMock = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock->shouldReceive( 'setAccessName' )->once()->with( '新規アクセス名' );
        $transformerMock->shouldReceive( 'getPriority' )->once()->andReturn( 33 );

        $data = [44 => $mock ];
        $result = $data;
        $result[33] = $transformerMock;

        $box = new ToyBox();
        $box->setBox( $data );
        // テスト対象
        $box['新規アクセス名'] = $transformerMock;

        $this->assertEquals( $result, $box->getBox() );
    }

    public function testOffsetSet配列アクセス名指定更新時()
    {
        $mock = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $mock->shouldReceive( 'getAccessName' )->once()->andReturn( 'アクセス名' );

        $transformerMock = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock->shouldReceive( 'setAccessName' )->once()->with( 'アクセス名' );
        $transformerMock->shouldReceive( 'getPriority' )->once()->andReturn( 33 );

        $data = [ 66 => $mock ];
        $result = [ 33 => $transformerMock ];

        $box = new ToyBox();
        $box->setBox( $data );
        // 指定されたアクセス名のインスタンスに置き換え、新しいインスタンスを設置する
        // インスタンスのアクセス名は、指定された値に置き換わる
        // プライオリティーはインスタンスに指定されていた値
        $box['アクセス名'] = $transformerMock;

        $this->assertEquals( $result, $box->getBox() );
    }

    public function testOffsetSet配列アクセス削除()
    {
        $transformerMock1 = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock2 = Mockery::mock( 'Comja\Services\Transformers\Transformers\TransformerInterface' );
        $transformerMock2->shouldReceive( 'getAccessName' )->once()->andReturn( '削除アクセス名' );

        $data = [ 3 => $transformerMock1, 5 => $transformerMock2 ];
        $result1 = [ 5 => $transformerMock2 ];
        $result2 = [ ];

        $box = new ToyBox();
        $box->setBox( $data );
        // テスト対象
        unset( $box[3] );

        $this->assertEquals( $result1, $box->getBox() );

        // テスト対象
        unset( $box['削除アクセス名'] );

        $this->assertEquals( $result2, $box->getBox() );
    }

}