<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/variables.css">
    <title>Login SchoolSync</title>

    <style>

        .logo-text{
            font-size: var(--fontSize-5xl);
            font-family: var(--fontFamily-poppins);
            font-weight: var(--fontWeight-bold);
            color: var(--brand-color);
        }

        .sub-text{
            font-size: var(--fontSize-sm);
            font-family: var(--fontFamily-roboto);
            font-weight: var(--fontWeight-regular);
            color: var(--level-gray500);
        }

        .lembrar-de-mim {
            font-size: var(--fontSize-sm);
            font-family: var(--fontFamily-poppins);
            font-weight: var(--fontWeight-regular);
        }

    </style>
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


                <input type="checkbox" id="lembrar-login" name="lembrar-login">
                <label for="lembrar-login">Lembrar login</label><br><br>
                
                <button type="submit" onclick="realizar_login()">REALIZAR LOGIN</button>
            </form>
        </div>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/login.js"></script>
</body>
</html>
