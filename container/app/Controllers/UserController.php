<?php

namespace App\Controllers;

use App\Models\User;
use Plum\Routing\RouteParameters;

class UserController extends ApplicationController {

  public function show(RouteParameters $params)
  {
    $user = User::find_one($params->id);
    // TODO: modelがない(存在しないrecordのIDを入れる等)場合は404に
    return $this->view('users.show', ['user' => $user]);
  }

  public function new()
  {
    return $this->view('users.new');
  }

  public function create()
  {
    $properties = [
      'name' => $this->request()->name,
      'age' => $this->request()->age
    ];

    User::setModel($properties)->save();
    return redirect();
  }
}
