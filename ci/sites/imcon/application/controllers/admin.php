<?php 
class Admin extends CI_Controller
{
	function index()
	{
		checkAdmin();
        $data['title'] = 'Hem (Admin Panel)' . ' &raquo; Imcon AB';
        $data['classes'] = 'home admin-home';
        $data['info'] = $this->db->query("SELECT * FROM backgrounds")->result_array();
		$this->template->set_layout('admin')->build('admin', $data);
	}

	function products()
	{
		checkAdmin();
        $data['title'] = 'Produkter (Admin Panel)' . ' &raquo; Imcon AB';
        $data['classes'] = 'products admin-products';
        $data['getCategories'] = $this->db->query("SELECT * FROM Categories")->result_array();
        if(isset($_GET['cat']))
        {
        	$data['getsubCategory'] = $this->db->query("SELECT subCategories.articleGroup, subCategories.unique_id FROM subCategories INNER JOIN Categories ON Categories.id = subCategories.id WHERE subCategories.id = '" . $_GET['cat'] . "'")->result_array();
        }
		$this->template->set_layout('admin')->build('adminProducts', $data);
	}

	function removeProduct()
	{
		checkAdmin();
        $id = $_GET['id'];
        $remove = $this->db->query("SELECT * FROM Products WHERE productID = '" . $id . "'")->row_array();
        $original = 'assets/images/products/' . $remove['articleImage'] . '.' . $remove['articleExtension'];
        unlink($original);
		$this->db->query("DELETE FROM Products WHERE productID='$id'");
		$this->db->query("DELETE FROM measurement WHERE productID='$id'");
		redirect('/admin/produkter?success=deleted');
	}


	function updateEdit()
	{
		checkAdmin();
		$id = $_POST['id'];
		$getCates = $this->db->query("SELECT Products.articleSub, Categories.id FROM Products INNER JOIN Categories ON Categories.articleGroup = Products.articleGroup WHERE Products.productID = '" . $id . "'")->row_array();
		$name = $_POST['articleName'];
		$number = explode(',', preg_replace("/\s*,\s*/", ",", $_POST['articleNumber']));
		$measure = explode(',', preg_replace("/\s*,\s*/", ",", $_POST['measurement']));
		$group = explode('-', $_POST['articleGroup']);
		$desc = $_POST['articleDescription'];
		$subcatDB = $group[1];
		$categoryDB = $group[0];
		$combined = array_combine($measure, $number);

		if($_FILES['file_upload']['name'] != '') {
			$getImage = $this->db->query("SELECT * FROM Products WHERE productID = '" . $id . "'")->row_array();
			$path = 'assets/images/products/' . $getImage['articleImage'] . '.' . $getImage['articleExtension'];
			$getName = pathinfo($_FILES['file_upload']['name']);
			$getit = $getName['filename'];
			$getext = $getName['extension'];
			$masterName = uniqid(rand(), true) . '.' . $getext;
			$updMaster = pathinfo($masterName);
			$updateMasterName = $updMaster['filename'];
			$updateMasterExt = $updMaster['extension'];

			//REMOVES ALREADY EXISTING FILE
			if(file_exists($path)) {
				unlink($path);
			}

			if(isset($_FILES)) {
				if($_FILES['file_upload']['error'] > 0) {
                    redirect('/admin/produkter?error');
		    	}

		    	$exte = array('jpg', 'png', 'jpeg', 'PNG', 'JPG', 'JPEG');
		    	if(!in_array($getName['extension'], $exte)) {
                    redirect('/admin/produkter?error');
		    	}

				if($_FILES['file_upload']['size'] > 500000000) {
                    redirect('/admin/produkter?error');
				}

				if(file_exists('assets/images/products/' . $_FILES['file_upload']['name'])) {
                    redirect('/admin/produkter?error');
				} 

				if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'assets/images/products/' . $masterName)) {
                    redirect('/admin/produkter?error');
				} 	
				
			}

