<div class="row">
    <div class="mobile-12 columns">
		<h1>Guider</h1>
    </div>
</div>
<div class="row">
    <div class="mobile-12 columns">
        <a href="?add=guide" class="add-guide">Ladda upp guide</a>
        <?php
            if(isset($_GET['success'])) {
                if($_GET['success'] == 'deleted') {
                    echo '<div class="success">Guiden har tagits bort!</div>';
                } else {
                    echo '<div class="success">Guiden har laddats upp!</div>';
                }
            } else if(isset($_GET['error'])) {
                echo '<div class="error">Ett fel uppstod. Försök igen.</div>';
            }
        ?>
    </div>
    
    <?php foreach($getProduct as $geteat): ?>
        <div id="product-<?= $geteat['productID']; ?>" class="product mobile-12 columns">
            <div>
                <div class="img" style="background-image: url(/assets/images/products/<?= $geteat['articleImage']; ?>.<?= $geteat['articleExtension']; ?>);"></div>
                <div class="info">
                    <div class="name"><?= $geteat['articleName']; ?></div>
                    <ul class="guides">
                        <?php
                            foreach($getGuide as $guide) {
                                if($guide['productID'] == $geteat['productID']) {
                                    echo ('
                                        <li>
                                            <a href="/assets/guides/' . $guide['fileGuide'] . '" target="_blank">' . $guide['title'] . '</a>
                                            <a href="/admin/deleteGuide/' . $guide['id'] . '" class="remove"><i class="icon-cancel"></i></a>
                                        </li>
                                    ');
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
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
    
    var urlParam;
    if($.getUrlVar('add')) {
        urlParam = '/addGuide?add=' + $.getUrlVar('add');
        
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