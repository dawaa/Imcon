<div class="row">
    <div class="mobile-12 columns">
        <h1>Om oss</h1>
        <?php
            if(isset($_GET['success'])) {
                if($_GET['success'] == 'added') {
                    echo '<div class="success">Kollega har lagts till!</div>';
                } else if($_GET['success'] == 'edited') {
                    echo '<div class="success">Kollega har uppdaterats!</div>';
                } else if($_GET['success'] == 'deleted') {
                    echo '<div class="success">Kollega har tagits bort!</div>';
                } else {
                    echo '<div class="success">Sparat!</div>';
                }
            } else if(isset($_GET['error'])) {
                echo '<div class="error">Ett fel uppstod. Försök igen.</div>';
            }
        ?>
        <form method="post" action="/admin/editAbout">
            <input type="text" name="aboutTitle" value="<?= $aboutText['title']; ?>" class="titleAbout">
            <textarea name="aboutText" cols="25" rows="10"><?= $aboutText['description']; ?></textarea>
            <input type="submit" value="Spara">
		</form>
    </div>
</div>
<div class="row">
    <div class="colleague-list">
        <div class="mobile-12 columns">
            <hr />
            <h2>Kollegor</h2>
        </div>
        <?php foreach($get as $colleagues): ?>
            <div class="mobile-12 tablet-4 desktop-3 columns">
                <div class="colleague">
                    <div>
                        <?php $pathh = '/assets/images/colleagues/' . $colleagues['filename'] . '.' . $colleagues['extension']; ?>
                        <?php $photoExists = ($colleagues['filename'] == '' ? '' : ' style="background-image: url(' . $pathh . ');"'); ?>
                        <div class="photo" <?= $photoExists; ?>></div>
                        <div class="name"><?= $colleagues['firstname'] . ' ' . $colleagues['lastname']; ?></div>
                        <div class="role"><?= $colleagues['role']; ?></div>
                        <a href="?editColleague=<?= $colleagues['id']; ?>" class="edit" title="Redigera"><i class="icon-edit"></i></a>
                        <a href="/admin/removeColleague/<?= $colleagues['id']; ?>" class="remove" title="Ta bort"><i class="icon-delete"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="mobile-12 tablet-4 desktop-3 columns">
            <a href="?add=colleague" class="add-colleague">
                <div>
                    <div class="photo"></div>
                    <span>Lägg till kollega</span>
                </div>
            </a>
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
    
    var urlParam;
    if($.getUrlVar('editColleague')) {
        urlParam = '/editColleague?editColleague=' + $.getUrlVar('editColleague');
    } else if($.getUrlVar('add') == 'colleague') {
        urlParam = '/addColleague?add=colleague';
    }
    if($.getUrlVar('editColleague') || $.getUrlVar('add') == 'colleague') {
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