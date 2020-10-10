<?php

namespace Plum\Database;

use Model;

/**
 * if you will use this class, we recommend that set table name, use
 * `
 * $this->setTable
 * `
 */
class BaseModel extends Model {

  protected static $_table;
  protected static $_id_column = 'id';

  public static function __callStatic($name, $arguments)
  {
    return static::model()->$name($arguments);
  }

  /**
   * This method actually returns a wrapped ORM object which allows a database query to be built
   *
   * @return \ORMWrapper
   */
  public static function model(): \ORMWrapper
  {
    $instance = new static;
    return Model::factory(static::class);
  }
  /**
   * set table you use name
   *
   * @param string $value
   * @return BaseModel
   */
  protected function setTable($value): BaseModel
  {
    BaseModel::$_table = $value;
    return $this;
  }

  /**
   * set primary key you use
   *
   * @param string $value
   * @return BaseModel
   */
  protected function setPrimaryKey($value): BaseModel
  {
    BaseModel::$_id_column = $value;
    return $this;
  }
}
