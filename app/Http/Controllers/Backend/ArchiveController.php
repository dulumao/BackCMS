<?php

namespace App\Http\Controllers\Backend;

use App\Facades\Addons;
use App\Http\Controllers\BackendController;
use App\Http\Requests\BackendRequest;

class ArchiveController extends BackendController
{
    public function getIndex()
    {
        $this->permission();

        $fieldIds = [ ];

        $archiveFields = \App\Models\ArchiveField::all();

        foreach ( $archiveFields as $field ) {
            $fieldIds[] = $field->id;
        }

        \Plugins::register( 'Pagination', 'App\Plugins\Pagination\Pagination' );

        $archives = \App\Models\Archive::whereIn( 'archive_field_id', $fieldIds )->simplePaginate( 20 );

        // 构造无限极分类 begin
        $items = $archiveFields->toArray();

        array_unshift( $items, '' );      // 下方的 foreach 只能处理 下标由1开始的数组(下标与行id对应)
        unset( $items[ 0 ] );               // 因此暂时使用这种方式处理

        foreach ( $items as $item )
            $items[ $item[ 'pid' ] ][ 'children' ][] = &$items[ $item[ 'id' ] ];
        $archiveFields = isset( $items[ 0 ][ 'children' ] ) ? $items[ 0 ][ 'children' ] : [ ];

        // 构造无限极分类 end

//        array_multisort($archiveFields);
//        return $archiveFields;
        return View( 'Backend.Archive.Index' )->with( [
            'archiveFields' => $archiveFields,
            'archives'      => $archives
        ] );
    }

    public function getCreate()
    {
        $this->permission();

        $templates = \App\Models\Template::whereType( 2 )->get();

        $parents = \App\Models\ArchiveField::select( [ 'id', 'pid', 'field', 'name' ] )->get();

        return View( 'Backend.Archive.Create' )->with( [
            'templates' => $templates,
            'parents'   => $parents
        ] );
    }

