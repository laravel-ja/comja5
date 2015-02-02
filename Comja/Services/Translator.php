<?php

namespace Comja\Services;

/**
 * Description of Translator
 *
 * @author Hirohisa Kawase
 */
class Translator
{

    public function trans( $translations )
    {
        foreach ($translations as $fileName => $transArray)
        {
            // ファイル読み込み
            $contents = file_get_contents($fileName);

            // 英語 => 日本語変換
            $translatedContent = str_replace(array_keys($transArray), array_values($transArray), $contents);

            // ファイル書き出し
            file_put_contents($fileName, $translatedContent);
        }
    }

}