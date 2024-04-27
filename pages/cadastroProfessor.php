<?php
require_once '../db/config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/cadastroProfessor.css">  
    <title>Cadastro Professor</title>

</head>

<body>

    <div class="container">
        <div class="row">
            <!--Lado Esquerdo da tela-->
            <div class="col-md-8" id="ladoEsquerdo">
                <div class="d-flex justify-content-center">
                    <img src="../assets/img/imagem_modo_claro.png" class="img-fluid" alt="Imagem">
                </div>

                <div class="mx-auto">
                    <form  id="form_registro" class="forms" method="POST">
                        <p id="cabecalho" >Registre-se, professor!</p>

                        <div class="mt-4">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" id='nome' placeholder="Lucas Lima Silva" required>
                        </div>

                        <div class="mt-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="lucasLima@gmail.com" required>
                        </div>

                        <div class="mt-4">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" id="senha" placeholder="xxxxxxxx" min="6" max="12" required>
                        </div>

                        <div class="mt-4">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" name="cpf" class="form-control" id="cpf" placeholder="123.456.789-10" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" title="111.111.111-11" required>
                            <?php
                                if(isset($_SESSION['erros'][0])){
                                    echo "<p class='erro'>". $_SESSION['erros'][0] ."</p>";
                                    unset($_SESSION['erros']);
                                }
                            ?>
                        </div>

                        <button class="btn mt-4" type="submit" onclick="cadastrar()">Realizar Cadastro</button>
                    </form>
                </div>

                <div class="container mt-5" id="politicaPrivacidade">
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
            <div class="d-flex col-md-4" id="ladoDireito"></div>

        </div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/cadastroProfessor.js"></script>
</body>

</html>