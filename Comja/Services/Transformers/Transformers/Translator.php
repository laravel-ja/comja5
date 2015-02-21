<?php

namespace Comja\Services\Transformers\Transformers;

/**
 * 翻訳
 *
 * @author Hirohisa Kawase
 */
class Translator implements TransformerInterface
{

    protected $translations = [ ];

    protected $accessName = '翻訳';

    public function transform( $contents )
    {
        return str_replace( array_keys( $this->translations ),
            array_values( $this->translations ), $contents );
    }

    public function getPriority()
    {
        return 1000;
    }

    public function setTranslations( $translations )
    {
        $this->translations = $translations;
    }

    public function getAccessName()
    {
        return $this->accessName;
    }

    public function setAccessName( $accessName )
    {
        $this->accessName = $accessName;
    }

}