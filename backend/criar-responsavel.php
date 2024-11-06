<?php

require_once "../db/config.php";

date_default_timezone_set('America/Sao_Paulo');

if (!isset($_POST['email'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

function dadoExistente($dado)
{
  echo json_encode(["status" => 0, "swalMessage" => "Este {$dado} já foi cadastrado no sistema. Por favor, insira um {$dado} diferente!"]);
  exit;
}

$emailExistente = DB::queryFirstField("SELECT COUNT(*) FROM usuario u WHERE u.email = %s", $_POST['email']);

$cpfExistente = DB::queryFirstField("SELECT COUNT(*) FROM responsavel res WHERE res.cpf = %s", $_POST['cpf']);

if ($emailExistente > 0) {
  dadoExistente('email');
} else if ($cpfExistente > 0) {
  dadoExistente('CPF');
} else {
  $nome = htmlspecialchars($_POST['nome'], ENT_NOQUOTES);
  $email = htmlspecialchars($_POST['email']);

  try {
    DB::insert("usuario", [
      "nome" => $nome,
      "email" => $email,
      "senha" => password_hash($_POST['senha'], PASSWORD_DEFAULT),
      "categoria" => "Responsável",
      "status" => 1,
      "imagem_perfil" => "",
      "cadastrado_em" => DB::sqleval("NOW()")
    ]);

    DB::insert("responsavel", [
      "usuario_id" => DB::insertId(),
      "telefone" => $_POST['telefone'],
      "cpf" => $_POST['cpf'],
      "quantidade_filho" => 0,
    ]);

    echo json_encode(["status" => 1, "swalMessage" => "O(A) responsável {$_POST['nome']} foi criado(a) com sucesso!"]);
  } catch (\Throwable $e) {
    echo json_encode(["status" => -1, "swalMessage" => 'Algo deu errado na criação do responsável. Tente novamente mais tarde!', "messageError" => "Erro: " . $e]);
  }
}
