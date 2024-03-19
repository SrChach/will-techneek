<?php
function pre($pre){
    $pre=json_encode($pre, JSON_UNESCAPED_UNICODE);
    $pre=json_decode($pre, true);
    echo "<pre>";
        print_r($pre);
    echo "</pre>";
}
?>