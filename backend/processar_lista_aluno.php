<?php

require_once '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    session_start();

    $_SESSION['dados'] = array(
        'id_aluno' => $_POST['id_aluno'],
        'id_professor' => $_POST['id_professor'],
        'classe_id' => $_POST['turma_id']
    );

    if ($_POST['action'] == 'acessar_perfil_aluno') {
        header('Location: /schoolSync/pages/painelAlunoProfessor.php');
        exit;
    } elseif ($_POST['action'] == 'detalhes') {
        header('Location: /schoolSync/pages/painelAluno.php');
        exit;
    } elseif ($_POST['action'] == 'salvar') {
        $aluno = DB::queryFirstRow('select * from aluno where id=%i',$_SESSION['id_aluno']);
        $user = DB::queryFirstRow('select * from usuario where id=%i', $aluno['usuario_id']);

        DB::update('usuario', ['nome' => $_POST['nome']], 'id=%i', $user['id']);
        DB::update('aluno', ['data_nascimento' => $_POST['data_nascimento'], 'escolaridade' => $_POST['escolaridade'], 
                    'escola' => $_POST['escola'], 'genero' => $_POST['genero']], 'id=%i', $aluno['id']);
        if($_POST['status'] == 'ativo'){
            DB::update('aluno', ['status_aluno' => 1], 'id=%i', $aluno['id']);
        }else if($_POST['status'] == 'inativo'){
            DB::update('aluno', ['status_aluno' => 0], 'id=%i', $aluno['id']);
        }

        header('Location: /schoolSync/pages/lista_alunos_da_turma.php');
        exit;
    } elseif ($_POST['action'] == 'deletar_aluno') {
        DB::delete('aluno', 'id=%i', $_SESSION['id_aluno']);
        header('Location:  /schoolSync/pages/lista_alunos_da_turma.php');
        exit;
    }
} 

?>
