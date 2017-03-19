<div class="popup add-colleague-box">
    <h3>Lägg till kollega</h3>
	<form action="/admin/addColleague" method="post" enctype="multipart/form-data">
        <input type="text" name="firstname" placeholder="Namn" required>
        <input type="text" name="lastname" placeholder="Efternamn" required>
        <input type="text" name="role" placeholder="Roll" required>
        <input type="file" name="file_upload">
        <input type="submit" value="Lägg till">
    </form>
</div>