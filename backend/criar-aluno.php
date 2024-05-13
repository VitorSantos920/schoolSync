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
    "categoria" => "Aluno",
    "imagem_perfil" => "",
    "created_at" => DB::sqleval("NOW()")
  ]);

  DB::insert("aluno", [
    "usuario_id" => DB::insertId(),
    "responsavel_id" => 1,
    "genero" => $_POST['genero'],
    "escolaridade" => $_POST['escolaridade'],
    "data_nascimento" => $_POST['dataNascimento'],
    "classe_id" => 1,
    "status_aluno" => 1,
    "escola" => $_POST['escola']
  ]);

  echo json_encode(["status" => 1, "swalMessage" => "O aluno {$_POST['nome']} foi criado com sucesso!"]);
} catch (\Throwable $e) {
  echo json_encode(["status" => -1, "swalMessage" => 'Algo deu errado na criação do aluno. Tente novamente mais tarde!', "messageError" => "Erro: " . $e]);
}
