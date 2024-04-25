<?php
require_once '../db/config.php';

$alunos = DB::query('select * from aluno');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/global.css">
    <title>Cadastro Professor</title>
</head>

<body>
    <div class="d-flex justify-content-start ms-3 mt-5">
        <h3>Lista de Alunos do ano - Alunos</h3>
    </div>

    <div class="d-flex justify-content-start mt-3 ms-3">
        <form role="search">
            <input class="form-control me-5" name="search" type="search" placeholder="Pesquisar" aria-label="Search">
        </form>
    </div>

    <table class="table mt-3 ms-3">
        <thead>
            <tr>
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

                    $user = DB::query('select * from usuario where id=%i', $aluno['usuario_id']);
                    $responsavel = DB::query('select nome, email from usuario where id=%i', $aluno['responsavel_id']);
                ?>
                <tr>
                    <td><?php echo $aluno['id'] ?></td>
                    <td><?php echo $user['nome'] ?></td>
                    <td><?php echo $responsavel['nome'] ?></td>
                    <td><?php echo $responsavel['email'] ?></td>
                    <td><?php echo $user['created_at'] ?></td>
                    <td><?php echo $user['status'] ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Lista de Ações
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Acessar Perfil</a></li>
                                <li><a class="dropdown-item" href="#">Ver Detalhes</a></li>
                                <li><a class="dropdown-item" href="#">Ver Detalhes</a></li>
                                <li><a class="dropdown-item" href="#">Editar Aluno</a></li>
                                <li><a class="dropdown-item" href="#">Deletar Aluno</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>