<?php
require_once '../db/config.php';
date_default_timezone_set('America/Sao_Paulo');

session_start();

if (!isset($_SESSION['id']) || $_SESSION['categoria'] != "Responsavel") {
  header('Location: ./permissao.php');
  exit;
}

$dadosResponsavel = DB::queryFirstRow("SELECT *, us.id as 'us_id', res.id as 'res_id' FROM usuario us INNER JOIN responsavel res ON res.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);

$filhosResponsavel = DB::query("SELECT * FROM aluno al INNER JOIN usuario us ON al.usuario_id = us.id WHERE al.responsavel_id = %i", $dadosResponsavel['res_id']);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Inicial | Responsável</title>
</head>

<body>
  <?php
  include_once "../components/sidebar.php";

  ?>

  <main>
    <section class="saudacao d-flex align-items-center">
      <img width="30" src="../assets/img/hand.svg" alt="Emoji de mão amarela acenando.">
      <h2 class="saudacao__titulo">Olá, <?php echo $dadosResponsavel['nome'] ?>!</h2>
    </section>

    <?php
    echo var_dump($dadosResponsavel);
    ?>
    <p>
      <?php
      echo var_dump($filhosResponsavel);
      foreach ($filhosResponsavel as $filho) {
        echo "
          <p>{$filho['nome']}</p>
        ";
      }
      ?>

    </p>
  </main>
</body>

</html>