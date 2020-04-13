<?php

  $Modules = 'modules/';

  $Controller = [
    'name' => 'clientes'
  ];

  $View = [
    'name' => 'index'
  ];

  $url = rtrim($_SERVER['QUERY_STRING'], '/');

  if ($url) {
    $url = explode('/', $url);

    $Controller['name'] = array_shift($url);

    if (sizeof($url)) {
      $View['name'] = array_shift($url);
    }
  }

  $Controller['path'] = $Modules . $Controller['name'] . '/' . $Controller['name'] . '.php';
  $View['path'] = $Modules . $Controller['name'] . '/views/' . $View['name'] . '.php';
