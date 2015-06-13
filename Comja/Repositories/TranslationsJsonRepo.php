<?php

namespace Comja\Repositories;

use Comja\Services\File;

/**
 * JSON形式の翻訳データーリポジトリ.
 *
 * @author Hirohisa Kawase
 */
class TranslationsJsonRepo
{
    use FileRepositoryTrait;

    /**
     * 翻訳データファイル名.
     *
     * @var string
     */
    protected $translationFileName = '';

    /**
     * コンストラクター.
     *
     * @codeCoverageIgnore
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * 全データー取得.
     *
     * @return array キャッシュ済み全取得データ
     */
    public function getAll()
    {
        $this->feachAll();

        return $this->cache;
    }

    /**
     * ファイル名を指定し、翻訳データ配列を拾得
     * ファイル名と英文を指定し、対応する和文を取得.
     *
     * @param string $fileName
     * @param string $enString
     *
     * @return array|string|bool データ不一致の場合false
     */
    public function get($fileName, $enString = null)
    {
        $this->feachAll();

        if (is_null($enString)) {
            return array_key_exists($fileName, $this->cache) ? $this->cache[$fileName] : false;
        }

        if (!array_key_exists($fileName, $this->cache)) {
            return false;
        }

        return array_key_exists($enString, $this->cache[$fileName]) ? $this->cache[$fileName][$enString] : false;
    }

    /**
     * 全データをストレージから取得.
     *
     * データはインストールディレクトリーからの相対パスで構築されている。
     * Windows対応でrealpathを通すため、絶対パスに変換して返す。
     *
     * @return array key:ファイル名、value:英文をキー、和文を値とした配列
     */
    public function readAllLine()
    {
        $cwd          = $this->file->getCurrentDir();
        $translations = $this->file->readJson(__DIR__.'/../../'.$this->translationFileName);

        $absKeyTranslation = [];
        foreach ($translations as $filePath => $translation) {
            $absolutePath = $this->file->getRealPath($cwd.'/'.$filePath);

            if (!is_null($absolutePath)) {
                $absKeyTranslation[$absolutePath] = $translation;
            }
        }

        return $absKeyTranslation;
    }
}
