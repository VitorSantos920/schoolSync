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
  try {
    DB::insert("usuario", [
      "nome" => $_POST['nome'],
      "email" => $_POST['email'],
      "senha" => password_hash($_POST['senha'], PASSWORD_DEFAULT),
      "categoria" => "Responsavel",
      "imagem_perfil" => "",
      "created_at" => DB::sqleval("NOW()")
    ]);

    DB::insert("responsavel", [
      "usuario_id" => DB::insertId(),
      "cpf" => $_POST['cpf'],
      "telefone" => $_POST['telefone'],
      "quantidade_filho" => 0,
      "status_responsavel" => 1
    ]);

    echo json_encode(["status" => 1, "swalMessage" => "O responsável {$_POST['nome']} foi criado com sucesso!"]);
  } catch (\Throwable $e) {

    echo json_encode(["status" => -1, "swalMessage" => 'Algo deu errado na criação do responsável. Tente novamente mais tarde!', "messageError" => "Erro: " . $e]);
  }
}
