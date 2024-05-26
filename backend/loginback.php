<?php

require_once("../db/config.php");

//Verifica se a variável email está setada
if (isset($_POST["email"])) {
    //Pegar a senha digitada pelo usuário e atribuir numa variável
    $senha = $_POST["senha"];
    $verifica_usuario = DB::queryFirstRow("SELECT * FROM usuario WHERE email=%s", $_POST["email"]); //pega todos os dados do usuário do banco

    //usar o método password_verify para comparar a senha digitada com a do banco
    if (isset($verifica_usuario) && password_verify($senha, $verifica_usuario['senha'])) {
        $response = [];
        $response["status"] = 1;

        session_start();

        // Variáveis de sessão
        $_SESSION["id"] = $verifica_usuario["id"];
        $_SESSION["email"] = $verifica_usuario["email"];
        $_SESSION['categoria'] = $verifica_usuario["categoria"];

        $categoria = $verifica_usuario["categoria"];

        // Redirecionamento com base na categoria do usuário
        switch ($categoria) {
            case "Aluno":
                $response["categoria"] = "Aluno";
                $response["link"] = "https://schoolsync.alphi.media/schoolsync/admin/pages/painelAluno.php";
                break;

            case "Professor":
                $response["categoria"] = "Professor";
                $response["link"] = "https://schoolsync.alphi.media/schoolsync/admin/pages/pagina-inicial-professor.php";
                break;

            case "Responsavel":
                $response["categoria"] = "Responsavel";
                $response["link"] = "https://schoolsync.alphi.media/schoolsync/admin/pages/pagina-inicial-responsavel.php";
                break;

            case "Administrador":
                $response["categoria"] = "Administrador";
                $response["link"] = "https://schoolsync.alphi.media/schoolsync/admin/pages/pagina-inicial-administrador.php";
                break;

            default:
                break;
        }

        echo json_encode($response);

        exit;
    } else {

        echo json_encode(["status" => -1, "message" => "Dados inválidos"]);

        exit;
    }
} else {

    //Se o usuario tentar entrar pela url

    header("Location: ../pages/index.php");
}
