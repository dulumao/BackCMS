<?php
namespace App\Plugins\PrettyJSON;

class PrettyJSON
{
    private $data = [ ];

    public function run( $json )
    {
        $this->data = json_decode( $json, true, 1024 );

        if ( is_array( $this->data ) ) {
            return static::printHtml( $this->data );
        } else {
            return static::renderSimpleValue( $this->data );
        }
    }

    private static function printHtml( $data)
    {
        if ( is_null( $data ) ) {
            return static::renderSimpleValue( $data );
        }

        $html    = null;
        $isAssoc = static::isAssoc( $data );
        $keyHtml = null;

        $count     = count( $data );
        $iteration = 0;

        foreach ( $data as $key => $value ) {
            $isComma = $iteration++ < $count - 1;

            if ( is_array( $value ) ) {
                $html .= static::printHtml( $value, $isAssoc ? $key : null, $isComma );
            } else {
                $html .= '<div style="display: inline-block;padding: 0 30px 0 0;">';

                if ( $isAssoc ) {
                    $html .= '<span style="color: #404040;">' . $key . '</span>';
                    $html .= '<span style="color:#A1A1A1;">&nbsp;:&nbsp;</span>';
                }

                $html .= static::renderSimpleValue( $value );

                $html .= '</div>';
            }
        }


        return $html;
    }

    private static function renderSimpleValue( $value )
    {
        $type   = gettype( $value );
        $return = null;

        switch ( $type ) {
            case 'string':
                $return = '<span style="color: #45A139;">' . $value . '</span>';
                break;
            case 'number':
            case 'integer':
            case 'double':
                $return = '<span style="color: #FF6F6F">' . $value . '</span>';
                break;
            case 'boolean':
                $str    = [ true => 'true', false => 'false' ];
                $return = '<span style="color: #FFA32D;">' . $str[ $value ] . '</span>';
                break;
            default:
                $return = '<span>' . $value . ' (' . $type . ')</span>';
                break;
        }

        return $return;
    }

    private static function isAssoc( $arr )
    {
        return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
    }

}