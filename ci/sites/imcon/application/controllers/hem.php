<?php
class Hem extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Imcon AB';
        $data['classes'] = 'home';
        $data['info'] = $this->db->query("SELECT * FROM backgrounds")->result_array();
		$this->template->build('hem', $data);
	}   

	function category($categoryID = '')
	{
		$data['title'] = 'Imcon AB';
        $data['classes'] = 'category';
        //$data['getCategory'] = $this->db->query("SELECT Products.articleName, Products.articleGroup FROM Products INNER JOIN Categories ON Products.articleGroup = Categories.articleGroup WHERE Products.articleGroup = 'Pet'")->result_array();
        //$data['getCategory'] = $this->db->query("SELECT Categories.articleGroup FROM Categories INNER JOIN Products ON Products.articleGroup = Categories.articleGroup WHERE Products.articleGroup = 'Pet'")->result_array();
        $data['listCategories'] = $this->db->query("SELECT * FROM Categories")->result_array();
        //$data['getsubCategory'] = $this->db->query("SELECT subCategories.articleGroup FROM subCategories INNER JOIN Categories ON Categories.id = subCategories.id WHERE subCategories.id = '1'")->result_array();
        $data['getsubCategory'] = $this->db->query("SELECT subCategories.articleGroup FROM subCategories INNER JOIN Categories ON Categories.id = subCategories.id WHERE subCategories.id = '" . $categoryID . "'")->result_array();
        $data['category_id'] = $categoryID;
		$this->template->build('categoryTesting', $data);
	}

	function subcategory($categoryID = '')
	{
		$data['title'] = 'Imcon AB';
        $data['classes'] = 'subcategory';
        $data['id'] = $categoryID;
        $data['getsubCategory'] = $this->db->query("SELECT subCategories.articleGroup FROM subCategories INNER JOIN Categories ON Categories.id = subCategories.id WHERE subCategories.id = '" . $categoryID . "'")->result_array();
		$this->template->build('subCategorytesting', $data);
	}
}