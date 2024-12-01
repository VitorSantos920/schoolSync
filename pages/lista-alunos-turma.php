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
                <h1 id="cabecalhoListaAluno">Gerenciamento de Classe - <?= $classe['nome'] ?></h1>
                <ul>
                    <li>Quantidade de Alunos: <span id="quantidade"></span></li>
                    <li>Bimestre Atual: <?= $classe['bimestre_atual']  ?></li>
                    <li>Série (Escolaridade): <?= $classe['serie']  ?></li>
                </ul>
                <input type="hidden" name="bimestre-atual" id="bimestre-atual" value="<?php echo $classe['bimestre_atual'] ?>" disabled>
                <input type="hidden" name="classe-id" id="classe-id" value="<?php echo $classe_id ?>">

                <div class="container-acoes">
                    <div class="btn-secoes">
                        <button class="btn secao-atual" id="botao-lista-alunos" data-secao="lista-alunos" onclick="trocarSecao(this.getAttribute('data-secao'), this.id)">Lista de Alunos</button>
                        <button class="btn" id="botao-notas" data-secao="notas" onclick="trocarSecao(this.getAttribute('data-secao'), this.id)">Notas de Avaliações</button>
                        <button class="btn" id="botao-avaliacoes" data-secao="avaliacoes" onclick="trocarSecao(this.getAttribute('data-secao'), this.id)">Avaliações</button>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-pen-ruler mx-1"></i>
                            Gerenciar Turma
                        </button>
                        <ul class="dropdown-menu">
                            <button class="btn btn-secondary" id="btn-editar-turma" onclick="abrirModalEditarTurma()">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                Editar Turma
                            </button>
                            <button class="btn btn-secondary" id="btn-adicionar-avaliacao" onclick="abrirModalAdicionarAvaliacao()">
                                <i class="fa-solid fa-list-check"></i>
                                Adicionar Avaliação
                            </button>
                            <button class="btn btn-danger" id="btn-fechar-bimeste" onclick="fecharBimestreAtual()">
                                <i class="fa-solid fa-circle-check"></i>
                                Concluir Bimestre
                            </button>
                        </ul>
                    </div>

                </div>

                <section id="lista-alunos">
                    <input class="form-control mb-1" name="search" id="search" type="search" placeholder="Pesquisar" aria-label="Search">
                    <table class="table" id="tabela-lista-alunos">
                        <thead>
                            <tr class="tabelaCabecalho">
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
                </section>

                <section id="notas">

                </section>

                <section id="avaliacoes">
                    <table class="table" id="tabela-avaliacoes-turma">
                        <thead class="tabelaCabecalho">
                            <tr>
                                <th><strong>Título</strong></th>
                                <th><strong>Descrição</strong></th>
                                <th><strong>Matéria</strong></th>
                                <th><strong>Data Prevista</strong></th>
                                <th><strong>Ações</strong></th>
                            </tr>
                        </thead>

                        <tbody class="tabelaCorpo" id="tbody-avaliacoes-turma">
                        </tbody>
                    </table>
                    <?php

                    ?>
                </section>

                <div class="modal fade" id="edtAlunoModal" tabindex="-1" aria-labelledby="edtAlunoModalLabel" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="edtAlunoModalLabel">Editar informações do aluno</h2>
                            </div>

                            <div class="modal-body"></div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-success" onclick="editarAluno()">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="edtTurmaModal" tabindex="-1" aria-labelledby="edtTurmaModalLabel" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="edtTurmaModalLabel">Editar informações da turma</h2>
                            </div>

                            <div class="modal-body" id="corpo-modal"></div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-success" onclick="editarTurma()">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addAvaliacaoModal" tabindex="-1" aria-labelledby="addAvaliacaoModalLabel" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="addAvaliacaoModalLabel">Adicionar avaliação</h2>
                            </div>

                            <div class="modal-body">
                                <form method="POST">
                                    <fieldset>
                                        <label for="representacao-avaliacao" class="form-label">Nome Representativo (Até 5 caracteres)</label>
                                        <input type="text" name="representacao-avaliacao" id="representacao-avaliacao" class="form-control" required placeholder="P1, AV1, ATV1" maxlength="5">
                                    </fieldset>

                                    <fieldset>
                                        <label for="titulo-avaliacao" class="form-label">Título da Avaliação</label>
                                        <input type="text" name="titulo-avaliacao" id="titulo-avaliacao" class="form-control" required placeholder="Prova 1 de Matemática">
                                    </fieldset>

                                    <fieldset>
                                        <label for="descricao-avaliacao" class="form-label">Descrição da Avaliação</label>
                                        <textarea name="descricao-avaliacao" id="descricao-avaliacao" class="form-control" required placeholder="Insira uma descrição para a avaliação..."></textarea>
                                    </fieldset>

                                    <fieldset>
                                        <label for="materia-avaliacao" class="form-label">Selecione a Matéria da Avaliação</label>
                                        <select class="form-control form-select" name="materia-avaliacao" id="materia-avaliacao">
                                            <option value="-1" disabled selected>Selecione uma matéria</option>
                                            <?php
                                            $materias = DB::query('SELECT cm.materia_id, m.nome FROM classe_materia cm INNER JOIN materia m ON cm.materia_id = m.id WHERE classe_id = %i', $classe_id);
                                            foreach ($materias as $materia) {
                                                echo "<option value='{$materia['materia_id']}'>{$materia['nome']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </fieldset>

                                    <fieldset>
                                        <label for="data-prevista" class="form-label">Data de Realização da Avaliação</label>
                                        <input class="form-control" type="datetime-local" name="data-prevista" id="data-prevista">
                                    </fieldset>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-success" onclick="adicionarAvaliacao()">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>

<script src="../assets/js/sweetalert2.all.min.js"></script>

<script src="../assets/js/utils.js"></script>
<script src="../assets/js/pages__lista-alunos-turma.js"></script>



</html>