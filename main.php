<?php

include_once "vendor/autoload.php";

use Comja\Repositories\TranslationRepo;
use Comja\Services\Translator;

// 翻訳データ読み込み

print '翻訳開始…';

$translationRepo = new TranslationRepo();
$translations = $translationRepo->get();

var_dump($translations); die();

// 翻訳

$translator = new Translator;
$translator->trans($translations);

print '翻訳終了';