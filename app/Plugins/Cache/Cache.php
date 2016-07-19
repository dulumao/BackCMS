<?php

namespace App\Plugins\Cache;

use Illuminate\Filesystem\Filesystem;

class Cache
{

    protected $files;

    public function run()
    {
        $this->files = new Filesystem;

        return $this;
    }

    public function clearView()
    {
        foreach ( $this->files->files( storage_path() . '/framework/views' ) as $file ) {
            $this->files->delete( $file );
        }
    }

    public function clearSession()
    {
        foreach ( $this->files->files( storage_path() . '/framework/sessions' ) as $file ) {
            $this->files->delete( $file );
        }
    }

    public function clearCache()
    {
        foreach ( $this->files->files( storage_path() . '/framework/cache' ) as $file ) {
            $this->files->delete( $file );
        }
    }

    public function getViewSize()
    {
        $totalSize = 0;

        foreach ( $this->files->files( storage_path() . '/framework/views' ) as $file ) {
            $totalSize += $this->files->size( $file );
        }

        $totalSize = round( $totalSize / 1024, 2 ) . ' kb';

        return $totalSize;
    }

    public function getCacheSize()
    {
        $totalSize = 0;

        foreach ( $this->files->files( storage_path() . '/framework/cache' ) as $file ) {
            $totalSize += $this->files->size( $file );
        }

        $totalSize = round( $totalSize / 1024, 2 ) . ' kb';

        return $totalSize;
    }

    public function getSessionSize()
    {
        $totalSize = 0;

        foreach ( $this->files->files( storage_path() . '/framework/sessions' ) as $file ) {
            $totalSize += $this->files->size( $file );
        }

        $totalSize = round( $totalSize / 1024, 2 ) . ' kb';

        return $totalSize;
    }

    public function isWritable( $file )
    {
        return $this->files->isWritable( $file );
    }

}