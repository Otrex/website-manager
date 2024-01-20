<?php

require_once "_api.php";

use App\Core\Controller;

class TemplatesController extends Controller 
{
  use UserAuthTrait;

  private $templates;
  private $user;

  public $id;

  public function __construct() {
    $this->templates = get_app_config('templates');
    $this->user = $this->getUser();
    parent::__construct();
  }

  public function handler() {
    $this->send(get_app_config('test'));
  }
}

serve(function() {
  $controller = new TemplatesController();
  $controller->handler();
}, __FILE__);