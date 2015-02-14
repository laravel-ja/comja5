<?php

namespace Comja\Services;

class TabFormatter
{

    public function tabToSpace( $fileName, $spaceColum )
    {
        $content = file_get_contents( $fileName );
        if( $content === false )
        {
            fputs( STDERR, _('ファイル名:'.$fileName.'が読み込めません。').PHP_EOL );
            return;
        }

        $ret = file_put_contents( $fileName, str_replace( "\t", str_repeat( ' ', $spaceColum ), $content ) );
//        if( $ret === false )
//        {
//            fputs( STDERR, _('ファイル名:'.$fileName.'が書き込めません。').PHP_EOL );
//            return;
//        }
    }

}