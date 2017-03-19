<?php
class Tjanster extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Tjänster' . ' &raquo; Imcon AB';
        $data['classes'] = 'services';
        $data['text'] = $this->db->query("SELECT * FROM Services WHERE id = '1'")->row_array();
        $data['getBubbles'] = $this->db->query("SELECT * FROM servicesImages")->result_array();
        $this->template->build('tjanster', $data);
	}   
}