#php 7.x
<?php
$crypto = 5;
function body(){
    global $crypto;
    echo $crypto = 4;
}
body();
?>