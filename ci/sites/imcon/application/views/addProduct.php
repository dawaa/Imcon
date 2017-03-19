<?
	$get = $this->db->query("SELECT * FROM Categories")->result_array();
	$getSub = $this->db->query("SELECT * FROM subCategories")->result_array();
?>
<div class="popup add-product-box">
    <h3>Lägg till produkt</h3>
	<form action="/admin/productAdded/" method="post" enctype="multipart/form-data">
		<input type="text" name="aName" placeholder="Namn" title="Namn" required>
		<select name="aGroup" title="Kategori" class="aGroup">
			<?php
				foreach($get as $option)
				{
					echo '<option value="'.$option['articleGroup'].'">' . $option['articleGroup'] . '</option>';
					foreach($getSub as $subs)
					{
						if($subs['id'] == $option['id'])
						{
							echo '<option value="'.$option['articleGroup'].'-'.$subs['unique_id'].'">- ' . $subs['articleGroup'] . '</option>';
						}
					}
				}
			?>
		</select>
        <input type="text" name="measurement" value="" placeholder="Egenskaper" title="Egenskaper (separera med komma (,)">
		<input type="text" name="aNumber" placeholder="Artikelnummer" title="Artikelnummer (separera med komma (,)" required>
		<textarea name="aDescription" placeholder="Beskrivning" title="Beskrivning"></textarea>
		<input type='file' name="file_upload" required>
		<input type="submit" value="Lägg till produkt">
	</form>
</div>

<script>
    $('select').selectBox({
        mobile: true,
        menuTransition: 'default',
        hideOnWindowScroll: false
    });
</script>