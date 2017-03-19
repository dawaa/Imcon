<?php echo '<pre>'; 
//print_r($getCategory);
echo '</pre>';
 ?>

 <?php
 foreach($listCategories as $categories)
 {
 	echo '<a href="/hem/category/' . $categories['id'] . '">' . $categories['articleGroup'] . '</a><br />';
 	if($categories['id'] == $category_id)
 	{
 		 foreach($getsubCategory as $sub)
		 {
		 	echo $sub['articleGroup'] . '<br />';
		 }
 	}


 }



 ?>