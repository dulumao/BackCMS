<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;

class DashboardController extends BackendController
{
    public function getIndex()
    {
        $pages         = \App\Models\Page::all();
        $activities    = \App\Models\Activity::with( 'getUser' )->take( 8 )->orderBy( 'created_at', 'DESC' )->get();
        $archiveFields = \App\Models\ArchiveField::all();
        $formFields    = \App\Models\FormField::all();

        return View( 'Backend.Dashboard' )->with( [
            'pages'         => $pages,
            'activities'    => $activities,
            'archiveFields' => $archiveFields,
            'formFields'    => $formFields
        ] );
    }
}
