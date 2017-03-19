<?php
class Om_oss extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Om oss' . ' &raquo; Imcon AB';
        $data['classes'] = 'about';
        $data['aboutText'] = $this->db->query("SELECT * FROM About")->row_array();
        $data['get'] = $this->db->query("SELECT * FROM colleagues")->result_array();
        $this->template->build('om_oss', $data);
	}   
}