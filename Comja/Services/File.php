<?php

namespace Comja\Services;

/**
 * Description of File
 *
 * @author Hirohisa Kawase
 */
class File
{

    private function globAll( $path, $pattern )
    {
        $paths = $this->file->glob( rtrim( $path, '/' ).'/*', GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT );
        $files = $this->file->glob( rtrim( $path, '/' ).'/'.$pattern );

        foreach( $paths as $path )
        {
            $files = array_merge( $files, $this->globAll( $path, $pattern ) );
        }

        return $files;
    }

}