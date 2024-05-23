<?php

$servername = "15.235.9.101";

$username = "vfzzdvmy_school_sync";

$password = "L@QCHw9eKZ7yRxz";

$database = "vfzzdvmy_school_sync";

$conn = mysqli_connect($servername, $username, $password, $database);


$aluno_id = $_GET['aluno_id'];

$consultaSerie = "SELECT escolaridade FROM aluno WHERE id=$aluno_id";

$resultadoSerie = mysqli_query($conn, $consultaSerie);

$filaSerie = mysqli_fetch_assoc($resultadoSerie);

?>

<body>
    <?php
    require '../components/sidebarProfessor.php';
    ?>