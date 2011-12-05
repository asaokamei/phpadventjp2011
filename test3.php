<?php
require_once './localStorage.php';

$js   = localStorage::loadStorage( 'testID' );
$js2  = localStorage::loadStorage( 'valID' );


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
        <p>this page has blank form.</p>
        <form action="test4.php" method="post">
            <p>PHP code is:</p>
            <pre>
                require_once './localStorage.php';
                $js   = localStorage::loadStorage( 'testID' );
                $js2  = localStorage::loadStorage( 'valID' );
            </pre>
            <p>setting following javascript in this form.</p>
            <pre><?php echo htmlspecialchars( $js, ENT_QUOTES ); ?></pre>
            <?php echo $js; ?>
            <pre><?php echo htmlspecialchars( $js2, ENT_QUOTES ); ?></pre>
            <?php echo $js2; ?>
            <p>submitting this form sends localStorage data to PHP.</p>
            <input type="submit" value="submit" />
        </form>
    </body>
</html>