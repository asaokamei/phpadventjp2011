<?php
require_once './localStorage.php';

$data = array( 'test'=>'test', 'more'=>'alert("HI/hi");' );
$js   = localStorage::saveStorage( $data, 'testID' );
$js2  = localStorage::saveStorage( 'just value', 'valID' );

?>
<!DOCTYPE html>  
<html lang="ja">
    <head>
        <meta charset="utf-8" />
        <title>test localStorage</title>
    </head>
    <body>
        <h1>test localStorage</h1>
        <p>PHP code is:</p>
        <pre>
            require_once './localStorage.php';
            $data = array( 'test'=>'test', 'more'=>'alert("HI/hi");' );
            $js   = localStorage::saveStorage( $data, 'testID' );
            $js2  = localStorage::saveStorage( 'just value', 'valID' );
        </pre>
        <p>setting following javaScript:</p>
        <pre><?php echo htmlspecialchars( $js, ENT_QUOTES ); ?></pre>
        <?php echo $js;?>
        <p>setting following javaScript:</p>
        <pre><?php echo htmlspecialchars( $js2, ENT_QUOTES ); ?></pre>
        <?php echo $js2;?>
        <p>data is now saved to localStorage.</p>
        <p>click <a href="test2.php">next page</a> to show an empty page.</p>
    </body>
</html>
