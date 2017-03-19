<?php 
class Adminpanel extends CI_Controller
{
	function index()
	{
        $data['title'] = 'Admin Panel' . ' &raquo; Imcon AB';
        $data['classes'] = 'admin-home';
		$this->template->set_layout('admin')->build('admin', $data);
	}

	function products()
	{
        $data['title'] = 'Produkter - Admin Panel' . ' &raquo; Imcon AB';
        $data['classes'] = 'admin-products';
		$this->template->set_layout('admin')->build('products', $data);
	}

	function removeItem($id)
	{
		$this->db->query("DELETE '" . $id . "' FROM Products WHERE '" . $id . "' = id");
		redirect('/adminPanel/products');
	}


	function updateEdit()
	{
		$id = $_POST['id'];
		$name = $_POST['articleName'];
		$number = $_POST['articleNumber'];
		$group = $_POST['articleGroup'];
		$desc = $_POST['articleDescription'];
		$img = $_POST['articleImage'];

		$this->db->query("UPDATE Products SET articleName = '" . $name . "', articleNumber = '" . $number . "', articleGroup = '" . $group . "', articleDescription = '" . $desc . "', articleImage = '" . $img . "'  WHERE '" . $id . "' = id");
		redirect('/adminPanel/products');
		//SPAWN OF SATAN " "
	}

	function addItem()
	{
        $data['title'] = 'Lägg till produkt - Admin Panel' . ' &raquo; Imcon AB';
        $data['classes'] = 'admin-add-product';
		$this->template->set_layout('admin')->build('addProduct', $data);
	}

	function productAdded()
	{
		$name = $_POST['aName'];
		$number = $_POST['aNumber'];
		$group = $_POST['aGroup'];
		$desc = $_POST['aDescription'];
		$img = $_POST['aImage'];
		$this->db->query("INSERT INTO Products (articleName, articleNumber, articleGroup, articleDescription, articleImage)
							VALUES('$name', '$number', '$group', '$desc', '$img')");
		redirect('/adminPanel/products/');
	}

	function services()
	{
		$data['title'] = 'Admin Panel' . ' &raquo; Imcon AB';
        $data['classes'] = 'admin-services';
        $data['text'] = $this->db->query("SELECT * FROM Services WHERE id = '1'")->row_array();
		$this->template->set_layout('admin')->build('adminServices', $data);
	}

	function guides()
	{
		$data['title'] = 'Admin Panel' . ' &raquo; Imcon AB';
        $data['classes'] = 'admin-guides';
		$this->template->set_layout('admin')->build('adminGuides', $data);
	}

	function contactUs()
	{
		$data['title'] = 'Admin Panel' . ' &raquo; Imcon AB';
        $data['classes'] = 'admin-contact';
		$this->template->set_layout('admin')->build('adminContact', $data);
	}

	function editServices()
	{
		$sText = $_POST['serviceText'];
		$this->db->query("UPDATE Services SET text = '" . $sText . "' WHERE id = '1'");
		redirect('/adminPanel/services');
	}
}

