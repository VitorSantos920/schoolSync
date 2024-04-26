<?php

require_once 'db/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    session_start();

    $_SESSION['dados'] = array(
        'id_aluno' => $_POST['id_aluno'],
        'id_professor' => $_POST['id_professor'],
    );

    if ($_POST['action'] == 'acessar_perfil_aluno') {
        header('Location: painelAlunoProfessor.php');
        exit;
    } elseif ($_POST['action'] == 'detalhes') {
        header('Location: painelAluno.php');
        exit;
    } elseif ($_POST['action'] == 'edt_aluno') {
        echo 'edt';
    } elseif ($_POST['action'] == 'deletar_aluno') {
        //DB::delete('aluno', 'id=%i', $_POST['id_aluno']);
        header('Location:  lista_alunos_da_turma.php');
        exit;
    }
} 

?>
