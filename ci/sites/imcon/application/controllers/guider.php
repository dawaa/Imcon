<?php
class Guider extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Guider' . ' &raquo; Imcon AB';
        $data['classes'] = 'guides';
        $data['getGuide'] = $this->db->query("SELECT * FROM Guides")->result_array();
        $data['getProduct'] = $this->db->query("
            SELECT Products.productID, Products.articleName, Products.articleImage, Products.articleExtension, Guides.title, Guides.productID
            FROM Products
            INNER JOIN Guides
            ON Products.productID = Guides.productID
            GROUP BY Products.productID
        ")->result_array();
        $this->template->build('guider', $data);
	}   
}