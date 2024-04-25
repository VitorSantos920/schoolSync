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

    <style>

    #cabecalhoListaAluno{
        font-size: var(--fontSize-2xl);
        font-family: var(--fontFamily-poppins);
        font-weight: var(--fontWeight-bold);
    }

    #search{
        border-radius: var(--borderRadius-xs);
        font-family: var(--fontFamily-roboto);
        font-weight: var(--fontWeight-regular);
    }

    #tabelaCabecalho{
        font-size: var(--fontSize-md);
        font-family: var(--fontFamily-poppins);
        font-weight: var(--fontWeight-bold);
    }

    #tabelaCorpo{
        font-size: var(--fontSize-sm);
        font-family: var(--fontFamily-roboto);
        font-weight: var(--fontWeight-regular);
    }

    .dropdown #btnPrincipal{
        font-size: var(--fontSize-xs);
        font-family: var(--fontFamily-poppins);
        font-weight: var(--fontWeight-regular);
        border-radius: var(--borderRadius-xs);
    }

    .dropdown .dropdown-menu{
        box-shadow: var(--boxShadow-base);
    }

    .dropdown .dropdown-menu .dropdown-item{
        font-size: var(--fontSize-xxs);
        font-family: var(--fontFamily-poppins);
        font-weight: var(--fontWeight-regular);
        border-radius: var(--borderRadius-xs);
    }

    .dropdown .dropdown-menu #deletar{
        background-color: var(--danger-default);
    }

</style>

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
                    <?php if($aluno['status_aluno'] == 1): ?>
                        <td>&#128994;</td>
                    <?php else: ?>
                        <td>&#128308;</td>
                    <?php endif; ?>
                    <td><?php echo $user['created_at'] ?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" id="btnPrincipal" type="button" data-bs-toggle='dropdown' aria-expanded="false">
                                Lista de Ações
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Acessar Perfil</a></li>
                                <li><a class="dropdown-item" href="#">Ver Detalhes</a></li>
                                <li><a class="dropdown-item" href="#">Editar Aluno</a></li>
                                <li><a class="dropdown-item" id="deletarAluno" href="#">Deletar Aluno</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>