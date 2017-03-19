<?php
class addColleague extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Lägg till kollega' . ' &raquo; Imcon AB';
        $data['classes'] = 'admin-add-colleague';
		$this->load->view('addColleague', $data);
	}   
}