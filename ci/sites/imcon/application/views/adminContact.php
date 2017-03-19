<div class="row">
    <div class="contact-info mobile-12 columns">
		<h1>Kontakta oss</h1>
        <?php
            if(isset($_GET['success'])) {
                echo '<div class="success">Sparat!</div>';
            }
        ?>
		<form method="post" action="/admin/editContact/">
            <div class="address">
                <label>Adress</label>
                <input type="text" name="address" value="<?= $info['Address']; ?>">
            </div>
            <div class="zip">
                <label>Postnr/Ort</label>
                <input type="text" name="zipcode" value="<?= $info['ZipCode']; ?>">
            </div>
            <div class="phone">
                <label>Telefon</label>
                <input type="text" name="telephone" value="<?= $info['Telephone']; ?>">
            </div>
            <div class="email">
                <label>Email</label>
                <input type="text" name="email" value="<?= $info['Email']; ?>">
            </div>
            <div class="fax">
                <label>Fax</label>
                <input type="text" name="fax" value="<?= $info['Fax']; ?>" placeholder="Fax">
            </div>
            <input type="submit" value="Spara">
		</form>
	</div>
</div>