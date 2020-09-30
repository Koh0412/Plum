<?php

namespace App\Controllers;

class HomeController extends ApplicationController {

  public function index()
  {
    return $this->view('top', ['msg' => 'hello']);
  }

  public function create()
  {
    return var_dump($_POST);
  }
}
