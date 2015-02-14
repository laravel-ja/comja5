<?php

namespace Comja\Services;

class Translator
{

    public function trans( $fileName, $transArray )
    {
        $realName = realpath( $fileName );

        // ファイル読み込み
        $contents = file_get_contents( $realName );
        if( $contents === false || $contents === 0 )
        {
            fputs( STDERR, __( 'ファイル:'.$realName.'を読み込めませんでした。' ).PHP_EOL );
            return;
        }

        // 英語 => 日本語変換
        $translatedContent = str_replace( array_keys( $transArray ), array_values( $transArray ), $contents );

        // ファイル書き出し
        $ret = file_put_contents( $realName, $translatedContent );
        if( $ret === false )
        {
            fputs( STDERR, __( 'ファイル:'.$realName.'へ書き込めませんでした。' ).PHP_EOL );
            return;
        }
    }

}