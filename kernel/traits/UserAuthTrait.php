<?php

trait UserAuthTrait
{
  public function getUser()
  {
    $headers = getallheaders();
    return isset($header['x-user']) 
      ? $header['x-user'] 
      : (isset($_GET['x-user']) 
        ? $_GET['x-user']
        : null );
  }
}