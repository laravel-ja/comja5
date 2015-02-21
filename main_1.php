<?php

include_once "vendor/autoload.php";

use Comja\Repositories\CommentTranslationsRepo;
use Comja\Services\File;

$repo = new CommentTranslationsRepo(new File);

var_dump( $repo->get("resources/lang/en/pagination.php", "Pagination Language Lines") );
