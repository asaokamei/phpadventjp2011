<?php


class localStorage
{
    const ENCODE_NONE         = 'none'; 
    const ENCODE_JSON         = 'json';
    public static $save_id    = 'saveID_';  // 
    public static $encode_id  = '_EncType_'; 
    // +--------------------------------------------------------------- +
    static function saveId( $save_id=NULL ) {
        if( $save_id !== NULL ) {
            self::$save_id = $save_id; 
        }
        return self::$save_id;
    }
    // +--------------------------------------------------------------- +
    static function saveStorage( $data, $save_id=NULL )
    {
        $save_id = self::$save_id . $save_id; 
        $val   = self::encodeData( $data, self::ENCODE_JSON );
        $js    = "
        <script>
          localStorage.setItem( 
          '{$save_id}', '{$val}' );
        </script>";
        return $js;
    }
    // +--------------------------------------------------------------- +
    static function loadStorage( $save_id=NULL )
    {
        $save_id = self::$save_id . $save_id; 
        $enc_id= self::$encode_id;
        $encode= self::ENCODE_JSON;
        $js    = 
        "
        <input type=\"hidden\" name=\"{$save_id}\" id=\"{$save_id}\">
        <input type=\"hidden\" name=\"{$save_id}{$enc_id}\" value=\"{$encode}\">
        <script>
          document.getElementById( '{$save_id}' ).value = 
            localStorage.getItem( '{$save_id}' );
        </script>
        ";
        return $js;
    }
    // +--------------------------------------------------------------- +
    static function loadPost( $save_id=NULL, $encode=NULL )
    {
        $save_id = self::$save_id . $save_id; 
        if( !$encode && isset( $_POST[ $save_id . self::$encode_id ] ) ) {
            $encode = $_POST[ $save_id . self::$encode_id ];
        }

        $data = array();
        if( isset( $_POST[ $save_id ] ) ) {
            $data = self::decodeData( $_POST[ $save_id ], $encode );
        }
        return $data;
    }
    // +--------------------------------------------------------------- +
    static function encodeData( $data, $encode=NULL )
    {
        // encoding $data; $data can be an array
        // returns a seriarized string data.
        switch( $encode )
        {
            case self::ENCODE_JSON:
                $en_data = json_encode( $data );
                break;
            case self::ENCODE_NONE:
            default:
                $se_data = serialize( $data );
                $en_data = $se_data;
                break;
        }
        return $en_data;
    }
    // +--------------------------------------------------------------- +
    static function decodeData( $data, $encode=NULL )
    {
        switch( $encode )
        {
            case self::ENCODE_JSON:
                $un_data = json_decode( stripslashes( $data ) );
                break;
            case self::ENCODE_NONE:
            default:
                $de_data = $data;
                $un_data = unserialize( $de_data );
                break;
        }
        return $un_data;
    }
    // +--------------------------------------------------------------- +
}

