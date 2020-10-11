<?php

namespace App\Controllers;

use App\Models\User;
use Plum\Http\Request;
use Plum\Routing\RouteParameters;

class UserController extends ApplicationController {

  public function show($_, RouteParameters $params)
  {
    $user = User::find_one($params->id);
    // TODO: modelがない(存在しないrecordのIDを入れる等)場合は404に
    return $this->view('users.show', ['user' => $user]);
  }

  public function new()
  {
    return $this->view('users.new');
  }

  public function create(Request $request)
  {
    $model = User::model()->create();

    $properties = [
      'name' => $request->name,
      'age' => $request->age
    ];
    $model->set($properties);

    $model->save();
    return 'ok';
    // TODO: redirect関数を作る
    // header('Location: http://localhost:8010');
  }
}
