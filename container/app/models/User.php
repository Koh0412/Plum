<?php

namespace App\Models;

use Plum\Database\BaseModel;

class User extends BaseModel {

  public function __construct() {
    $this->setTable('users');
  }
}
