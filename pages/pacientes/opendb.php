<?php
  $host = 'localhost';
  $user = 'root';
  $password = '';
  $database = 'gxfisio';

  // estabelecer conexão com o mysql
  $sqli = $mysql_conn = new mysqli($host, $user, $password);

  // verificar se houve erro na conexão
  if ($sqli->connect_error) {
    // se houve erro, mostra erro na tela
    echo "<p>Erro ao Conectar: $sqli->connect_error</p>";
  }

  // alterar o tipo de codificação da conexão com o banco de dados,  para utf8
  if (!$sqli->set_charset('utf8')) {
    echo "<p class='error'>O charset não é utf8: $sqli->error</p>";
  }

  // selecionar/abrir o banco de dados para trabalhar
  if (!$sqli->select_db($database)) {
    // se o banco de dados não for encontrado
    echo "<p class='error'>Banco de dados não encontrado</p>";
  }

  if ($mysql_conn == FALSE) {
    echo("Unable to establish connection with the mysql server");
    exit;
  }