<?php
  // se foi postada uma id
  if (isset($_POST['id'])) {

    $id = $_POST['id'];

    // verificar se a id é numérica Apenas uma implementação de Segurança ! 
    if (!preg_match('/^\d+$/', $id)) {

      // encerra o script com erro
      die(json_encode([
        'type' => 'error',
      ]));
    }

    // conecta ao database:
    require 'opendb.php';

    // define a query de alteração da coluna locked
    $query = 'update prontuarios set locked = 1 where idprontuario = ' . $id . ' limit 1';

    // executa a query e guarda o resultado em $result
  
    if ($result = $sqli->query($query)) {

      // encerra o script com sucesso
      die(json_encode([
        'type' => 'success',
      ]));

    }
  }

  // encerra o script com erro
  die(json_encode([
    'type' => 'error',
  ]));
?>