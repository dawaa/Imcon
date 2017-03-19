<?php
 class MY_Controller extends CI_Controller {
 
 function __construct()
 {
  parent::__construct();

  $this->getHeader = file_get_contents('./ci/sites/imcon/application/views/header.php');
  $this->getFooter = file_get_contents('./ci/sites/imcon/application/views/footer.php');
 }
}  