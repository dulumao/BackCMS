<?php

Route::controller( 'login', 'LoginController' );
Route::controller( 'dashboard', 'DashboardController' );
Route::controller( 'page', 'PageController' );
Route::controller( 'archive', 'ArchiveController' );
Route::controller( 'setting', 'SettingController' );
Route::controller( 'manager', 'ManagerController' );
Route::controller( 'template', 'TemplateController' );
Route::controller( 'form', 'FormController' );


Route::get( 'd', function () {
    $archiveParents  = \App\Models\ArchiveField::wherePid( 0 )->get();
    $categoriesArray = [];

    $getCategories = function ( $parent ) use ( &$getCategories, &$categoriesArray ) {
        $subCategories = \App\Models\ArchiveField::wherePid( $parent->id )->get();

        foreach ( $subCategories as $subCategory ) {
            foreach ( $categoriesArray as $idx => $value ) {
                if ( $value['id'] == $subCategory->pid ) {
                    $categoriesArray[$idx]['subs'][] = [
                        'id'   => $subCategory->id,
                        'name' => $subCategory->name,
                    ];
                }

            }

            $getCategories( $subCategory );
        }
        return $categoriesArray;
    };


    foreach ( $archiveParents as $parent ) {
        $categoriesArray[] = [
            'id'   => $parent->id,
            'name' => $parent->name,
        ];
        $getCategories( $parent );
    }

    dd( $categoriesArray );
} );