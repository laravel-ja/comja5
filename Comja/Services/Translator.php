<?php

namespace Comja\Services;

class Translator
{

    public function trans( $fileName, $transArray )
    {
        // ファイル読み込み
        $contents = file_get_contents( $fileName );
        if( !$contents )
        {
            fputs( STDERR, _('ファイル:'.$fileName.'を読み込めませんでした。').PHP_EOL );
            return;
        }

        // 英語 => 日本語変換
        $translatedContent = str_replace( array_keys( $transArray ), array_values( $transArray ), $contents );

        // ファイル書き出し
        $ret = file_put_contents( $fileName, $translatedContent );
        if( $ret === false )
        {
            fputs( STDERR, _('ファイル:'.$fileName.'へ書き込めませんでした。').PHP_EOL );
            return;
        }
    }

}