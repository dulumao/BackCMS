<?php

namespace App\Plugins\Backup;

class Backup
{

    protected $files;

    public function run( $destinationFile )
    {
        return $this->mysqlDump( $destinationFile );
    }

    public function mysqlDump( $destinationFile )
    {
        $host     = Config()->get( 'database.connections.mysql.host' );
        $port     = Config()->get( 'database.connections.mysql.port' );
        $database = Config()->get( 'database.connections.mysql.database' );
        $username = Config()->get( 'database.connections.mysql.username' );
        $password = Config()->get( 'database.connections.mysql.password' );
        $result   = [ ];

        $command = sprintf( 'mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s',
            $host,
            $port,
            $username,
            $password,
            $database,
            $destinationFile
        );

        exec( $command, $result, $ret );

        return $ret;
    }

}