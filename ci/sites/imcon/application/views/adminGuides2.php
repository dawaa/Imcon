<div class="row">
    <div class="mobile-12 columns">
		<h1>Guider</h1>
    </div>
</div>
<div class="row">
    <div class="mobile-12 columns">
        <a href="?add=guide" class="add-guide">Ladda upp guide</a>
    </div>
    <?php echo '<pre>' . var_dump($testingQ) . '</pre>'; ?>
    <?php foreach($testingQ as $geteat): ?>
    <?php 
        foreach($getProducts as $get)
        {
            if($get['articleNumber'] == $geteat['articleNumber'])
            {
                echo $geteat['title'];
            }
        }
    ?>
   
        <!-- <div id="product-<?= $geteat['id']; ?>" class="product mobile-12 columns">
            <div>
                <div class="img" style="background-image: url(/assets/images/products/<?= $geteat['articleImage']; ?>.<?= $geteat['articleExtension']; ?>);"></div>
                <div class="info">
                    <div class="name"><?= $geteat['articleName']; ?></div>
                    <ul class="guides">
                        <li>
                            <a href="/assets/guides/<?= $geteat['fileGuide']; ?>"><?= $geteat['title']; ?></a>
                            <a href="/admin/deleteGuide/" class="remove"><i class="icon-trash"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div> -->
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