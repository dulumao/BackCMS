<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Requests\BackendRequest;

class TemplateController extends BackendController
{
    public function getIndex()
    {
        $this->permission();

        $templates = \App\Models\Template::all();

        return View( 'Backend.Template.Index' )->with( [
            'templates' => $templates
        ] );
    }

    public function getCreate()
    {
        $this->permission();

        $templates  = \App\Models\Template::all();
        $formFields = \App\Models\FormField::all();

        return View( 'Backend.Template.Create' )->with( [
            'templates'  => $templates,
            'formFields' => $formFields
        ] );
    }

    public function postCreate( BackendRequest $request )
    {
        $this->permission();

        $name = $request->input( 'name' );
        $type = $request->input( 'type', 0 );
        $code = $request->input( 'code' );

        $template         = new \App\Models\Template;
        $template->name   = $name;
        $template->type   = $type;
        $template->system = 0;
        $template->code   = $code;

        if ( $template->save() )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }

    public function getEdit( BackendRequest $request, $id )
    {
        $this->permission();

        $template = \App\Models\Template::find( $id );

        if ( $request->isXmlHttpRequest() ) {
            return $template;
        } else {
            $templates  = \App\Models\Template::all();
            $formFields = \App\Models\FormField::all();

            return View( 'Backend.Template.Edit' )->with( [
                'template'   => $template,
                'templates'  => $templates,
                'formFields' => $formFields
            ] );
        }
    }

    public function postEdit( BackendRequest $request, $id )
    {
        $this->permission();

        $name = $request->input( 'name' );
        $type = $request->input( 'type', 0 );
        $code = $request->input( 'code' );

        $template       = \App\Models\Template::find( $id );
        $template->name = $name;
        $template->type = $type;
        $template->code = $code;

        if ( $template->save() )
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
                $page     = \App\Models\Template::find( $id );
                $return[] = $page->delete();
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
            $page = \App\Models\Template::find( $ids );

            if ( $page->delete() )
                return Response()->json( [
                    'code' => 'success',
                ] );
            else
                return Response()->json( [
                    'code' => 'error',
                ] );
        }
    }
}
