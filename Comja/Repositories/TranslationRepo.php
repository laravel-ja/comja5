<?php

namespace Comja\Repositories;

/**
 * 翻訳ベースファイルリポジトリー
 *
 * @author Hirohisa Kawase
 */
class TranslationRepo
{

    /**
     * 翻訳ファイル取得
     *
     * @return array キーがファイル名、翻訳内容が値の配列。翻訳内容も英文がキー、和文が値の配列。
     */
    public function get( $translationFile )
    {
        $contents = explode( PHP_EOL, file_get_contents( $translationFile ) );

        $translations = [ ];
        $match = [ ];

        foreach( $contents as $line )
        {
            if( strpos( $line, '読み込み:' ) === 0 )
            {
                $fileName = str_replace( '読み込み:', '', $line );
            }
            elseif( preg_match( "/^([^\t]+)\t([^\t]+)$/", $line, $match ) )
            {
                $translations[$fileName][$match[1]] = $match[2];
            }
        }

        return $translations;
    }

}