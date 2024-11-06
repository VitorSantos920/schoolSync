<?php
require_once '../backend/init-configs.php';

if ($_SESSION['categoria'] != "Responsavel") {
  header('Location: ./permissao.php');
  exit;
}

$dadosResponsavel = DB::queryFirstRow("SELECT *, us.id as 'us_id', res.id as 'res_id' FROM usuario us INNER JOIN responsavel res ON res.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);

$filhosResponsavel = DB::query("SELECT *, al.id as 'aluno_id' FROM aluno al INNER JOIN usuario us ON al.usuario_id = us.id WHERE al.responsavel_id = %i", $dadosResponsavel['res_id']);

$quantidadeFilhosResponsavel = DB::queryFirstField("SELECT COUNT(*) FROM aluno al INNER JOIN usuario us ON al.usuario_id = us.id WHERE al.responsavel_id = %i", $dadosResponsavel['res_id']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Inicial - Responsável | SchoolSync</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/pagina-inicial-responsavel.css?time=<?= time() ?>">
</head>

<body>
  <div class="wrapper">
    <div class="content-wrapper">
      <?php
      include_once "../components/header.php";
      include_once "../components/sidebar.php";
      ?>

      <main>
        <section class="saudacao d-flex align-items-center">
          <img width="30" src="../assets/img/hand.svg" alt="Emoji de mão amarela acenando.">
          <h2 class="saudacao__titulo">Olá, <?php echo $dadosResponsavel['nome'] ?>!</h2>

        </section>


        <section class="filhos">
          <h3 class="filhos__quantidade">Seus filhos (<?php echo $quantidadeFilhosResponsavel; ?>)</h3>

          <ul class="filhos__lista-filhos">
            <?php
            foreach ($filhosResponsavel as $filho) {
              echo "
            <li class='filhos__turma'>
              <a href='./pagina-inicial-aluno.php?aluno_id=$filho[aluno_id]' class='d-flex align-items-center gap-2 justify-content-between'>
                {$filho['nome']}
                &gt;
              </a>
            </li>
          ";
            }
            ?>

          </ul>
        </section>

      </main>
    </div>
  </div>
</body>

</html>