<?php

$servername = "15.235.9.101";
$username = "vfzzdvmy_school_sync";
$password = "L@QCHw9eKZ7yRxz";
$database = "vfzzdvmy_school_sync";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$aluno_id = $_GET['aluno_id'];

if (!is_numeric($aluno_id)) {
    die("ID do aluno inválido");
}

// Obter o classe_id do aluno
$classe_query = "SELECT classe_id FROM aluno WHERE id = $aluno_id";
$classe_result = mysqli_query($conn, $classe_query);

if ($classe_result) {
    $classe_row = mysqli_fetch_assoc($classe_result);
    $classe_id = $classe_row['classe_id'];

    // Buscar eventos com base no classe_id
    $evento_query = "SELECT * FROM evento WHERE classe_id = $classe_id ORDER BY inicio DESC";
    $evento_result = mysqli_query($conn, $evento_query);

    $eventos = [];
    if ($evento_result) {
        while ($row = mysqli_fetch_assoc($evento_result)) {
            $eventos[] = $row;
        }
    } else {
        echo "Erro na consulta de eventos: " . mysqli_error($conn);
    }
} else {
    echo "Erro na consulta de classe: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="icon" href="../assets/img/logo_transparente.png">
    <link rel="stylesheet" href="../assets/css/lista_alunos_da_turma.css?<?= time() ?>">
    <title>Eventos do aluno</title>
</head>

<body>
    <?php require '../components/sidebarProfessor.php'; ?>

    <main>
        <h1>Lista de eventos do aluno</h1><br><br><br>
        <?php
        if (!empty($eventos)) {
            foreach ($eventos as $evento) {
                echo '<div class="row">';
                echo '<div class="col-12">';
                echo '<h5>' . htmlspecialchars($evento["titulo"]) . '</h5>';
                echo '</div>';
                echo '<div class="col-12">';
                echo '<h6>' . htmlspecialchars($evento["descricao"]) . '</h6>';
                echo '</div>';
                echo '<div class="col-12">';
                $inicio_formatado = date('d/m/Y H:i', strtotime($evento["inicio"]));
                $termino_formatado = date('d/m/Y H:i', strtotime($evento["termino"]));
                echo '<br>';
                echo '<h6>Início: ' . $inicio_formatado . '</h6>';
                echo '<h6>Término: ' . $termino_formatado . '</h6>';
                echo '</div>';
                echo '<hr class="linha-horizontal"><br>';
                echo '</div>';
            }
        } else {
            echo '<p>Nenhum evento disponível no momento.</p>';
        }
        ?>
    </main>
</body>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../assets/js/sweetalert2.all.min.js"></script>
<script src="https://kit.fontawesome.com/4ac8bcd2f5.js" crossorigin="anonymous"></script>
<script src="../assets/js/pages__lista-alunos-turma.js"></script>

</html>