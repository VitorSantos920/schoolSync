<?php
require_once "../db/config.php";

date_default_timezone_set('America/Sao_Paulo');

if (!isset($_POST['email'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

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
    "quantidade_filho" => 1,
    "status_responsavel" => 1
  ]);

  echo json_encode(["status" => 1, "swalMessage" => "O responsável {$_POST['nome']} foi criado com sucesso!"]);
} catch (\Throwable $e) {
  echo json_encode(["status" => -1, "swalMessage" => 'Algo deu errado na criação do responsável. Tente novamente mais tarde!', "messageError" => "Erro: " . $e]);
}
