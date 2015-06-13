<?php

namespace Comja\Services;

use RuntimeException;

defined('DS') || define('DS', DIRECTORY_SEPARATOR);

/**
 * ファイル操作クラス.
 *
 * @author Hirohisa Kawase
 */
class File
{
    /**
     * JSONテキストの読み込み
     *
     * @param string $path ファイルパス
     *
     * @throws RuntimeException ファイル読み込み失敗時
     *
     * @return array 読み込み内容の配列
     */
    public function readJson($path)
    {
        if (false == ($realPath = $this->getRealPath($path))) {
            throw new RuntimeException(c5_trans($realPath.'ファイルが存在していません。'));
        }

        if (false === ($contents = $this->getContents($realPath))) {
            throw new RuntimeException(c5_trans($realPath.'ファイルが読み込めませんでした。'));
        }

        if (null == ($arr = json_decode($contents, true))) {
            throw new RuntimeException(c5_trans($realPath.'ファイルの形式が不正です。('.$this->getJsonLastError().')'));
        }

        return $arr;
    }

    /**
     * ファイル名配列の取得.
     *
     * @param string $path    ルートディレクトリ
     * @param string $pattern 一致パターン
     *
     * @return array ファイル名の配列
     */
    public function globFiles($path, $pattern)
    {
        $realPath = $this->getRealPath($path);

        $paths = glob(rtrim($realPath, DS).DS.'*',
            GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT);
        $files = glob(rtrim($realPath, DS).DS.$pattern, GLOB_MARK);

        foreach ($paths as $path) {
            $files = array_merge($files, $this->globFiles($path, $pattern));
        }

        // ディレクトリー名は除外する
        return array_filter($files,
            function ($value) {
            return substr($value, -1, 1) != DS;
        });
    }

    /**
     * ディレクトリー再帰コピー.
     *
     * @param string $srcDir  コピー元ディレクトリー
     * @param string $distDir コピー先ディレクトリー
     */
    public function copyDir($srcDir, $distDir)
    {
        $srcRealPath = $this->getRealPath($srcDir);

        // realpathはディレクトリーが存在しないとfalseになるので使えない。
        @mkdir($distDir);
        $distRealPath = $this->getRealPath($distDir);

        if (false === ($dirHandler = opendir($srcRealPath))) {
            fputs(STDERR, c5_trans('ディレクトリー:'.$srcRealPath.'が開けません。').PHP_EOL);

            return;
        }

        while (false !== ($file = readdir($dirHandler))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($srcRealPath.DS.$file)) {
                    $this->copyDir($srcRealPath.DS.$file, $distRealPath.DS.$file);
                } else {
                    copy($srcRealPath.DS.$file, $distRealPath.DS.$file);
                }
            }
        }
        closedir($dirHandler);
    }

    public function getRelativePath($path, $basePath)
    {
        // 簡易版
        return trim(str_replace($basePath, '', $path), DS);
    }

    /**
     * ユニットテストのためのラップメソッド.
     *
     * @codeCoverageIgnore
     *
     * @param string $path
     *
     * @return string
     */
    public function getRealPath($path)
    {
        return realpath($path);
    }

    /**
     * ユニットテストのためのラップメソッド.
     *
     * @codeCoverageIgnore
     *
     * @param type $path
     *
     * @return type
     *
     * @throws RuntimeException
     */
    public function getContents($path)
    {
        $contents = file_get_contents($path);

        if (!$contents) {
            throw new RuntimeException(c5_trans('ファイル:'.$path).'が読み込めませんでした。');
        }

        return $contents;
    }

    /**
     * ユニットテストのためのラップメソッド.
     *
     * @codeCoverageIgnore
     *
     * @param type $path
     * @param type $contents
     *
     * @throws RuntimeException
     */
    public function putContents($path, $contents)
    {
        $ret = file_put_contents($path, $contents);

        if (!$ret) {
            throw new RuntimeException(c5_trans('ファイル:'.$path.'へ書き込めませんでした。'));
        }
    }

    /**
     * ユニットテストのためのラップメソッド.
     *
     * @codeCoverageIgnore
     *
     * @return string|bool
     */
    public function getCurrentDir()
    {
        return getcwd();
    }

    /**
     * json_decodeのエラー発生要因を返す.
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function getJsonLastError()
    {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return 'JSON_ERROR_NONE';
            case JSON_ERROR_DEPTH:
                return 'JSON_ERROR_DEPTH';
            case JSON_ERROR_STATE_MISMATCH:
                return 'JSON_ERROR_STATE_MISMATCH';
            case JSON_ERROR_CTRL_CHAR:
                return 'JSON_ERROR_CTRL_CHAR';
            case JSON_ERROR_SYNTAX:
                return 'JSON_ERROR_SYNTAX';
            case JSON_ERROR_UTF8:
                return 'JSON_ERROR_UTF8';
            default:
                return '未定義エラー';
        }
    }
}
