<?php

namespace Comja\Services;

class CommentsFormatter
{

    public function remove( $filePath )
    {
        $realName = realpath( $filePath );

        $content = file_get_contents( $realName );
        if( $content === false )
        {
            fputs( STDERR, __( 'ファイル名:'.$realName.'が読み込めません。' ).PHP_EOL );
            return;
        }

        // 行コメント削除
        $noLineComment = preg_replace( '#^\s*//.*$#m', "", $content );

        // ブロックコメント削除
        $noBlockComment = preg_replace( '#/\*.+\*/#sU', '', $noLineComment );

        // 空行削除
        $noSpaceLine = preg_replace( '/^\s*\n/m', '', $noBlockComment );

        // 最終行に空行追加
        $addedEmptyLine = rtrim( $noSpaceLine, "\n" )."\n";

        $ret = file_put_contents( $realName, $addedEmptyLine );
//        if( $ret === false )
//        {
//            fputs( STDERR, __('ファイル名:'.$realName.'が書き込めません。').PHP_EOL );
//            return;
//        }
    }

}