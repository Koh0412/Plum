<?php

namespace App\Controllers;

use Plum\Http\Request;

class HomeController extends ApplicationController {

  public function index()
  {
    return $this->view('top', ['msg' => 'hello']);
  }

  public function create(Request $request)
  {
    return "created. name: {$request->name}";
  }
}