    public function postCreate( BackendRequest $request )
    {
        $this->permission();

        $inputs                   = $request->except( '_token' );
        $archiveNames             = $inputs[ 'archiveName' ];
        $archiveImages            = $inputs[ 'archiveImage' ];
        $archiveDescriptions      = $inputs[ 'archiveDescription' ];
        $archiveShortDescriptions = $inputs[ 'short_description' ];
        $archiveForwards          = $inputs[ 'forward' ];
        $attributeNames           = $inputs[ 'attributeName' ];
        $attributeTypes           = $inputs[ 'attributeType' ];
        $attributeLabels          = $inputs[ 'attributeLabel' ];
        $attributeDefaults        = $inputs[ 'attributeDefault' ];
        $attributeRequireds       = isset( $inputs[ 'attributeRequired' ] ) ? $inputs[ 'attributeRequired' ] : 0;
        $attributeSelect          = isset( $inputs[ 'attributeSelect' ] ) ? $inputs[ 'attributeSelect' ] : null;
        $attributeTemplate        = isset( $inputs[ 'attributeTemplate' ] ) ? $inputs[ 'attributeTemplate' ] : null;
        $listTemplate             = $inputs[ 'list_template' ];
        $showTemplate             = $inputs[ 'show_template' ];
        $parentId                 = $inputs[ 'parent_id' ];

        $fields = [ ];

        foreach ( $attributeNames as $key => $name ) {
            if ( isset( $attributeRequireds[ $key ] ) ) {
                $required = $attributeRequireds[ $key ];
            } else {
                $required = '0';
            }

            $fields[] = [
                'name'     => $name,
                'type'     => $attributeTypes[ $key ],
                'label'    => $attributeLabels[ $key ],
                'default'  => $attributeDefaults[ $key ],
                'required' => $required,
            ];

            if ( $attributeTypes[ $key ] == 'select' ) {
                $fields[ $key ] = array_merge( $fields[ $key ], [
                    'options' => $attributeSelect[ $key ]
                ] );
            }

            if ( $attributeTypes[ $key ] == 'template' ) {
                $fields[ $key ] = array_merge( $fields[ $key ], [
                    'view' => $attributeTemplate[ $key ]
                ] );
            }
        }


        $deepth = ( $parentId == 0 ) ? 0 : \App\Models\ArchiveField::whereId( $parentId )->value( 'deepth' ) + 1;

        $archiveField                    = new \App\Models\ArchiveField;
        $archiveField->name              = $archiveNames;
        $archiveField->image             = $archiveImages;
        $archiveField->description       = $archiveDescriptions;
        $archiveField->short_description = $archiveShortDescriptions;
        $archiveField->forward           = $archiveForwards;
        $archiveField->field             = json_encode( $fields );
        $archiveField->list_template     = $listTemplate;
        $archiveField->show_template     = $showTemplate;
        $archiveField->pid               = $parentId;
        $archiveField->deepth            = $deepth;

        if ( $archiveField->save() )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );

    }

    public function postAttributes( BackendRequest $request )
    {
        $this->permission();

        $field = $request->input( 'field' );

        return View( 'Backend.Archive.Template.Attributes' )->with( [
            'field' => $field
        ] );
    }

    public function getList( $id )
    {
        $this->permission();

        $field    = \App\Models\ArchiveField::find( $id );
        $archives = \App\Models\Archive::whereArchiveFieldId( $field->id )->get();

        return View( 'Backend.Archive.List' )->with( [
            'archives' => $archives,
            'field'    => $field
        ] );
    }

    public function getAdd( $id )
    {
        $this->permission();

        $field = \App\Models\ArchiveField::find( $id );

        $attributes = json_decode( $field->field );

        \Plugins::register( 'Tags', 'App\Plugins\Tags\Tags' );

        return View( 'Backend.Archive.Add' )->with( [
            'field'      => $field,
            'attributes' => $attributes
        ] );
    }

    public function postAdd( BackendRequest $request, $id )
    {
        $this->permission();

        $inputs = $request->except( [
            '_token',
            'title',
            'keywords',
            'description'
        ] );

        $title       = $request->input( 'title' );
        $keywords    = $request->input( 'keywords' );
        $description = $request->input( 'description' );

        $archive = new \App\Models\Archive;

        $archive->archive_field_id = $id;
        $archive->title            = $title;
        $archive->keywords         = $keywords;
        $archive->description      = $description;
        $archive->body             = json_encode( $inputs );

        if ( $archive->save() )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }

    public function getEdit( $id )
    {
        $this->permission();

        $archive = \App\Models\Archive::find( $id );
        $field   = $archive->getArchiveField;

        \Plugins::register( 'Tags', 'App\Plugins\Tags\Tags' );

        return View( 'Backend.Archive.Edit' )->with( [
            'archive' => $archive,
            'field'   => $field
        ] );
    }

    public function postEdit( BackendRequest $request, $id )
    {
        $this->permission();

        $inputs = $request->except( [
            '_token',
            'title',
            'keywords',
            'description'
        ] );

        $title       = $request->input( 'title' );
        $keywords    = $request->input( 'keywords' );
        $description = $request->input( 'description' );

        $archive = \App\Models\Archive::find( $id );

        $archive->title       = $title;
        $archive->keywords    = $keywords;
        $archive->description = $description;
        $archive->body        = json_encode( $inputs );

        if ( $archive->save() )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }

    public function postDelete( BackendRequest $request )
    {
        $this->permission();

        $ids = $request->input( 'ids' );

        if ( is_array( $ids ) ) {
            $return = [ ];
            foreach ( $ids as $id ) {
                $archive  = \App\Models\Archive::find( $id );
                $return[] = $archive->delete();
            }

            if ( $return ) {
                return Response()->json( [
                    'code' => 'success',
                ] );
            } else {
                return Response()->json( [
                    'code' => 'error',
                ] );
            }
        } else {
            $archive = \App\Models\Archive::find( $ids );

            if ( $archive->delete() )
                return Response()->json( [
                    'code' => 'success',
                ] );
            else
                return Response()->json( [
                    'code' => 'error',
                ] );
        }
    }

    public function postDeleteField( BackendRequest $request )
    {
        $this->permission();

        $id           = $request->input( 'id' );
        $archiveField = \App\Models\ArchiveField::find( $id );

        if ( $archiveField->delete() )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }
}
