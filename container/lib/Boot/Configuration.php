<?php

namespace Plum\Boot;

use ORM;
use Plum\Environment\Env;

class Configuration {
  protected $db_connection_name;

  public function __construct() {
    $this->db_connection_name = Env::get('DB_CONNECTION');
  }

  /**
   * boot process running all config
   *
   * @return void
   */
  public function boot(): void
  {
    $this->runDBConfig();
  }

  /**
   * run db config all setting
   *
   * @return void
   */
  private function runDBConfig(): void
  {
    list($host, $dbname, $user, $pass) = Env::getMany('DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD');

    $this->setConnection($host, $dbname)
      ->setUsername($user)
      ->setPassword($pass);
  }

  /**
   * set db user name
   *
   * @param string $value
   * @return Configuration
   */
  private function setUsername(string $value): Configuration
  {
    ORM::configure('username', $value);
    return $this;
  }

  /**
   * set db password
   *
   * @param string $value
   * @return Configuration
   */
  private function setPassword(string $value): Configuration
  {
    ORM::configure('password', $value);
    return $this;
  }

  /**
   * set db connection.
   *
   * @param string $host
   * @param string $db_name
   * @param mixed $connection_name
   * @return Configuration
   */
  private function setConnection(string $host, string $db_name, $connection_name = ORM::DEFAULT_CONNECTION): Configuration
  {
    $connection_name = $this->db_connection_name;
    ORM::configure("{$connection_name}:host={$host};dbname={$db_name};charset=utf8");

    return $this;
  }
}
