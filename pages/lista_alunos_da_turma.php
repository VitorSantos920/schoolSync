<?php
require_once '../db/config.php';

$alunos = DB::query('select * from aluno');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/lista_alunos_da_turma.css">

    <title>Cadastro Professor</title>

</head>

<body>
    <div class="d-flex justify-content-start ms-3 mt-5">
        <p id="cabecalhoListaAluno">Lista de Alunos do ano - Alunos</p>
    </div>

    <div class="d-flex justify-content-start mt-3 ms-3">
        <form role="search">
            <input class="form-control me-5" name="search" id="search" type="search" placeholder="Pesquisar" aria-label="Search">
        </form>
    </div>

    <table class="table mt-3 ms-3">
        <thead>
            <tr id="tabelaCabecalho">
                <th><strong>ID</strong></th>
                <th><strong>Nome Completo</strong></th>
                <th><strong>Responsável</strong></th>
                <th><strong>E-mail do Responsável</strong></th>
                <th><strong>Data de Criação</strong></th>
                <th><strong>Status</strong></th>
                <th><strong>Ações</strong></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunos as $aluno) : ?>
                <?php

                $user = DB::queryFirstRow('select * from usuario where id=%i', $aluno['usuario_id']);
                $responsavel = DB::queryFirstRow('select * from responsavel where id=%i', $aluno['responsavel_id']);
                $user_responsavel = DB::queryFirstRow('select nome, email from usuario where id=%i', $responsavel['usuario_id']);
                ?>
                <tr id="tabelaCorpo">
                    <td><?php echo $aluno['id'] ?></td>
                    <td><?php echo $user['nome'] ?></td>
                    <td><?php echo $user_responsavel['nome'] ?></td>
                    <td><?php echo $user_responsavel['email'] ?></td>
                    <td><?php echo $user['created_at'] ?></td>
                    <?php if ($aluno['status_aluno'] == 1) : ?>
                        <td>&#128994;</td>
                    <?php else : ?>
                        <td>&#128308;</td>
                    <?php endif; ?>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" id="btnPrincipal" type="button" data-bs-toggle='dropdown' aria-expanded="false">
                                Lista de Ações
                            </button>

                            <form action="../backend/processar_lista_aluno.php" method="POST">
                                <ul class="dropdown-menu">
                                    <input type="hidden" name="id_aluno" value="<?php echo $aluno['id']; ?>">
                                    <input type="hidden" name="id_professor" value="<?php echo $aluno['id']; ?>">
                                    <button class="btn" name="action" value="acessar_perfil_aluno"><i class="fa-solid fa-user icone"></i>Acessar Perfil</button>
                                    <button class="btn" name="action" value="detalhes"><i class="fa-solid fa-folder icone"></i>Ver Detalhes</button>
                                    <button type="button" class="btn" name="action" value="edt_aluno" data-bs-toggle="modal" data-bs-target="#edtAlunoModal"><i class="fa-solid fa-pen icone"></i>Editar Aluno</button>
                                    <button class="btn" id="deletarAluno" name="action" value="deletar_aluno"><i class="fa-solid fa-trash icone"></i>Deletar Aluno</button>
                                </ul>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal Atualização de Aluno-->
    <div class="modal fade" id="edtAlunoModal" tabindex="-1" aria-labelledby="edtAlunoModalLabel" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../backend/processar_lista_aluno.php" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="edtAlunoModalLabel">Atualizar Aluno</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" name="nome" value="<?php echo $user['nome']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                    <input type="text" class="form-control" name="data_nascimento" value="<?php echo $aluno['data_nascimento']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="escolaridade" class="form-label">Escolaridade</label>
                                    <input type="text" class="form-control" name="escolaridade" value="<?php echo $aluno['escolaridade']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="classe" class="form-label">Classe</label>
                                    <input type="text" class="form-control" name="classe" value="<?php echo $aluno['classe_id']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="escola" class="form-label">Escola</label>
                                    <input type="text" class="form-control" name="escola" value="<?php echo $aluno['escola']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status do Aluno</label>
                                    <select class="form-select" name="status">
                                        <option value="ativo" selected>Ativo</option>
                                        <option value="inativo">Inativo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="genero" class="form-label">Gênero do Aluno</label>
                            <select class="form-select" name="genero">
                                <option value="Feminino" selected>Feminino</option>
                                <option value="Masculino">Masculino</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_aluno" value="<?php echo $aluno['id']; ?>">
                        <input type="hidden" name="id_professor" value="<?php echo $aluno['id']; ?>">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success" name="action" value="salvar">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

<script src="https://kit.fontawesome.com/4ac8bcd2f5.js" crossorigin="anonymous"></script>

</html>