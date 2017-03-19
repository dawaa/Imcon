<?php
class Kontakta_oss extends CI_Controller
{
		
	   function index()
	   {
                $data['title'] = 'Kontakta oss' . ' &raquo; Imcon AB';
                $data['classes'] = 'contact';
                $data['contact'] = $this->db->query("SELECT * FROM ContactInfo")->row_array();
                if(isset($_GET['article'])) {
                	$data['getProduct'] = $this->db->query('
                        SELECT measurement.articleNumber, measurement.measure, Products.articleName
                        FROM measurement
                        INNER JOIN Products
                        ON Products.productID = measurement.productID
                        WHERE measurement.articleNumber = "' . $_GET['article'] . '"
                    ')->row_array();
                }
                $this->template->build('kontakta_oss', $data);
	   }   

        function sendEmail()
        {
                $contact = $this->db->query("SELECT * FROM ContactInfo")->row_array();
                $from = $_POST['email'];
                $to = $contact['Email'];

                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($_POST['question']);
                $this->email->message($_POST['contactText']);
                $this->email->send();
                redirect('/kontakt?success');
        }
}
