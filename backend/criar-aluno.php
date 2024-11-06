<?php
require_once "../db/config.php";

date_default_timezone_set('America/Sao_Paulo');

if (!isset($_POST['email'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

$emailExistente = DB::queryFirstField("SELECT COUNT(*) FROM usuario u WHERE u.email = %s", $_POST['email']);

if ($emailExistente > 0) {
  echo json_encode(["status" => 0, "swalMessage" => "Este email já foi cadastrado no sistema. Por favor, insira um email diferente!"]);
  exit;
} else {
  try {
    DB::insert("usuario", [
      "nome" => $_POST['nome'],
      "email" => $_POST['email'],
      "senha" => password_hash($_POST['senha'], PASSWORD_DEFAULT),
      "categoria" => "Aluno",
      "status" => 1,
      "imagem_perfil" => "",
      "cadastrado_em" => DB::sqleval("NOW()")
    ]);

    DB::insert("aluno", [
      "usuario_id" => DB::insertId(),
      "responsavel_id" => $_POST['responsavel'],
      "classe_id" => $_POST['classe'],
      "genero" => $_POST['genero'],
      "escolaridade" => $_POST['escolaridade'],
      "data_nascimento" => $_POST['dataNascimento'],
      "escola" => $_POST['escola']
    ]);

    $quantidadeFilhosAtual = DB::queryFirstField("SELECT quantidade_filho FROM responsavel res WHERE res.id = %i", $_POST['responsavel']);

    DB::update("responsavel", [
      "quantidade_filho" => $quantidadeFilhosAtual + 1,
    ], "id = %i", $_POST['responsavel']);

    echo json_encode(["status" => 1, "swalMessage" => "O aluno '{$_POST['nome']}' foi criado com sucesso!"]);
  } catch (\Throwable $e) {
    echo json_encode(["status" => -1, "swalMessage" => 'Algo deu errado na criação do aluno. Pedimos desculpas pelo transtorno!', "messageError" => "Erro: " . $e]);
  }
}
