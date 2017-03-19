<?php
    
    //preprint($measurement);
    foreach($measurement as $measure) {
        if($measure['measure'] == $_GET['measure']) {
            echo $measure['articleNumber'];
        }
    }
    
?>