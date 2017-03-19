<?php
class editSlideshow extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Redigera bildspel' . ' &raquo; Imcon AB';
        $data['classes'] = 'edit-slideshow';
        $data['info'] = $this->db->query("SELECT * FROM backgrounds")->result_array();
		$this->load->view('editSlideshow', $data);
	}   
}