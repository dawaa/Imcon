<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('checkAdmin')) {
  function checkAdmin() {
  	session_start();
  	if(!isset($_SESSION['name'])) {
  		redirect('/login');
  	}
  }
}