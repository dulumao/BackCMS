<?php
namespace App\Plugins\Template;

class Template
{

    public function run()
    {
        return $this;
    }

    public function getCompile( $content )
    {
        $templateMatchers = [ ];

        do {
            preg_match( '/\{template\s+(.+)\}/', $content, $templateMatchers );

            if ( count( $templateMatchers ) >= 2 ) {
                try {
                    $template = \App\Models\Template::whereName( $templateMatchers[ 1 ] )->firstOrfail();
                    $content  = str_replace( $templateMatchers[ 0 ], $template->code, $content );
                    compileBlade( $content, null, 0 );
                } catch ( \Illuminate\Database\Eloquent\ModelNotFoundException $e ) {
                    break;
                }
            }
        } while ( count( $templateMatchers ) >= 2 );

        return $content;
    }

}