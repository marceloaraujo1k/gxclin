<?php
  // conecta o sistema ao database
  require 'app/connect.php';

  // router
  require 'app/router.php';

  // se a view existe
  if (is_readable($View['path'])) {
    require $View['path'];

  } else {
    echo '<p><b>404</b> View não encontrada, chefe: ' . $View['name'] . '</p>';
  }
