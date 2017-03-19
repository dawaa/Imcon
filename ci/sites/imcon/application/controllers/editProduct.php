<?php
class editProduct extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Redigera produkt' . ' &raquo; Imcon AB';
        $data['classes'] = 'edit-product';
		$this->load->view('editProduct', $data);
	}   
}