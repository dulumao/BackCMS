<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArchiveController extends Controller
{
    public function getIndex()
    {

    }

    public function getList( $id )
    {
        $archiveField = \App\Models\ArchiveField::with( 'getArchive' )->whereId( $id )->first();

        $args = [
            'field' => $archiveField,
        ];

        return compileBlade( $archiveField->getListTemplate->code, $args );
    }

    public function getShow( $id )
    {
        $archive              = \App\Models\Archive::find( $id );
        $args                 = json_decode( $archive->body, true );
        $args[ 'created_at' ] = $archive->created_at;
        $args[ 'archive_id' ] = $archive->id;

        return compileBlade( $archive->getArchiveField->getShowTemplate->code, $args );
    }
}
