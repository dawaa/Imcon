<div class="popup edit-colleague-box">
    <h3>Redigera kollega</h3>
    <form action="/editColleague/edit" method="post" enctype="multipart/form-data">
        <input type="text" name="firstname" value="<?= $id['firstname']; ?>" placeholder="Namn" title="Namn" />
        <input type="text" name="lastname" value="<?= $id['lastname']; ?>" placeholder="Efternamn" title="Efternamn" />
        <input type="text" name="role" value="<?= $id['role']; ?>" placeholder="Roll" title="Roll" />
        <input type="hidden" name="id" value="<?= $id['id']; ?>">
        <input type="file" name="file_upload" title="Foto">
        <input type="submit" name="submit" value="Spara">
    </form>
</div>