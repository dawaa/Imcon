<a href="?addnew=category"><i class="icon-plus">s</i>Lägg till ny kategori</a>
<?php
if(!empty($_GET['addnew']))
		{
			echo '<form method="post" action="/admin/addCategory/">';
			echo '<div class="subcat"><input type="text" name="category" placeholder="name category"></div>';
			echo '</form>';
		}

?>
<br />
<br />
<?php
foreach($getCategories as $getCat)
{
	echo $getCat['articleGroup'] . ' <a href="/admin/categories?addto=' . $getCat['id'] . '">+</a>' . '<br />';
	if(!empty($_GET['addto']))
	{
		if($_GET['addto'] == $getCat['id'])
		{
			echo '<form method="post" action="/admin/addSubCategory/' . $_GET['addto'] . '">';
			echo '<div class="subcat"><input type="text" name="subcategory" placeholder="name subcategory"></div>';
			echo '</form>';
		}
	}
	foreach($getsubCategories as $subCats)
	{
		if($subCats['id'] == $getCat['id'])
		{
			echo '<div class="subcat">' . $subCats['articleGroup'] . ' <a href="/admin/removeSubCat/' . $subCats['unique_id'] . '">[x]</a></div>';
		}
	}
}
?>