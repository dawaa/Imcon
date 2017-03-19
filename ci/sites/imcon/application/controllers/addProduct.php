<?php
class addProduct extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Lägg till produkt' . ' &raquo; Imcon AB';
        $data['classes'] = 'admin-add-product';
		$this->load->view('addProduct', $data);
	}   
}