<?php
class editColleague extends CI_Controller
{
	function index()
	{
		$data['title'] = 'Redigera kollega' . ' &raquo; Imcon AB';
        $data['classes'] = 'edit-colleague';
		$data['id'] = $this->db->query("SELECT * FROM colleagues WHERE id = '" . $_GET['editColleague'] . "'")->row_array();
		$this->load->view('editColleague', $data);
	}

	function edit()
	{
		if(isset($_POST['submit']))
		{
			$name = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$role = $_POST['role'];
			$id = $_POST['id'];
			$filenameExists = $_FILES['file_upload']['name']; 
			$get = $this->db->query("SELECT * FROM colleagues WHERE id = '" . $id . "'")->row_array();	

			if($filenameExists != '')
			{
				$pathinfo = pathinfo($_FILES['file_upload']['name']);
				$filename = $pathinfo['filename'];
				$extension = strtolower($pathinfo['extension']);
				if(isset($_FILES)) {
					if($_FILES['file_upload']['error'] > 0) {
				        redirect('/admin/om-oss?error');
			    	}

			    	$exte = array('jpg', 'png', 'jpeg', 'PNG', 'JPG', 'JPEG');
			    	if(!in_array($extension, $exte)) {
				        redirect('/admin/om-oss?error');	
			    	}

					if($_FILES['file_upload']['size'] > 500000000) {
				        redirect('/admin/om-oss?error');
					}

					//removes current bg file
			    	unlink('assets/images/colleagues/' . $get['filename'] . '.' . $get['extension']);

					if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'assets/images/colleagues/' . $filename . '.' . $extension)) {
				        redirect('/admin/om-oss?error');
					}
					
				}	
			$this->db->query("UPDATE colleagues SET firstname = '" . $name . "', lastname = '" . $lastname . "', role = '" . $role . "', filename = '" . $filename . "', extension = '" . $extension . "' WHERE id = '" . $id . "'");	
			} else {
			$this->db->query("UPDATE colleagues SET firstname = '" . $name . "', lastname = '" . $lastname . "', role = '" . $role . "' WHERE id = '" . $id . "'");	
			}
			
			redirect('admin/om-oss?success=edited');
		} 
	}
}