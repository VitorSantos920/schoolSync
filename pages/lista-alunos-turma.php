<?php
require_once '../backend/init-configs.php';

if ($_SESSION['categoria'] != "Professor" && $_SESSION['categoria'] != "Administrador") {
    header('Location: ./permissao.php');
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
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/logo_transparente.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/pages__lista-alunos-turma.css?= time() ?>">
    <title><?php echo $classe['nome'] ?> - Lista de Alunos | SchoolSync</title>
</head>

<body>
    <div class="wrapper">
        <div class="content-wrapper">
            <?php
            include_once "../components/header.php";
            include_once "../components/sidebar.php"
            ?>

            <main>
                <p id="cabecalhoListaAluno">Lista de Alunos | Classe: <?php echo $classe['nome'] ?> | <span id="quantidade"></span></p>
                <input type="hidden" name="classe-id" id="classe-id" value="<?php echo $classe_id ?>">

                <div class="my-3">
                    <input class="form-control me-5" name="search" id="search" type="search" placeholder="Pesquisar" aria-label="Search">
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

                    <tbody id="tbody-lista-alunos"></tbody>
                </table>

                <div class="modal fade" id="edtAlunoModal" tabindex="-1" aria-labelledby="edtAlunoModalLabel" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" id="edtAlunoModalLabel">Atualizar Aluno</h1>
                            </div>

                            <div class="modal-body" id="corpo-modal"></div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-success" onclick="editarAluno()">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>

<script src="../assets/js/sweetalert2.all.min.js"></script>
<script src="../assets/js/pages__lista-alunos-turma.js"></script>

</html>