<?php
class Measurement extends CI_Controller
{
		
	function index()
	{
        $data['title'] = 'Mått' . ' &raquo; Imcon AB';
        $data['classes'] = 'measurement';
        $data['measurement'] = $this->db->query('
            SELECT *
            FROM measurement
            WHERE productID = "' . $_GET['id'] . '"
        ')->result_array();
		$this->load->view('measurement', $data);
	}   
}