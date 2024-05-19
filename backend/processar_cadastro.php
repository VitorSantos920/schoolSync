<?php

require_once '../db/config.php';

date_default_timezone_set('America/Sao_Paulo');

if (isset($_POST['email'])) {
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
        $erros["emailInvalido"] = 'Email inválido';
    }

    //Verifica se o email existe
    $emailExiste = false;
    $emailExiste = DB::queryFirstRow('select * from usuario where email=%s', $email);

    $cpfExiste = false;
    $cpfExiste = DB::queryFirstRow('select * from professor where cpf=%s', $cpf);

    if ($cpfExiste != false) {
        $erros["cpfEmUso"] = 'O cpf já está em uso';
    }

    if ($emailExiste != false) {
        $erros["emailEmUso"] = 'O email já está em uso';
    }

    if (empty($erros)) {
        try {

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
                'usuario_id' => $usuario_id,
                'status_professor' => 1
            ]);

            $user = DB::query('select * from professor where usuario_id=%i', $usuarwwio_id);

            session_start();

            $_SESSION["id"] = $usuario_id;
            $_SESSION["email"] = $email;
            $_SESSION['categoria'] = "Professor";


            $response = ["status" => 1, "message" => "O professor '{$nome}' foi cadastrado com sucesso. Redirecionando à sua página inicial de professor...", "url" => "https://schoolsync.alphi.media/schoolsync/admin/pages/pagina-inicial-professor.php"];
            echo json_encode($response);
        } catch (\Throwable $e) {
            echo json_encode(["status" => 0, "error" => $e, "swalMessage" => "Ocorreu um erro interno ao realizar o cadastro do professor. Desculpe o transtorno!"]);
        }


        exit;
    }

    // $_SESSION['erros'] = $erros;
    $erros["status"] = -1;
    echo json_encode($erros);
    // header('Location: /schoolSync/pages/cadastroProfessor.php');

    exit;
} else {
    header('Location: ../pages/permissao.php');
    exit;
}
