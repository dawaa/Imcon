<?php
    global $bgSetting;
    $bgSetting = $info;
    
    function bgSetting($bg) {
        global $bgSetting;
        $bg = $bg - 1;
        $align = $bgSetting[$bg]['align'];
        $shadow = $bgSetting[$bg]['shadow'];
        $title = $bgSetting[$bg]['title'];
        $text = $bgSetting[$bg]['bgtext'];
        $buttonLink = $bgSetting[$bg]['buttonlink'];
        $buttonText = $bgSetting[$bg]['buttontext'];
        
        if($shadow == '1') {      
            if($align == 'center') {
                echo '<div class="content shadow center">';
            } else {
                echo '<div class="shadow ' . $align . '"></div>';
                echo '<div class="content ' . $align . '">';
            }
        } else {
            echo '<div class="content ' . $align . '">';
        }
        echo('
                <div>
                    <h2>' . $title . '</h2>
                    <div class="text">' . $text . '</div>
                    <a href="' . $buttonLink . '" class="button">' . $buttonText . '</a>
                </div>
            </div>
        ');
    }
?>

<div class="bg">
    <ul>
        <li class="bg-1"><?php bgSetting(1); ?></li>
        <li class="bg-2"><?php bgSetting(2); ?></li>
        <li class="bg-3"><?php bgSetting(3); ?></li>
    </ul>
</div>