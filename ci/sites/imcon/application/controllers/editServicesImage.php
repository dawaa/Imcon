<?php
class editServicesImage extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Redigera tjänster-bild' . ' &raquo; Imcon AB';
        $data['classes'] = 'edit-service-image';
        $data['info'] = $this->db->query("SELECT * FROM servicesImages")->result_array();
		$this->load->view('editServicesImage', $data);
	}   
}