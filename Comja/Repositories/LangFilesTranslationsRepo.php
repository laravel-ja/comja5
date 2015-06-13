<?php

namespace Comja\Repositories;

/**
 * 言語ファイル翻訳情報リポジトリ.
 *
 * @author Hirohisa Kawase
 */
class LangFilesTranslationsRepo extends TranslationsJsonRepo
{
    protected $translationFileName = 'trans_lang_lines.json';
}
