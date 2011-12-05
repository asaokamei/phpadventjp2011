<?php
require_once './localStorage.php';

$data = localStorage::loadPost( 'testID' );
$val  = localStorage::loadPost( 'valID' );

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>  
<html lang="ja">
    <head>
        <meta charset="utf-8" />
        <title>test localStorage</title>
    </head>
    <body>
        <h1>test localStorage</h1>
        <p>got localStorage data as:</p>
        <pre><?php var_dump( $data ); ?></pre>
        <pre><?php var_dump( $val ); ?></pre>
        <p>PHP code looks like:</p>
        <pre>
            require_once './localStorage.php';
            $data = localStorage::loadPost( 'testID' );
            $val  = localStorage::loadPost( 'valID' );
        </pre>
        <p>just for note, $_POST looks like:</p>
        <pre><?php var_dump( $_POST ); ?></pre>
    </body>
</html>