<div class="row">
    <div class="mobile-12 columns">
        <h1>Om oss</h1>
        <h2><?= $aboutText['title']; ?></h2>
        <?= nl2br($aboutText['description']); ?>
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
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>