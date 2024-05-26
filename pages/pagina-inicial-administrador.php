<?php

require_once '../db/config.php';



session_start();

if (!isset($_SESSION['email']) || $_SESSION['categoria'] != "Administrador") {

  header('Location: ./permissao.php');

  exit;

}



$dadosAdministrador = DB::queryFirstRow("SELECT * FROM  usuario us INNER JOIN  administrador adm ON adm.usuario_id = us.id WHERE us.id=%i", $_SESSION['id']);





?>



<!DOCTYPE html>

<html lang="pt-BR">



<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Administrador | Página Inicial</title>

  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

  <link rel="stylesheet" href="../assets/css/pages__pagina-inicial-administrador.css">

</head>



<body>

  <?php

  include "../components/sidebarAdmin.php";

  ?>

  <main>



    <section class="saudacao d-flex align-items-center">

      <img width="30" src="../assets/img/hand.svg" alt="Emoji de mão amarela acenando.">

      <h2 class="saudacao__titulo">Olá, <?php echo $dadosAdministrador['nome'] ?>!</h2>

    </section>



    <section class="acoes d-flex flex-wrap">

      <a class="acoes__acao" href="./gerenciar-contas.php">

        Gerenciar Contas

      </a>

      <a class="acoes__acao" href="./recursos-educacionais.php">

        Recursos Educacionais

      </a>

    </section>



  </main>

  <script src="../assets/js/jquery.min.js"></script>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>

  <script src=""></script>



</body>



</html>