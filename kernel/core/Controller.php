<?php

namespace App\Core;

class Controller
{
  public static function serve($cb) {
    return $cb(new self());
  }

  public function send($message, int $code = 200, $headers = []) {
    $defaultHeaders = [ "Content-type" => "application/json" ];
    $_headers = array_merge(($defaultHeaders ?? []), $headers);

    foreach ($_headers as $key => $header) {
      header("$key:$header");
    }
    
    http_response_code($code);

    if (isset($_headers["Content-type"]) && $_headers["Content-type"] == "application/json") {
      echo json_encode($message);
    } else {
      echo $message;
    }
    exit;
  }

  public function __construct() {
    $properties = get_object_vars($this);
    foreach ($properties as $key => $value) {
      if (isset($_GET[$key])) {
        $this->$key = $_GET[$key];
      } else if (isset($_POST[$key])) {
        $this->$key = $_POST[$key];
      } else if (isset($_FILES[$key])) {
        $this->$key = $_FILES[$key];
      } else {
        $this->$key = null;
      }
    }
  }
}