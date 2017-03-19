<div class="popup add-guide-box">
    <h3>Lägg till guide</h3>
	<form method="post" enctype="multipart/form-data" action="/admin/uploadGuide">
        <input type="text" name="guideTitle" placeholder="Beskrivning" title="Beskrivning" required>
        <input type="text" name="guideArticle" placeholder="Artikelnummer" title="Artikelnummer" required>
        <input type="file" name="file_upload" title="Fil för guide" required>
        <input type='submit' value="Ladda upp">
    </form>
</div>