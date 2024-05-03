<?php
require_once '../db/config.php';

session_start();
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

    <?php
    //require '../components/sidebar.php';
    ?>

    <div class="container">
        <div class="row">
            <!--Lado Esquerdo da tela-->
            <div class="col-md-8" id="ladoEsquerdo">
                <div class="d-flex justify-content-center">
                    <img src="../assets/img/imagem_modo_claro.png" class="img-fluid" alt="Imagem">
                </div>

                <div class="mx-auto">
                    <form class="forms" action='../backend/processar_cadastro.php' method="POST">
                        <p id="cabecalho">Registre-se, professor!</p>

                        <div class="mt-4">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" placeholder="Lucas Lima Silva" required>
                        </div>

                        <div class="mt-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="lucasLima@gmail.com" required>
                            <div class="exibir-erro">
                                <?php
                                if (isset($_SESSION['erros'][1]) && isset($_SESSION['erros'][3])) {
                                    echo "<div class='erro'>" . $_SESSION['erros'][1] . $_SESSION['erros'][3] . "</div>";
                                    unset($_SESSION['erros'][1]);
                                    unset($_SESSION['erros'][3]);
                                } else if (isset($_SESSION['erros'][3])) {
                                    echo "<div class='erro'>" . $_SESSION['erros'][3] . "</div>";
                                    unset($_SESSION['erros'][3]);
                                } else if (isset($_SESSION['erros'][1])) {
                                    echo "<div class='erro'>" . $_SESSION['erros'][1] . "</div>";
                                    unset($_SESSION['erros'][1]);
                                }
                                ?>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" placeholder="xxxxxxxx" min="6" max="12" required>
                        </div>

                        <div class="mt-4">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" name="cpf" class="form-control" placeholder="123.456.789-10" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" title="111.111.111-11" required>
                            <div class="exibir-erro">
                                <?php
                                    if (isset($_SESSION['erros'][0])) {
                                        echo "<div class='erro'>" . $_SESSION['erros'][0] . "</div>";
                                        unset($_SESSION['erros'][0]);
                                    }
                                ?>
                            </div>
                        </div>

                        <button class="btn mt-4" type="submit">Realizar Cadastro</button>
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

</body>

</html>