<?php

function output(string $t) {
    echo $t;
}

function get_buffer(callable $func_name, array $args = [null]):string {
  ob_start();
  call_user_func_array($func_name, $args);
  return ob_get_clean();
}

$text = '';

get_buffer(function() {
  echo "Hallo " . output('World!') . "\r\n";
  ob_start();
  output('World!');
  $text = ob_get_clean();
});

echo "Hallo {$text}\r\n";
