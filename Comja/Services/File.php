<?php

namespace Comja\Services;

class File
{

    public function globAll( $path, $pattern )
    {
        $paths = glob( rtrim( $path, '/' ).'/*', GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT );
        $files = glob( rtrim( $path, '/' ).'/'.$pattern, GLOB_MARK );

        foreach( $paths as $path )
        {
            $files = array_merge( $files, $this->globAll( $path, $pattern ) );
        }

        return array_filter( $files, function ($value)
        {
            return substr( $value, -1, 1 ) != '/';
        } );
    }

    public function copyDir( $srcDir, $distDir )
    {
        $dir = opendir( $srcDir );
        @mkdir( $distDir );
        while( false !== ( $file = readdir( $dir )) )
        {
            if( ( $file != '.' ) && ( $file != '..' ) )
            {
                if( is_dir( $srcDir.'/'.$file ) )
                {
                    copyDir( $srcDir.'/'.$file, $distDir.'/'.$file );
                }
                else
                {
                    copy( $srcDir.'/'.$file, $distDir.'/'.$file );
                }
            }
        }
        closedir( $dir );
    }

}