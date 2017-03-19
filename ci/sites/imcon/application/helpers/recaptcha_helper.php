<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('recaptcha'))
{
  function recaptcha()
  {
      $url = 'https://www.google.com/recaptcha/api/siteverify';
      $secret = '6LcohRkUAAAAAG1ooQO5RkVMqY02wF5nNsDHKNik';
      $recaptcha = $_POST['g-recaptcha-response'];
      $remoteip = $_SERVER['REMOTE_ADDR'];

      $response = file_get_contents(
          $url .
          "?secret=" . $secret .
          "&response=" . $recaptcha .
          "&remoteip=" . $remoteip
      );
      $data = json_decode( $response );
      return $data;
  }
}
