<?php

require_once '../db/config.php';

date_default_timezone_set('America/Sao_Paulo');

session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Pegar os dados recebido pelo input
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];

    //Sanitizar os dados 
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $senha = preg_replace('[^a-zA-Z0-9@#]', '', $senha);
    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    $erros = [];

    //Validar o email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'Email inválido';
    }

    //Verifica se o email existe
    $emailExiste = false;
    $emailExiste = DB::queryFirstRow('select * from usuario where email=%s', $email);

    $cpfExiste = false;
    $cpfExiste = DB::queryFirstRow('select * from professor where cpf=%s', $cpf);

    if ($cpfExiste != false) {
        $erros[0] = 'O cpf já está em uso';
    }

    if ($emailExiste != false) {
        $erros[1] = 'O email já está em uso';
    }

    if (empty($erros)) {
        DB::insert('usuario', [
            'nome' => $nome,
            'email' => $email,
            'senha' => $senhaCriptografada,
            'categoria' => 'Professor',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $usuario_id = DB::insertId();

        DB::insert('professor', [
            'cpf' => $cpf,
            'usuario_id' => $usuario_id
        ]);

        $user = DB::query('select * from professor where usuario_id=%i', $usuario_id);

        $_SESSION['dados'] = $user;
        header('Location: pages/pagina-inicial-professor.php');
        exit;
    }
    $_SESSION['erros'] = $erros;
    echo var_dump($_SESSION['erros']);
    exit;
    header('Location: /School_sync/pages/cadastroProfessor.php');
    exit;
} else {
    header('Location: /School_sync/pages/cadastroProfessor.php');
    exit;
}

?>
