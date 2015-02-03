<?php

namespace Comja\Services;

/**
 * Description of File
 *
 * @author Hirohisa Kawase
 */
class File
{

    public function globAll( $path, $pattern )
    {
        $paths = glob( rtrim( $path, '/' ).'/*', GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT );
        $files = glob( rtrim( $path, '/' ).'/'.$pattern );

        foreach( $paths as $path )
        {
            $files = array_merge( $files, $this->globAll( $path, $pattern ) );
        }

        return array_filter( $files, function ($value) {
            return substr($value, -1, 1) != '/';
        });
    }

}