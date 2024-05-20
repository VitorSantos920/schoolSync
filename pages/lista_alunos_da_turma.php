<?php
require_once '../db/config.php';

session_start();

if (!isset($_SESSION['id']) || ($_SESSION['categoria'] != "Professor" && $_SESSION['categoria'] != "Administrador")) {
    header('Location: ../pages/permissao.php');
    exit;
}

if (!isset($_GET['turma_id'])) {
    header('Location: ./pagina-inicial-professor.php');
    exit;
}

$classe_id = $_GET['turma_id'];

$classe = DB::queryFirstRow('SELECT * FROM classe WHERE id = %i', $classe_id);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="icon" href="../assets/img/logo_transparente.png">
    <link rel="stylesheet" href="../assets/css/lista_alunos_da_turma.css?<?= time() ?>">
    <title>Lista de Alunos da Turma</title>
</head>

<body>
    <?php
    require '../components/sidebar.php';
    ?>

    <main>
        <div class="d-flex justify-content-start ms-3 mt-5">
            <p id="cabecalhoListaAluno">Lista de Alunos | Classe: <?php echo $classe['nome'] ?> | <span id="quantidade"><?php echo $quantidadeAlunos ?></span> Alunos</p>
            <input type="hidden" name="classe-id" id="classe-id" value="<?php echo $classe_id ?>">
        </div>

        <div class="d-flex justify-content-start mt-3 ms-3">
            <form role="search">
                <input class="form-control me-5" name="search" id="search" type="search" placeholder="Pesquisar" aria-label="Search">
            </form>
        </div>

        <table class="table" id="tabela-lista-alunos">
            <thead>
                <tr id="tabelaCabecalho">
                    <th><strong>Nome Completo</strong></th>
                    <th><strong>Responsável</strong></th>
                    <th><strong>Email do Responsável</strong></th>
                    <th><strong>Data de Criação</strong></th>
                    <th><strong>Status</strong></th>
                    <th><strong>Ações</strong></th>
                </tr>
            </thead>
            <tbody id="tbody-lista-alunos">

            </tbody>
        </table>
        <!-- Fim da Tabela de Alunos -->

        <!-- Modal Atualização de Aluno-->
        <div class="modal fade" id="edtAlunoModal" tabindex="-1" aria-labelledby="edtAlunoModalLabel" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="edtAlunoModalLabel">Atualizar Aluno</h1>
                    </div>

                    <div class="modal-body" id="corpo-modal">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success" onclick="editarAluno()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim do Modal de Atualização de Aluno -->
    </main>
</body>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../assets/js/sweetalert2.all.min.js"></script>
<script src="https://kit.fontawesome.com/4ac8bcd2f5.js" crossorigin="anonymous"></script>
<script src="../assets/js/pages__lista-alunos-turma.js"></script>

</html>