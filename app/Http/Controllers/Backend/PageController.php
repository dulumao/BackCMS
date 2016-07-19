<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Response;
use App\Http\Requests\BackendRequest;

class PageController extends BackendController
{
    public function getIndex()
    {
        $this->permission();

        $pages = \App\Models\Page::all();

        return View( 'Backend.Page.Index' )->with( [
            'pages' => $pages
        ] );
    }

    public function postDelete( BackendRequest $request )
    {
        $this->permission();

        $ids = $request->input( 'ids' );

        if ( is_array( $ids ) ) {
            $return = [ ];
            foreach ( $ids as $id ) {
                $page     = \App\Models\Page::find( $id );
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
            $page = \App\Models\Page::find( $ids );

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

    public function getEdit( BackendRequest $request, $id )
    {
        $this->permission();

        $page = \App\Models\Page::find( $id );

        if ( $request->isXmlHttpRequest() ) {
            return $page;
        } else {
            $templates = \App\Models\Template::whereType( 1 )->get();
            $forms     = \App\Models\Form::all();

            return View( 'Backend.Page.Edit' )->with( [
                'page'      => $page,
                'templates' => $templates,
                'forms'     => $forms
            ] );
        }

    }

    public function postEdit( BackendRequest $request, $id )
    {
        $this->permission();

        $title   = $request->input( 'title' );
        $body    = $request->input( 'body' );
        $enabled = $request->input( 'enabled' );
        $engine  = $request->input( 'engine' );

        $this->validate( $request, [
            'title'   => 'required',
            'enabled' => 'required',
        ], [
            'required' => '必填写内容'
        ] );

        $page          = \App\Models\Page::find( $id );
        $page->title   = $title;
        $page->body    = $body;
        $page->enabled = $enabled;
        $page->engine  = $engine;

        if ( $page->save() )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }

    public function getCreate()
    {
        $this->permission();

        $templates = \App\Models\Template::whereType( 1 )->get();
        $forms     = \App\Models\Form::all();

        return View( 'Backend.Page.Create' )->with( [
            'templates' => $templates,
            'forms'     => $forms
        ] );
    }

    public function postCreate( BackendRequest $request )
    {
        $this->permission();

        $title   = $request->input( 'title' );
        $body    = $request->input( 'body' );
        $enabled = $request->input( 'enabled' );
        $engine  = $request->input( 'engine' );

        $this->validate( $request, [
            'title'   => 'required',
            'enabled' => 'required',
        ], [
            'required' => '必填写内容'
        ] );

        $page          = new \App\Models\Page;
        $page->title   = $title;
        $page->body    = $body;
        $page->enabled = $enabled;
        $page->engine  = $engine;

        if ( $page->save() )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }

}
