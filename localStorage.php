<?php


class localStorage
{
    const ENCODE_NONE         = 'none'; 
    const ENCODE_BASE64       = 'base64'; 
    const ENCODE_CRYPT        = 'crypt';
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
            case self::ENCODE_BASE64:
                $se_data = serialize( $data );
                $en_data = base64_encode( $se_data );
                break;
            case self::ENCODE_CRYPT:
                if( !function_exists( 'mcrypt_encrypt' ) ) {
                    throw new Exception( 'mcrypt not installed @' . __CLASS__ , 9999 );
                }
                // from: http://jp.php.net/manual/ja/function.mcrypt-encrypt.php
                $se_data = serialize( $data );
                $en_data = 
                    trim( base64_encode( mcrypt_encrypt( 
                        MCRYPT_RIJNDAEL_256, 
                        self::$crypt_pswd, 
                        $se_data, 
                        MCRYPT_MODE_ECB, 
                        mcrypt_create_iv( 
                            mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB ), 
                            MCRYPT_RAND
                        )
                    ) ) ); 
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
            case self::ENCODE_BASE64:
                $de_data = base64_decode( $data );
                $un_data = unserialize( $de_data );
                break;
            case self::ENCODE_CRYPT:
                if( !function_exists( 'mcrypt_decrypt' ) ) {
                    throw new Exception( 'mcrypt not installed @' . __CLASS__ , 9999 );
                }
                // from: http://jp.php.net/manual/ja/function.mcrypt-encrypt.php
                $de_data = 
                    trim( mcrypt_decrypt(
                        MCRYPT_RIJNDAEL_256, 
                        self::$crypt_pswd, 
                        base64_decode( $data ), 
                        MCRYPT_MODE_ECB, 
                        mcrypt_create_iv(
                            mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB ), 
                            MCRYPT_RAND
                        )
                    ) ); 
                $un_data = unserialize( $de_data );
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



?>
