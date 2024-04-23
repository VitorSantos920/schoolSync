<?php
require_once 'db/config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/global.css">
    <title>Cadastro Professor</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <!--Lado Esquerdo da tela-->
            <div class="col-md-8">
                <div class="d-flex justify-content-center">
                    <img src="assets/img/logo_modo_claro.png" class="img-fluid" alt="Imagem">

                </div>

                <div class="mx-auto">
                    <form action='processar_cadastro.php' method="POST">
                        <h5>Registre-se, professor!</h5>

                        <div class="mt-4">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" placeholder="Lucas Lima Silva" required>
                        </div>

                        <div class="mt-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="lucasLima@gmail.com" required>
                        </div>

                        <div class="mt-4">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" placeholder="xxxxxxxx" required>
                        </div>

                        <div class="mt-4">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" name="cpf" class="form-control" placeholder="123.456.789-10" required>
                        </div>

                        <button class="btn mt-4" type="submit" style="box-shadow: var(--boxShadow-base); background-color: var(--brand-color); color:white">Realizar Cadastro</button>
                    </form>
                </div>

                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Termos e Condições</p>
                        </div>
                        <div class="col-md-6">
                            <p>Política de Privacidade</p>
                        </div>
                    </div>
                </div>

            </div>
            <!--Lado Direito da tela-->
            <div class="d-flex col-md-4 justify-content-end" style="background-color: var(--brand-color);"></div>

        </div>
    </div>

</body>

</html>