			foreach($combined as $k => $n) {
				$this->db->query("UPDATE measurement SET measure = '".$k."', articleNumber = '".$n."' WHERE productID = '".$id."'");
			}
			$this->db->query("UPDATE Products SET articleName = '" . $name . "', articleGroup = '" . $categoryDB . "', articleSub = '" . $subcatDB . "', articleDescription = '" . $desc . "', articleImage = '" . $updateMasterName . "', articleExtension = '" . $updateMasterExt . "' WHERE '" . $id . "' = productID");
		} else {

			//DELETES ALL THE DATA FROM DB
			$this->db->query("DELETE FROM measurement WHERE productID = '".$id."'");

			$table = array();
			$i = 0;
			$i2 = 0;
            foreach($combined as $k => $n) {
                $table[$i]['measure'] = $measure[$i2];
                $table[$i]['articleNumber'] = $number[$i2];
                $i++;
                $i2++;
            }

            foreach($table as $t) {
                $this->db->query("INSERT INTO measurement (productID, measure, articleNumber) VALUES ('$id', '$t[measure]', '$t[articleNumber]')");
            }


            $this->db->query("
                UPDATE Products
                SET articleName = '" . $name . "', articleGroup = '" . $categoryDB . "', articleSub = '" . $subcatDB . "', articleDescription = '" . $desc . "'
                WHERE '" . $id . "' = productID
            ");
		}

		if($getCates['articleSub'] == '') {
			redirect('/admin/produkter?cat=' . $getCates['id'] . '&success=edited');
		} else {
			redirect('/admin/produkter?cat=' . $getCates['id'] . '&sub=' . $getCates['articleSub'] . '&success=edited');
		}
		
		//SPAWN OF SATAN " "
	}

	function addProduct()
	{
		checkAdmin();
        $data['title'] = 'Lägg till produkt (Admin Panel)' . ' &raquo; Imcon AB';
        $data['classes'] = 'admin-add-product';
		$this->template->set_layout('admin')->build('addProduct', $data);
	}

	function productAdded()
	{
		checkAdmin();
		$name = $_POST['aName'];
		$number = explode(',', preg_replace("/\s*,\s*/", ",", $_POST['aNumber']));
		$group = explode('-', $_POST['aGroup']);
		$desc = $_POST['aDescription'];
		$img = $_FILES['file_upload']['name'];
		$getName = pathinfo($_FILES['file_upload']['name']);
		$getit = $getName['filename'];
		$getext = $getName['extension'];
		$categoryDB = $group[0];
		$subcatDB = $group[1];
		$rand = rand(0,9999999999);
		$masterName = uniqid(rand(), true) . '.' . $getext;
		$measure = explode(',', preg_replace("/\s*,\s*/", ",", $_POST['measurement']));
		$measures = array_combine($measure, $number);

		if(isset($_FILES)) {
			if($_FILES['file_upload']['error'] > 0) {
                redirect('/admin/produkter?error');
	    	}

	    	$exte = array('jpg', 'png', 'jpeg', 'PNG', 'JPG', 'JPEG', 'gif', 'GIF');
	    	if(!in_array($getName['extension'], $exte)) {
                redirect('/admin/produkter?error');
	    	}

			if($_FILES['file_upload']['size'] > 500000000) {
                redirect('/admin/produkter?error');
			}

			if(file_exists('assets/images/products/' . $_FILES['file_upload']['name'])) {
                redirect('/admin/produkter?error');
			} 

			if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'assets/images/products/' . $masterName)) {
                redirect('/admin/produkter?error');
			} 	
		}

		//get only filename without extension
		$getFilename = pathinfo('assets/images/products/' . $masterName);
		$FileName = $getFilename['filename'];

		//add product to DB
		$this->db->query("INSERT INTO Products (articleName, articleGroup, articleSub, articleDescription, articleImage, articleExtension)
							VALUES('$name', '$categoryDB', '$subcatDB', '$desc', '$FileName', '$getext')");

		//get product from DB and add measurements to DB
		$pID = $this->db->query("SELECT productID FROM Products WHERE articleImage = '" . $FileName . "'")->row_array();

		foreach($measures as $m => $n)
		{
			$this->db->query("INSERT INTO measurement (productID, measure, articleNumber) 
				VALUES ('$pID[productID]', '$m', '$n')");
		}

		redirect('/admin/produkter?success=added');
	}

	function services()
	{
		checkAdmin();
		$data['title'] = 'Tjänster (Admin Panel)' . ' &raquo; Imcon AB';
        $data['classes'] = 'services admin-services';
        $data['text'] = $this->db->query("SELECT * FROM Services WHERE id = '1'")->row_array();
        $data['getBubbles'] = $this->db->query("SELECT * FROM servicesImages")->result_array();
		$this->template->set_layout('admin')->build('adminServices', $data);
	}

	function guides()
	{
		checkAdmin();
		$data['title'] = 'Guider (Admin Panel)' . ' &raquo; Imcon AB';
        $data['classes'] = 'guides admin-guides';
        $data['getGuide'] = $this->db->query("SELECT * FROM Guides")->result_array();
        $data['getProduct'] = $this->db->query("
            SELECT Products.articleName, Products.productID, Products.articleImage, Products.articleExtension, Guides.title, Guides.productID
            FROM Products
            INNER JOIN Guides
            ON Products.productID = Guides.productID
            GROUP BY Guides.productID
        ")->result_array();
		$this->template->set_layout('admin')->build('adminGuides', $data);
	}

	function aboutUs()
	{
		checkAdmin();
		$data['title'] = 'Om oss (Admin Panel)' . ' &raquo; Imcon AB';
        $data['classes'] = 'about admin-about';
        $data['aboutText'] = $this->db->query("SELECT * FROM About")->row_array();
        $data['get'] = $this->db->query("SELECT * FROM colleagues")->result_array();
		$this->template->set_layout('admin')->build('adminAbout', $data);
	}

	function contactUs()
	{
		checkAdmin();
		$data['title'] = 'Kontakta oss (Admin Panel)' . ' &raquo; Imcon AB';
        $data['classes'] = 'contact admin-contact';
        $data['info'] = $this->db->query("SELECT * FROM ContactInfo")->row_array();
		$this->template->set_layout('admin')->build('adminContact', $data);
	}

	function editServices()
	{
		checkAdmin();
		$title = $_POST['title'];
		$title2 = $_POST['title2'];
		$bubble1 = $_POST['bubble1'];
		$bubble2 = $_POST['bubble2'];
		$bubble3 = $_POST['bubble3'];
		$tags = $_POST['tags'];
        $silo = $_POST['silo'];    
		$this->db->query("UPDATE Services SET title = '" . $title . "', title2 = '" . $title2 . "', bubble1 = '" . $bubble1 . "', bubble2 = '" . $bubble2 . "', bubble3 = '" . $bubble3 . "', tags = '" . $tags . "', silo = '" . $silo . "' WHERE id = '1'");
		redirect('/admin/services?success');
	}

	function editAbout()
	{
		checkAdmin();
		$sText = $_POST['aboutText'];
		$tText = $_POST['aboutTitle'];
		$this->db->query("UPDATE About SET description = '" . $sText . "', title = '" . $tText . "'");
		redirect('/admin/om-oss?success');
	}

	function uploadGuide()
	{
		checkAdmin();
		$articleGet = $this->db->query('
            SELECT Products.*, measurement.articleNumber
            FROM Products
            INNER JOIN measurement
            ON Products.productID = measurement.productID
            WHERE measurement.articleNumber = "' . $_POST['guideArticle'] . '"
        ')->row_array();
		$getFile = pathinfo($_FILES['file_upload']['name']);
		$title = $_POST['guideTitle'];
		$article = $_POST['guideArticle'];
		$fileName = $getFile['filename'] . '.' . $getFile['extension'];
        $productID = $articleGet['productID'];
		if($articleGet['articleNumber'] != $article) {
			redirect('/admin/guider?error');
		}

		if($_FILES['file_upload']['name'] == '' || $_POST['guideTitle'] == '') {
			redirect('/admin/guider?error');
		}

		if(isset($_FILES)) {
			if($_FILES['file_upload']['error'] > 0){
				redirect('/admin/guider?error');
	    	}

	    	$exte = array('jpg', 'png', 'jpeg', 'PNG', 'JPG', 'JPEG', 'pdf', 'PDF');
	    	if(!in_array($getFile['extension'], $exte)) {
				redirect('/admin/guider?error');
	    	}

			if($_FILES['file_upload']['size'] > 500000000) {
				redirect('/admin/guider?error');
			}

			if(file_exists('assets/guides/' . $_FILES['file_upload']['name'])) {
				redirect('/admin/guider?error');
			} 

			if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'assets/guides/' . $_FILES['file_upload']['name'])) {
				redirect('/admin/guider?error');
			} 	
		
		}

		$this->db->query("INSERT INTO Guides (title, fileGuide, productID) VALUES ('$title', '$fileName', '$productID')");
		redirect('/admin/guides?success');
		
	}

	function deleteGuide($id)
	{
		checkAdmin();
		$getGuide = $this->db->query("SELECT * FROM Guides WHERE id = '" . $id . "'")->row_array();
		$pathtoguide = 'assets/guides/'.$getGuide['fileGuide'];
		unlink($pathtoguide);
		$this->db->query("DELETE FROM Guides WHERE id = '" . $id . "'");
		redirect('/admin/guides?success=deleted');
	}

	function editContact()
	{
		checkAdmin();
		$adress = $_POST['address'];
		$zip = $_POST['zipcode'];
		$tel = $_POST['telephone'];
		$email = $_POST['email'];
		$fax = $_POST['fax'];
		$this->db->query("UPDATE ContactInfo SET Address = '" . $adress . "', Telephone = '" . $tel . "', Fax = '" . $fax . "', Email = '" . $email . "', ZipCode = '" . $zip . "'");
		redirect('/admin/kontakt?success');
	}

	function categories()
	{
		checkAdmin();
		$data['title'] = 'Admin Panel' . ' &raquo; Imcon AB';
        $data['classes'] = 'categories admin-categories';
        $data['getCategories'] = $this->db->query("SELECT * FROM Categories")->result_array();
        $data['getsubCategories'] = $this->db->query("SELECT * FROM subCategories")->result_array();
		$this->template->set_layout('admin')->build('adminCategories', $data);
	}

	function addCategory()
	{
		checkAdmin();
		$nameCat = $_POST['category'];
		if($nameCat != '')
		{
			$this->db->query("INSERT INTO Categories (articleGroup) VALUES ('$nameCat')");
		}
		redirect('/admin/produkter');
	}

	function addSubCategory($categoryID)
	{
		checkAdmin();
		$subCatname = $_POST['subcategory'];
		if($subCatname != '')
		{
			$this->db->query("INSERT INTO subCategories (articleGroup, id) VALUES ('$subCatname', '$categoryID')");
			redirect('/admin/produkter?cat=' . $categoryID . '');
		} else {
			redirect('/admin/produkter');
		}
	}

	function removeSubCat($catID, $categoryID)
	{
		checkAdmin();
		$this->db->query("DELETE FROM subCategories WHERE '" . $categoryID . "' = unique_id");
		redirect('/admin/produkter?cat=' . $catID . '');
	}

	function removeCategory($id)
	{
		checkAdmin();
		$this->db->query("DELETE FROM Categories WHERE id = '" . $id . "'");
		redirect('/admin/produkter');
	}

	function editServicesImgs()
	{
		$images = $this->db->query("SELECT * FROM servicesImages WHERE id = '".$_GET['edit']."'")->result_array();
		$path = '';
		if($images[0]['filename'] != '') {
		$path = 'assets/images/' . $images['filename'] . '.' . $images['extension'];
		}

		if($_FILES['file_upload']['name'] != '')
		{
			$pathinfo = pathinfo($_FILES['file_upload']['name']);
			$extension = strtolower($pathinfo['extension']);
			$exte = array('jpg', 'png', 'jpeg', 'PNG', 'JPG', 'JPEG', 'gif', 'GIF');

				if(file_exists($path)) {
					unlink($path);
				}

		    	if(!in_array($extension, $exte)) {
					redirect('/admin/services?error');	
		    	}

				if($_FILES['file_upload']['size'] > 500000000) {
					redirect('/admin/services?error');	
				}

				if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'assets/images/' . $pathinfo['filename'] . '.' . $pathinfo['extension'])) {
					redirect('/admin/services?error');	
				}
			$this->db->query("UPDATE servicesImages SET filename = '".$pathinfo['filename']."', extension = '".$pathinfo['extension']."' WHERE id = '".$images[0]['id']."'");
		}
		redirect('/admin/services?success=img');
	}

	function addBG()
	{
		checkAdmin();
		$text = $_POST['bg'];
		$bgname = $_POST['bgname'];
		$bText2 = $_POST['bgtext'];
		$bText = $_POST['buttontext'];
		$bLink = $_POST['buttonlink'];
		$align = $_POST['align'];
		$shadow = (!empty($_POST['shadow']) ? '1' : '0');

		$bgdb = $this->db->query("SELECT * FROM backgrounds WHERE filename = '" . $text . "'")->row_array();
		if($_FILES['file_upload']['name'] != '')
		{
			$pathinfo = pathinfo($_FILES['file_upload']['name']);
			$filename = $pathinfo['filename'];
			$extension = strtolower($pathinfo['extension']);
			if(isset($_FILES)) {
				if($_FILES['file_upload']['error'] > 0) {	
					redirect('/admin?error');
		    	}

		    	$exte = array('jpg', 'png', 'jpeg', 'PNG', 'JPG', 'JPEG');
		    	if(!in_array($extension, $exte)) {
					redirect('/admin?error');	
		    	}

				if($_FILES['file_upload']['size'] > 500000000) {
					redirect('/admin?error');
				}

				//removes current bg file
		    	//unlink('/assets/images/' . $bgdb['filename'] . '.' . $bgdb['extension']);

				if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'assets/images/' . $_POST['bgname'] . '.' . $extension)) {
					redirect('/admin?error');
				}
				
			}
			$this->db->query("UPDATE backgrounds SET title = '" . $text . "', bgtext = '" . $bText2 . "', buttontext = '" . $bText . "', buttonlink = '" . $bLink . "', align = '" . $align . "', filename = '" . $bgname . "', extension = '" . $extension . "', shadow = '" . $shadow . "' WHERE filename = '" . $bgname . "'");
		} else {
			$this->db->query("UPDATE backgrounds SET title = '" . $text . "', bgtext = '" . $bText2 . "', buttontext = '" . $bText . "', buttonlink = '" . $bLink . "', align = '" . $align . "', shadow = '" . $shadow . "' WHERE filename = '" . $bgname . "'");
		}
		redirect('/admin?success');
	}

	function addColleague()
	{
		checkAdmin();
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$role = $_POST['role'];
		if($_FILES['file_upload']['name'] != '')
		{
			$pathinfo = pathinfo($_FILES['file_upload']['name']);
			$filename = $pathinfo['filename'];
			$extension = strtolower($pathinfo['extension']);
			if(isset($_FILES)) {
				if($_FILES['file_upload']['error'] > 0) {
                    redirect('/admin/om-oss?error');
		    	}

		    	$exte = array('jpg', 'png', 'jpeg', 'PNG', 'JPG', 'JPEG');
		    	if(!in_array($extension, $exte)) {
                    redirect('/admin/om-oss?error');
		    	}

				if($_FILES['file_upload']['size'] > 500000000) {
                    redirect('/admin/om-oss?error');
				}

				//removes current bg file
		    	//unlink('/assets/images/' . $bgdb['filename'] . '.' . $bgdb['extension']);

				if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'assets/images/colleagues/' . $filename . '.' . $extension)) {
                    redirect('/admin/om-oss?error');
				} 	
				
			}
			$this->db->query("INSERT INTO colleagues (firstname, lastname, role, filename, extension) VALUES ('$firstname', '$lastname', '$role', '$filename', '$extension')");
		} else {
			$this->db->query("INSERT INTO colleagues (firstname, lastname, role) VALUES ('$firstname', '$lastname', '$role')");
		}
		redirect('/admin/om-oss?success=added');
	}

	function editColleague()
	{
		checkAdmin();
		if(isset($_POST['submit'])) {
			$name = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$role = $_POST['role'];
			$id = $_POST['id'];
			$filename = $_FILES['file_upload']['name']; 

			if($filename != '') {
				echo "omg";
			} else {
				echo "a file is there";
			}
			$this->db->query("UPDATE colleagues SET firstname = '" . $name . "', lastname = '" . $lastname . "', role = '" . $role . "' WHERE id = '" . $id . "'");
			//redirect('admin/editColleague?id=' . $id . '');
		} else {
			$data['id'] = $this->db->query("SELECT * FROM colleagues WHERE id = '" . $_GET['id'] . "'")->row_array();
			$this->load->view('editColleague', $data);
		}
	}

	function removeColleague($id)
	{
		checkAdmin();
		$this->db->query("DELETE FROM colleagues WHERE id = '" . $id . "'");
		redirect('/admin/om-oss?success=deleted');
	}

	function cleanse()
	{
		$clean = $this->db->query("SELECT articleImage, articleExtension FROM Products")->result_array();
		$path = 'assets/images/products/';
		$scan = scandir($path);
		$table = array();
		//673 count + 2
		$i = 0;
		foreach($clean as $c) {
			$table[$i] = $c['articleImage'] . '.' . $c['articleExtension'];
			$i++;
		}
		//preprint($table);
		//preprint($scan);
		foreach($table as $t) {
			echo $t . '<br/>';
			foreach($scan as $s) {
				echo $s . '---<br />';
			}
		}

		/*
		$count = 0;
		foreach($scan as $s) {
			foreach($table as $t) {
				if($t == $s)
					echo $count . '<br/>';
			}
			$count++;
		}
		*/



	}
}

