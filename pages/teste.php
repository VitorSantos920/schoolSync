<?php
    $servername = "15.235.9.101";
    $username = "vfzzdvmy_school_sync";
    $password = "L@QCHw9eKZ7yRxz";
    $database = "vfzzdvmy_school_sync";

    $conn = mysqli_connect($servername, $username, $password, $database);

    $consulta1 = "SELECT * FROM usuario";
    $resultado1 = mysqli_query($conn, $consulta1);
    $fila1 = mysqli_fetch_assoc($resultado1);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESTE</title>
</head>

<body>
    <h1>TESTE</h1>
    <?php 
        // Loop through each row in the result set
        while ($fila1 = mysqli_fetch_assoc($resultado1)) {
            // Output desired column value(s)
            echo "<h1>" . $fila1['nome'] . "</h1>"; // Replace 'nome_do_campo' with the actual column name
        }
    ?>
</body>

</html>
