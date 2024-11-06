<?php
include_once "../db/config.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/login.css?<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
    <title>Login SchoolSync</title>
</head>

<body>
    <main class="d-flex align-items-center justify-content-center m-0">
        <div class="container">
            <img src="../assets/img/boy_login.png" alt="Aluno" class="boy-image">

            <img src="../assets/img/logo_transparente.png" alt="Logo do SchoolSync, representado por um edifício de uma escola, com uma torre de relógio no meio e uma bandeira no topo." class="logo">
            <p class="logo-text">SchoolSync</p>
            <p class="sub-text">Se você é um aluno, professor ou um responsável e já possui cadastro no sistema, faça seu login abaixo!</p>
            <form method="POST" id="form_login">
                <fieldset>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="email@exemplo.com" class="form-control" required>
                </fieldset>

                <fieldset>
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="************" class="form-control" required>
                </fieldset>

                <button type="submit" class="btn-schoolsync" onclick="realizarLogin()">Realizar login</button>

            </form>
            <p class="sub-text">É um professor e ainda não possui cadastro? <a class="link" href="./cadastro-professor.php">Crie uma conta!</a></p>
        </div>
    </main>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <script src="../assets/js/login.js"></script>
</body>

</html>