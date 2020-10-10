<?php

namespace App\Controllers;

class HomeController extends ApplicationController {

  public function index()
  {
    return $this->view('top', ['msg' => 'hello']);
  }
}
