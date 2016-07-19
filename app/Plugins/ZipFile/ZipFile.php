<?php
namespace App\Plugins\ZipFile;

class ZipFile
{

    protected $zipFile;
    protected $pathToZip;

    public function run( $pathToZip, $files = [ ] )
    {
        $this->zipFile = new \ZipArchive();

        if ( $this->zipFile->open( $pathToZip, \ZipArchive::CREATE ) === true ) {
            foreach ( $files as $file ) {
                $this->zipFile->addFile( $file );
            }

            $this->zipFile->close();
        }

        return $this;
    }

}