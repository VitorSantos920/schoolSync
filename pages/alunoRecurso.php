<?php

require_once '../db/config.php';

date_default_timezone_set('America/Sao_Paulo');



session_start();

if (!isset($_SESSION['email']) || $_SESSION['categoria'] != "Aluno") {

    header('Location: ./index.php');

    exit;
}



$dadosAluno = DB::queryFirstRow("SELECT *, al.id as 'aluno_id' FROM usuario us INNER JOIN aluno al ON al.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);

?>



<!DOCTYPE html>

<html lang="pt-br">



<head>

    <meta charset="UTF-8">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="../assets/css/global.css">

    <link rel="icon" href="../assets/img/logo_transparente.png">

    <link rel="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js"></script>

    <style>
        .container {

            width: 100%;

            margin: 15px auto;

        }



        .linha-vertical {

            border-left: 3px solid lightgray;

            /* ou border-right, dependendo do lado que você quer a linha */

            height: 100%px;

        }



        .linha-vertical2 {

            border-right: 3px solid lightgray;

            /* ou border-right, dependendo do lado que você quer a linha */

            height: 100%px;

        }



        .linha-horizontal {

            border: none;

            border-top: 3px solid lightgray;

            /* ou border-bottom, dependendo do lado que você quer a linha */

            margin: 0;

            /* Remova as margens */

            padding: 0;

            /* Remova os preenchimentos */

            width: 100%;

            /* Define a largura para ocupar toda a largura da div pai */

        }



        body {

            font-family: Poppins;

        }
    </style>

    <title>Painel do aluno - Recursos Educacionais</title>

</head>



<body>

    <?php

    include_once "../components/sidebarAluno.php";

    ?>

    <main>

        <h3><img src="../assets/img/maozinha.png" width="30px" alt="Ícone de mão dando saudação."> Olá, <?php echo $dadosAluno["nome"] ?></h3>

        <h1>Confira os recursos educacionais.</h1><br>


        <?php

        // Consulta SQL para recuperar os recursos educacionais

        $escolaridadeAluno = $dadosAluno["escolaridade"]; // Supondo que a coluna com a escolaridade do aluno seja "escolaridade"

        $recursos = DB::query("SELECT * FROM recurso_educacional WHERE escolaridade = %s ORDER BY created_at DESC", $escolaridadeAluno);





        // Verificar se há recursos disponíveis

        if ($recursos) {

            foreach ($recursos as $recurso) {

                echo '<div class="row">';

                echo '<div class="col-8">';

                echo '<h5>' . $recurso["titulo"] . '</h5>';

                echo '</div>';

                echo '<div class="col-8">';

                echo '<h6>' . $recurso["descricao"] . '</h6>';

                echo '</div>';

                echo '<div class="col-4">';

                echo '<a href="' . $recurso["url"] . '" target="_blank"><Strong>Acessar</Strong></a>'; // Link para acessar o recurso

                echo '</div>';

                echo '<hr class="linha-horizontal"><br>';

                echo '</div>';
            }
        } else {

            echo '<p>Nenhum recurso educacional disponível no momento.</p>';
        }

        ?>


</body>





</html>