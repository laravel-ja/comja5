<?php

namespace Comja\Services;

class TabFormatter
{

    public function tabToSpace( $fileName, $spaceColum )
    {
        $realName = realpath( $fileName );

        $content = file_get_contents( $realName );
        if( $content === false )
        {
            fputs( STDERR, __( 'ファイル名:'.$realName.'が読み込めません。' ).PHP_EOL );
            return;
        }

        $ret = file_put_contents( $realName, str_replace( "\t", str_repeat( ' ', $spaceColum ), $content ) );
//        if( $ret === false )
//        {
//            fputs( STDERR, __('ファイル名:'.$realName.'が書き込めません。').PHP_EOL );
//            return;
//        }
    }

}