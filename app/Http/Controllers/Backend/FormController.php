<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Requests\BackendRequest;

class FormController extends BackendController
{
    public function getIndex()
    {
        $this->permission();

        $formFields = \App\Models\FormField::all();

        return View( 'Backend.Form.Index' )->with( [
            'formFields' => $formFields
        ] );
    }

    public function getCreate()
    {
        $this->permission();

        return View( 'Backend.Form.Create' );
    }

    public function postCreate( BackendRequest $request )
    {
        $this->permission();

        $name   = $request->input( 'name' );
        $plugin = $request->input( 'plugin' );

        $formField         = new \App\Models\FormField;
        $formField->name   = $name;
        $formField->plugin = $plugin;

        if ( $formField->save() )
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

        $formField = \App\Models\FormField::find( $id );

        return View( 'Backend.Form.Edit' )->with( [
            'formField' => $formField
        ] );
    }

    public function postEdit( BackendRequest $request, $id )
    {
        $this->permission();

        $name   = $request->input( 'name' );
        $plugin = $request->input( 'plugin' );

        $formField         = \App\Models\FormField::find( $id );
        $formField->name   = $name;
        $formField->plugin = $plugin;

        if ( $formField->save() )
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
                $formField = \App\Models\FormField::find( $id );
                $return[]  = $formField->delete();
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
            $formField = \App\Models\FormField::find( $ids );

            if ( $formField->delete() )
                return Response()->json( [
                    'code' => 'success',
                ] );
            else
                return Response()->json( [
                    'code' => 'error',
                ] );
        }
    }

    public function getList( $id )
    {
        $this->permission();

        $formsField = \App\Models\FormField::find( $id );
        $forms      = \App\Models\Form::wherePlugin( $formsField->plugin )->get();
        $plugin     = ucfirst( $formsField->plugin );

        \Plugins::register( $plugin, '\\App\\Plugins\\' . $plugin . '\\' . $plugin );

        $dataSourceView = \Plugins::attribute( $plugin, 'dataSourceView' );
        $dataSource     = \Plugins::attribute( $plugin, 'dataSource' );

        if ( $dataSourceView ) {
            return \Plugins::method( $plugin, $dataSource );
        } elseif ( $dataSource === false ) {
            return View( 'Error.Message' )->with( [
                'code'    => 204,
                'message' => '插件不需要数据回显数据!'
            ] );
        } else {
            \Plugins::register( 'PrettyJSON', '\App\Plugins\PrettyJSON\PrettyJSON' );

            return View( 'Backend.Form.List' )->with( [
                'forms' => $forms
            ] );
        }
    }
}
