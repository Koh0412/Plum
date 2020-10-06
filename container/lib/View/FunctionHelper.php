<?php

namespace Plum\View;

/**
 * this class for template custom helper function
 */
class FunctionHelper {

  /**
   * create anchor link element
   *
   * @param array $param
   * @return string
   */
  public static function link_to(array $param): string
  {
    return createElement('a', $param['text'], [
      'href' => $param['href'],
    ]);
  }

  /**
   * create asset tag by using server domain
   *
   * @param array $param
   * @return string
   */
  public static function asset(array $param): string
  {
    $domain = request()->schemeHost();
    $path = $param['path'];

    return createElement('link', null, [
      'rel' => 'stylesheet',
      'href' => "$domain/$path"
    ]);
  }
}

/**
 * create html element
 *
 * @param string $tag
 * @param string|null $text
 * @param array $attributes
 * @return string
 */
function createElement(string $tag, ?string $text, array $attributes): string {
  $attr_text = '';
  foreach ($attributes as $key => $value) {
    $attr_text .= "$key=\"$value\" ";
  }
  $elm = "<$tag $attr_text>$text</$tag>";
  return $elm;
}
