<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/pages__cadastro-professor.css">
    <title>Cadastro Professor</title>

</head>

<body>
    <div class="d-flex justify-content-between position-relative">
        <main class="container__left-side">
            <header class="container__header">
                <div>
                    <img src="../assets/img/logo_transparente.png" alt="Logo do SchoolSync, representado por um edifício de uma escola, com uma torre de relógio no meio e uma bandeira no topo.">
                    <h1>SchoolSync</h1>
                </div>

                <h2>Seja bem-vindo professor(a)!</h2>
                <p>Realize seu cadastro preenchendo os campos a seguir, para usufruir dos recursos do SchoolSync!</p>
            </header>
            <form method="post" id="form">
                <fieldset>
                    <label class="form-label" for="nome-professor">Nome</label>
                    <input class="form-control" type="text" name="nome-professor" id="nome-professor" placeholder="Lucas Lima da Silva" required>
                </fieldset>

                <fieldset>
                    <label class="form-label" for="email-professor">Email</label>
                    <input class="form-control" type="text" name="email-professor" id="email-professor" placeholder="email@exemplo.com" required>
                    <div class="exibir-erro"></div>
                </fieldset>

                <fieldset>
                    <label class="form-label" for="senha-professor">Senha</label>
                    <input class="form-control" type="password" name="senha-professor" id="senha-professor" placeholder="*************" minlength="7" maxlength="12" required>
                    <div class="senha-requisitos">
                        <p id="has-number">* 1 número</p>
                        <p id="has-special">* 1 caracter especial</p>
                        <p id="has-uppercase">* 1 letra maiúscula</p>
                    </div>
                    <div class="exibir-erro"></div>
                </fieldset>

                <fieldset>
                    <label for="confirmar-senha" class="form-label">Confirme sua senha</label>
                    <input type="password" name="confirmar-senha" class="form-control" id="confirmar-senha" placeholder="*************" minlength="7" maxlength="12" required>
                    <div class="exibir-erro"></div>
                </fieldset>

                <fieldset>
                    <label class="form-label" for="cpf-professor">CPF</label>
                    <input class="form-control" type="text" name="cpf-professor" id="cpf-professor" placeholder="XXX.XXX.XXX-XX" required>
                </fieldset>

                <button class="btn-schoolsync" type="submit">Realizar Cadastro</button>
            </form>

            <div class="mt-5" id="politica-privacidade">
                <a href="#!">Termos e Condições</a>
                <a href="#!">Política de Privacidade</a>
            </div>
        </main>
        <div class="container__right-side"></div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <script src="../plugins/vanilla-masker.js"></script>
    <script src="../assets/js/pages__cadastro-professor.js"></script>
</body>

</html>