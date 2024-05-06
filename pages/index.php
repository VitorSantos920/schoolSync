<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
    <title>Login SchoolSync</title>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <!-- alt é um atributo que determina o texto que deve aparecer caso a imagem não seja exibida-->
            <img src="../assets/img/logo_transparente.png" alt="SchoolSync" class="logo">
            <p class="logo-text">SchoolSync</p>
            <p class="sub-text">Se você é um aluno, professor ou um responsável e já possui cadastro no sistema, faça seu login abaixo!</p>
            <form method="POST" id="form_login">
                <div class="mt-4">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>
                </div>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required><br><br>

                <button type="submit" onclick="realizar_login()">REALIZAR LOGIN</button>
            </form>
        </div>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <script src="../assets/js/login.js"></script>
</body>

</html>