<?php
class Produkter extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Produkter' . ' &raquo; Imcon AB';
        $data['classes'] = 'products';
        $data['listCategories'] = $this->db->query("SELECT * FROM Categories")->result_array();
        if(isset($_GET['cat'])) {
            $data['getsubCategory'] = $this->db->query("SELECT subCategories.* FROM subCategories INNER JOIN Categories ON Categories.id = subCategories.id WHERE subCategories.id = '" . $_GET['cat'] . "'")->result_array();
    	}
        $this->template->build('produkter', $data);
	}   

	function produkt()
	{
        $data['url'] = $this->db->query("SELECT * FROM Products WHERE '" . $_GET['id'] . "' = productID")->row_array();
		$data['title'] = $data['url']['articleName'] . ' &raquo; Produkter' . ' &raquo; Imcon AB';
        $data['classes'] = 'products product';
        $data['listCategories'] = $this->db->query("SELECT * FROM Categories")->result_array();
        $subcat = $this->db->query("SELECT articleSub FROM Products WHERE productID = '" . $_GET['id'] . "'")->result_array();
        //$data['getsubCategory'] = $this->db->query("SELECT * FROM subCategories WHERE unique_id = '" . $subcat[0]['articleSub'] . "'")->result_array();
        $data['listSubs'] = $this->db->query("SELECT * FROM subCategories")->result_array();
        $data['trying2bcool'] = $this->db->query("SELECT Categories.id, Products.articleSub, Products.articleGroup FROM Products INNER JOIN Categories ON Products.articleGroup = Categories.articleGroup WHERE Products.productID = '" . $_GET['id'] . "'")->result_array(); 
        $data['getGuides'] = $this->db->query("
            SELECT Guides.productID, Guides.title, Guides.fileGuide
            FROM Guides
            INNER JOIN Products
            ON Guides.productID = Products.productID
            WHERE Products.productID = '" . $_GET['id'] . "'
        ")->result_array();
        $data['getMeasure'] = $this->db->query('
            SELECT measurement.measure
            FROM measurement
            INNER JOIN Products
            ON Products.productID = measurement.productID
            WHERE Products.productID = "' . $_GET['id'] . '"
        ')->result_array();
        $data['getMeasure2'] = $this->db->query('
            SELECT *
            FROM measurement
            WHERE productID = "' . $_GET['id'] . '"
        ')->result_array();
        $this->template->build('produkt', $data);
	}

    function search()
    {
        $data['title'] = 'Produkter' . ' &raquo; Imcon AB';
        $data['classes'] = 'products search';
        $data['listCategories'] = $this->db->query("SELECT * FROM Categories")->result_array();
        $query = $_GET['q'];
        $data['search'] = $this->db->query("SELECT articleName FROM Products WHERE articleName LIKE '%" . $query . "%'")->result_array();
        $this->template->build('search', $data);
    }
}