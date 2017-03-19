<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('preprint'))
{
  function preprint($var)
  {
  	echo '<pre>';
  	print_r($var);
  	echo '</pre>';  	
  	return;
  }
}