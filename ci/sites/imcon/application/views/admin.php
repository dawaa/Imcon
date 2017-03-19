<div class="row">
    <div class="mobile-12 columns">
        <h1>Hem</h1>
        <?php
            if(isset($_GET['success'])) {
                echo '<div class="success">Sparat!</div>';
            } else if(isset($_GET['error'])) {
                echo '<div class="error">Ett fel uppstod. Försök igen.</div>';
            }
        ?>
    </div>
</div>
<div class="row">
	<div class="bg-items">
	    <div class="mobile-12 tablet-4 columns">
	    	<div class="bg-item">
	    		<h3>Bild 1</h3>
		    	<?php $radio = array('left', 'center', 'right'); ?>
	    		<div class="img" style="background-image: url(/assets/images/bg_1.<?= $info[0]['extension']; ?>);">
                    <?php if($info[0]['shadow'] == '1') { echo '<div class="shadow ' . $info[0]['align'] . '"></div>'; } ?>
                    <div class="align-preview <?= $info[0]['align']; ?>"><i class="icon-align-<?= $info[0]['align']; ?>"></i></div>
                </div>
		    	<a href="?editSlideshow=1" class="edit">Redigera innehåll</a>
	    	</div>
	    </div>
		<div class="mobile-12 tablet-4 columns">
	    	<div class="bg-item">
	    		<h3>Bild 2</h3>
	    		<div class="img" style="background-image: url(/assets/images/bg_2.<?= $info[1]['extension']; ?>);">
                    <?php if($info[1]['shadow'] == '1') { echo '<div class="shadow ' . $info[1]['align'] . '"></div>'; } ?>
                    <div class="align-preview <?= $info[1]['align']; ?>"><i class="icon-align-<?= $info[1]['align']; ?>"></i></div>
                </div>
		    	<a href="?editSlideshow=2" class="edit">Redigera innehåll</a>
	    	</div>
	    </div>
		<div class="mobile-12 tablet-4 columns">
	    	<div class="bg-item">
	    		<h3>Bild 3</h3>
	    		<div class="img" style="background-image: url(/assets/images/bg_3.<?= $info[2]['extension']; ?>);">
                    <?php if($info[2]['shadow'] == '1') { echo '<div class="shadow ' . $info[2]['align'] . '"></div>'; } ?>
                    <div class="align-preview <?= $info[2]['align']; ?>"><i class="icon-align-<?= $info[2]['align']; ?>"></i></div>
                </div>
		    	<a href="?editSlideshow=3" class="edit">Redigera innehåll</a>
	    	</div>
        </div>
    </div>
</div>

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
    
    if($.getUrlVar('editSlideshow')) {
        urlParam = '/editSlideshow?editSlideshow=' + $.getUrlVar('editSlideshow');
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