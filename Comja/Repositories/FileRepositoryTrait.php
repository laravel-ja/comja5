<?php

namespace Comja\Repositories;

/**
 * FileRepositoryTrait.
 *
 * ファイル読み込みリポの基本機能
 *
 * @author Hirohisa Kawase
 */
trait FileRepositoryTrait
{
    /**
     * 読み込みデータ
     *
     * @var array 取得データ
     */
    private $cache = [];

    /**
     * 読み込み対象ファイル名.
     *
     * @var string ファイル名
     */
    private $fileName = null;

    /**
     * $fileNameセッター.
     *
     * @codeCoverageIgnore
     *
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * $cacheセッター.
     *
     * @codeCoverageIgnore
     *
     * @param array $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * $cacheゲッター.
     *
     * @codeCoverageIgnore
     *
     * @return array $cacheの内容
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * キャッシュ済みのチェック.
     *
     * @return bool
     */
    public function isCached()
    {
        return !empty($this->cache);
    }

    /**
     * データ取得済みかをチェックし、
     * 未取得時は読み込み、キャッシュする.
     */
    public function feachAll()
    {
        if ($this->isCached()) {
            return;
        }

        // データー構造は、各リポジトリに依存するため、
        // use元のクラスのreadAllLineに任せる。
        $this->cache = $this->readAllLine();
    }
}
