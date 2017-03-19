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
</div>

<form method="post" action="/admin/editServices">
    <div class="row">
        <div class="mobile-12 columns">
            <?php
                if(isset($_GET['success'])) {
                    if($_GET['success'] == 'img') {
                        echo '<div class="success">Bilden har sparats!</div>';
                    } else {
                        echo '<div class="success">Sparat!</div>';
                    }
                } else if(isset($_GET['error'])) {
                    echo '<div class="error">Ett fel uppstod. Försök igen.</div>';
                }
            ?>
            <input type="text" name="title" class="titleServices" value="<?= $text['title']; ?>">
        </div>
    </div>
    
    <div class="row">
        <div class="mobile-12 tablet-4 columns">
            <?php imgs(0); ?>
            <a class="image-button" href="?edit=1">Redigera bild</a>
            <div class="bubble">
                <textarea name="bubble1"><?= $text['bubble1']; ?></textarea>
            </div>
        </div>
        <div class="mobile-12 tablet-4 columns">
            <?php imgs(1); ?>
            <a class="image-button" href="?edit=2">Redigera bild</a>
            <div class="bubble">
                <textarea name="bubble2"><?= $text['bubble2']; ?></textarea>
            </div>
        </div>
        <div class="mobile-12 tablet-4 columns">
            <?php imgs(2); ?>
            <a class="image-button" href="?edit=3">Redigera bild</a>
            <div class="bubble">
                <textarea name="bubble3"><?= $text['bubble3']; ?></textarea>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="mobile-12 columns">
            <hr />
            <input type="text" name="title2"  class="titleServices" value="<?= $text['title2']; ?>">
        </div>
        <div class="mobile-12 columns">
            <input type="text" name="tags" value="<?= $text['tags']; ?>">
        </div>
        <div class="mobile-12 columns">
            <textarea name="silo"><?= $text['silo']; ?></textarea>
        </div>
        <div class="mobile-12 columns">
            <input type="submit" value="Spara">
        </div>
    </div>
</form>

<script>
    // Get URL parameter values
    $.extend({
        getUrlVars: function(){
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        },
        getUrlVar: function(name){
            return $.getUrlVars()[name];
        }
    });
    
    if($.getUrlVar('edit')) {
        urlParam = '/editServicesImage?edit=' + $.getUrlVar('edit');
        $(function(e) {
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                data: formData,
                url: urlParam,
                success: function(data) {
                    $('.overlay').show();
                    $('#main').append(data);
                }
            });
        });
    }
</script>