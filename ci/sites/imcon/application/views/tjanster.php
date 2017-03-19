<?php 
    global $globbie;
    $globbie = $getBubbles;

    function imgs($num) {
        global $globbie;
        $icon = ($num == 0 ? 'installation' : ($num == 1 ? 'droplet' : ($num == 2 ? 'security' : '')));
        $sum = $num;

        if($globbie[$num]['filename'] != '') {
             echo '<div class="image">'; 
             echo '<div style="background-image: url('. '/assets/images/'. $globbie[$sum]['filename'] . '.' . $globbie[$sum]['extension'] .');"></div>';
             echo '</div>';
        } else {
             echo '<div class="icon"><i class="icon-' . $icon . '"></i></div>';
        }
    }
?>

<div class="row">
    <div class="mobile-12 columns">
        <h1>Tjänster</h1>
    </div>
    <div class="mobile-12 columns">
        <h2><?= $text['title']; ?></h2>
    </div>
</div>

<div class="row">
    <div class="mobile-12 tablet-4 columns">
        <?php imgs(0); ?>
        <div class="bubble">
            <h4><?= $text['bubble1']; ?></h4>
        </div>
    </div>
    <div class="mobile-12 tablet-4 columns">
        <?php imgs(1); ?>
        <div class="bubble">
            <h4><?= $text['bubble2']; ?></h4>
        </div>
    </div>
    <div class="mobile-12 tablet-4 columns">
        <?php imgs(2); ?>
        <div class="bubble">
            <h4><?= $text['bubble3']; ?></h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="mobile-12 columns">
        <hr />
        <h2><?= $text['title2']; ?></h2>
    </div>
    <div class="mobile-12 columns">
        <ul class="list">
            <?php
                $xplode = explode(",", $text['tags']);
                foreach($xplode as $tags)
                {
                    echo '<li>' . $tags . '</li>';
                }
            ?>
        </ul>
    </div>
    <div class="silo mobile-12 columns"><?= nl2br($text['silo']); ?></div>
</div>