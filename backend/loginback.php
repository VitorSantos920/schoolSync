<?php
    require_once("../db/config.php");

    //Verifica se a variável email está setada
    if(isset($_POST["email"])){
        $verifica_email = DB::queryFirstRow("SELECT * FROM usuario WHERE email=%s", $_POST["email"]);
        if(isset($verifica_email) && $_POST["senha"]==$verifica_email["senha"]){
            $response = [];
            $response["status"] = 1;
            //$response["categoria"] = $verifica_email["categoria"];
            session_start();
            $_SESSION["id"] = $verifica_email["id"];
            $_SESSION["email"] = $verifica_email["email"];
            $categoria = $verifica_email["categoria"];
            // Redirecionamento com base na categoria do usuário
            switch ($categoria) {
                case "Aluno":
                    $response["categoria"] = "Aluno";
                    $response["link"] = "http://localhost/schoolSync/pages/painelAluno.php";
                    break;
                case "Professor":
                    $response["categoria"] = "Professor";  
                    $response["link"] = "http://localhost/schoolSync/pages/pagina-inicial-professor.php";
                    break;
                case "Responsavel":
                    $response["categoria"] = "Responsavel"; 
                    $response["link"] = "http://localhost/schoolSync/pages/painelAluno.php";
                    break;
                case "Administrador":
                    $response["categoria"] = "Administrador";
                    $response["link"] = "http://localhost/schoolSync/pages/index.php";
                    break;
                default:
                    // Categoria inválida, redirecionar para uma página de erro
                    break;
            }
            echo json_encode($response);
            exit;
        }else{
            echo json_encode(["status" => -1, "message" => "Dados inválidos"]);
            exit;
        }
    }else{
        //Se o usuario tentar entrar pela url
        header("Location: ../pages/index.php");
    }
?>
