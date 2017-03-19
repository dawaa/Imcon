<?php
class addGuide extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Lägg till guide' . ' &raquo; Imcon AB';
        $data['classes'] = 'admin-add-guide';
		$this->load->view('addGuide', $data);
	}   
}