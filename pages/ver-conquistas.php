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

// Verifique a consulta manualmente
$query = "SELECT * FROM conquista WHERE aluno_id = $aluno_id ORDER BY data_conquista DESC";
$result = mysqli_query($conn, $query);

$conquistas = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $conquistas[] = $row;
    }
} else {
    echo "Erro na consulta: " . mysqli_error($conn);
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
    <title>Conquistas do aluno</title>
</head>

<body>
    <?php require '../components/sidebarProfessor.php'; ?>

    <main>
        <h1>Lista de conquistas do aluno</h1><br><br><br>
        <?php
        if (!empty($conquistas)) {
            foreach ($conquistas as $conquista) {
                echo '<div class="row">';
                echo '<div class="col-12">';
                echo '<h5>' . htmlspecialchars($conquista["titulo"]) . '</h5>';
                echo '</div>';
                echo '<div class="col-12">';
                echo '<h6>' . htmlspecialchars($conquista["descricao"]) . '</h6>';
                echo '</div>';
                echo '<div class="col-12">';
                $data_conquista_formatada = date('d/m/Y', strtotime($conquista["data_conquista"]));
                echo '<br>';
                echo '<h6>Alcançada em: ' . $data_conquista_formatada . '</h6>';
                echo '</div>';
                echo '<div class="col-12">';
                echo '<h6>' . htmlspecialchars($conquista["comentario"]) . '</h6>';
                echo '</div>';
                echo '<hr class="linha-horizontal"><br>';
                echo '</div>';
            }
        } else {
            echo '<p>Nenhuma conquista disponível no momento.</p>';
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