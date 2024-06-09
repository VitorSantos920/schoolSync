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
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
    <title>Recuperar Senha - SchoolSync</title>
</head>

<body>
    <main class="d-flex align-items-center justify-content-center m-0">
        <div class="login-box">
            <img src="../assets/img/logo_transparente.png" alt="SchoolSync" class="logo">
            <p class="logo-text">SchoolSync</p>
            <p class="esqueceuSenha-text">Recuperar Senha</p>
            <p class="sub-text">Insira seu email abaixo para receber um login temporário dos administradores do sistema.</p>
            <form id="formRecuperarSenha" method="POST" action="../backend/send_reset_email.php">
                <div class="input-box">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="abc@email.com" class="example-login" required>
                        <button id="botaoRedirecionar" type="submit">ENVIAR EMAIL</button>
                    <p class="sub-text">Voltar para <a class="link" href="../pages/index.php">Login</a></p>
                </div>
            </form>
        </div>
    </main>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <script src="../assets/js/login.js"></script>

</body>

</html>
