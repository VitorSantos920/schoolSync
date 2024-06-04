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

// Consulta para obter a escolaridade do aluno
$sqlAluno = "SELECT escolaridade FROM aluno WHERE id=$aluno_id";
$resultadoAluno = mysqli_query($conn, $sqlAluno);

if (!$resultadoAluno) {
    die("Erro na consulta de aluno: " . mysqli_error($conn));
}

$filaAluno = mysqli_fetch_assoc($resultadoAluno);
$escolaridade = $filaAluno['escolaridade'];

// Consulta para obter as matérias do aluno
$sql = "SELECT * FROM materia WHERE serie=$escolaridade";
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Erro na consulta de matéria: " . mysqli_error($conn));
}

$materias = [];
while ($filaMateria = mysqli_fetch_assoc($resultado)) {
    $materias[] = $filaMateria;
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
    <title>Gerenciamento do aluno</title>
</head>

<body>
    <?php
    require '../components/sidebarProfessor.php';
    ?>

    <main>
        <h1>Lista de matérias do aluno</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Matéria</th>
                    <th>Quantidade de Aulas</th>
                    <th>Série</th>
                    <th>Adicionar Faltas/Notas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materias as $materia) : ?>
                    <tr>
                        <td><?php echo $materia['id']; ?></td>
                        <td><?php echo $materia['disciplina']; ?></td>
                        <td><?php echo $materia['quantidade_aula']; ?></td>
                        <td><?php echo $materia['serie']; ?></td>
                        <td><button><a href="../pages/gerenciarAlunoNF.php?aluno_id=<?php echo $aluno_id; ?>&materia_id=<?php echo $materia['id']; ?>"><i class="fa-solid fa-square-poll-vertical"></i> Controle</a></button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../assets/js/sweetalert2.all.min.js"></script>
<script src="https://kit.fontawesome.com/4ac8bcd2f5.js" crossorigin="anonymous"></script>
<script src="../assets/js/pages__lista-alunos-turma.js"></script>

</html>