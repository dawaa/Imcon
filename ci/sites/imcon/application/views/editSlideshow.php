<?php
    $id = $_GET['editSlideshow'] - 1;
    $radio = array('left', 'center', 'right');

    $title = $info[$id]['title'];
    $bgtext = $info[$id]['bgtext'];
    $buttonText = $info[$id]['buttontext'];
    $buttonLink = $info[$id]['buttonlink'];
    $align = $info[$id]['align'];
    $shadow = $info[$id]['shadow'];
?>

<div class="popup edit-slideshow-box">
    <h3>Redigera bild <?= $_GET['editSlideshow']; ?></h3>
    <form method="post" action="/admin/addBG" enctype="multipart/form-data">
        <input type="file" name="file_upload" title="Bakgrundsbild">
        <input type="text" name="bg" value="<?= $title; ?>" placeholder="Rubrik" title="Rubrik">
        <textarea name="bgtext" placeholder="Text" title="Text"><?= $bgtext; ?></textarea>
        <input type="text" name="buttontext" value="<?= $buttonText; ?>" placeholder="Knapptext" title="Knapptext">
        <input type="text" name="buttonlink" value="<?= $buttonLink; ?>" placeholder="Knapplänk" title="Knapplänk">
        <?php foreach($radio as $numb => $val): ?>
            <?php $check = ($val == $align ? ' checked' : ''); ?>
            <input type="radio" name="align" id="align-<?= $val; ?>" value="<?= $val; ?>" <?= $check; ?>>
            <label for="align-<?= $val; ?>" class="radio" title="Textplacering"></label>
        <?php endforeach; ?>
        <input type="checkbox" value="1" name="shadow" <?php echo ($shadow != '1' ? '' : 'checked' ); ?> id="shadow">
        <label for="shadow" class="checkbox" title="Skugga över bakgrunden för att förtydliga texten">Skugga</label>
        <input type="hidden" name="bgname" value="bg_<?= $_GET['editSlideshow']; ?>">
        <input type="submit" value="Spara">
    </form>
</div>