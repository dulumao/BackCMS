<?php
namespace App\Plugins\Localization;

use Illuminate\Http\Request;

class Localization
{
    public function run()
    {
        $type = Request()->segment( 4 );

        switch ( $type ) {
            case 'zh-cn':
                return $this->setLocalization( 'zh-cn' );
            case 'zh-tw':
                return $this->setLocalization( 'zh-tw' );
            case 'en':
                return $this->setLocalization( 'en' );
        }

        abort( 404 );
    }

    protected function setLocalization( $language )
    {
        app()->setLocale( $language );
        Cookie()->queue( Cookie()->forever( 'language', $language ) );

        return Redirect()->back();
    }
}