<?php
    $img = $_GET['edit'];
?>

<div class="popup edit-slideshow-box">
    <h3>Redigera bild <?= $img; ?></h3>
    <form method="post" action="/admin/editServicesImgs?edit=<?= $img; ?>" enctype="multipart/form-data">
        <input type="file" name="file_upload" title="Bild">
        <input type="submit" value="Spara">
    </form>
</div>