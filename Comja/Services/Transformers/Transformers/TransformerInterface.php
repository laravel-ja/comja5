<?php

namespace Comja\Services\Transformers\Transformers;

interface TransformerInterface
{

    public function transform( $contents );

    public function getPriority();

    public function getAccessName();

    public function setAccessName( $accessName );

}