<?php

namespace Plum\Http;

use Exception;

class FormData {

  private const ONE_MONTH = 60 * 24 * 30;

  /**
   * get all form data
   *
   * @return void
   */
  public function all()
  {
    if (isset($_POST)) {
      return $_POST;
    }
    return array();
  }

  /**
   * get POST value method parameter by using `$name`
   *
   * @param string $name
   * @param mixed|null $default
   * @return mixed
   */
  public function value(string $name, $default = null)
  {
    if (isset($_POST[$name])) {
      $post = $_POST[$name];

      if (is_array($post)) {
        return array_map(function($p) {
          return htmlspecialchars($p);
        }, $post);
      }
      return htmlspecialchars($post);
    }
    return $default;
  }

  /**
   * get all session to array. if not set, return null
   *
   * @return array|null
   */
  public function getAllSessions(): ?array
  {
    session_start();

    if (isset($_SESSION)) {
      return $_SESSION;
    }
    return null;
  }

  /**
   * can get session to specify `$name`
   *
   * @param string $name
   * @param mixed|null $default
   * @return mixed
   */
  public function getSession(string $name, $default = null)
  {
    session_start();

    if (isset($_SESSION[$name])) {
      return $_SESSION[$name];
    }
    return $default;
  }

  /**
   * setting session by using `$name`. default expire is one month
   *
   * @param string $name
   * @param integer $expire
   * @return void
   */
  public function setSession(string $name, int $expire = FormData::ONE_MONTH): void
  {
    $value = $this->value($name);

    if (isset($value)) {
      session_cache_expire($expire);
      session_start();

      $_SESSION[$name] = $value;
    } else {
      //TODO: 別でExcepionクラス作る？
      throw new Exception("name: {$name} is not posted");
    }
  }
}
