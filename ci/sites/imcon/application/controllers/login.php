<?php
class Login extends CI_Controller
{
	function index()
	{
		$data['title'] = 'Admin Panel' . ' &raquo; Imcon AB';
        $data['classes'] = 'admin-login';
		$this->template->build('adminLogin', $data);
	}

	function validate()
	{
		$username = mysql_real_escape_string($_POST['username']);
		$password = md5(mysql_real_escape_string($_POST['password']));
		$checkDB = $this->db->query("SELECT * FROM adminUser WHERE username = '" . $username . "' AND password = '" . $password . "'")->row_array();
		if($checkDB == TRUE)
		{
			session_start();
			$_SESSION['name'] = $username;
			redirect('/admin');
		} else {
			redirect('/login?error');
		}
	}
}