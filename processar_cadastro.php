<?php

require_once 'db/config.php';

date_default_timezone_set('America/Sao_Paulo');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    DB::insert('usuario',[
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'senha' => $_POST['senha'],
        'categoria' => 'Professor',
        'created_at' => date('Y-m-d H:i:s')
    ]);

    $usuario_id = DB::queryFirstField('select id from usuario where nome=%s and email=%s', $_POST['nome'], $_POST['email']); 
    DB::insert('professor',[
        'cpf' => $_POST['cpf'],
        'usuario_id' => $usuario_id
    ]);

    $user = DB::query('select * from professor where usuario_id=%i', $usuario_id);

    session_start();
    $_SESSION['dados'] = $user;
    header('Location: pages/pagina-inicial-professor.php');
    exit;
}else{
    header('Location: pages/cadastroProfessor.php');
    exit;
}


?>