<?php
  if (isset($_POST['term'])) {

    // escapa a string
    $search = $sqli->real_escape_string($_POST['term']);

    // define a query
    $query = "SELECT * FROM pacientes WHERE cpf like'%" . $search . "%'";

    // executa a query
    $result = $sqli->query($query);

    // verifica se houve alguma falha na execução da query
    if ($sqli->error) {
      // mata o script com a mensagem de erro
      die(json_encode([
        'error' => $sqli->error
      ]));
      // se não hove erros e há algum resultado
    } else if ($result->num_rows) {
      // mata o script e devolve o resultado
      die(json_encode($result->fetch_all(MYSQLI_ASSOC)));

      // se não houve nenhum erro e nada foi encontrado:
    } else {
      die(json_encode([]));
    }

  }
