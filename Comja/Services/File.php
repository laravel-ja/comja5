<?php

namespace Comja\Services;

defined( "DS" ) || define( "DS", DIRECTORY_SEPARATOR );

class File
{

    /**
     * ファイル名の取得
     *
     * @param string $path ルートディレクトリ
     * @param string $pattern 一致パターン
     * @return array ファイル名の配列
     */
    public function globFiles( $path, $pattern )
    {
        $realPath = realpath( $path );

        $paths = glob( rtrim( $realPath, DS ).DS.'*', GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT );
        $files = glob( rtrim( $realPath, DS ).DS.$pattern, GLOB_MARK );

        foreach( $paths as $path )
        {
            $files = array_merge( $files, $this->globFiles( $path, $pattern ) );
        }

        return array_filter( $files, function ($value)
        {
            return substr( $value, -1, 1 ) != DS;
        } );
    }

    /**
     * ディレクトリー再帰コピー
     *
     * @param string $srcDir コピー元ディレクトリー
     * @param string $distDir コピー先ディレクトリー
     */
    public function copyDir( $srcDir, $distDir )
    {
        $srcRealPath = realpath( $srcDir );
        $distRealPath = realpath( $distDir );

        @mkdir( $distRealPath );

        if( false === ($dirHandler = opendir( $srcRealPath )) )
        {
            fputs( STDERR, __( 'ディレクトリー:'.$srcRealPath.'が開けません。' ).PHP_EOL );
            return;
        }

        while( false !== ( $file = readdir( $dirHandler )) )
        {
            if( ( $file != '.' ) && ( $file != '..' ) )
            {
                if( is_dir( realpath( $srcRealPath.DS.$file ) ) )
                {
                    $this->copyDir( realpath( $srcRealPath.DS.$file ), realpath( $distRealPath.DS.$file ) );
                }
                else
                {
                    copy( realpath( $srcRealPath.DS.$file ), realpath( $distRealPath.DS.$file ) );
                }
            }
        }
        closedir( $dirHandler );
    }

}