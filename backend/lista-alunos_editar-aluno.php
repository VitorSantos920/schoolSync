<?php
require_once "../db/config.php";

date_default_timezone_set("America/Sao_Paulo");

if (!isset($_POST['nome'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

$usuario_id = DB::queryFirstField("SELECT us.id FROM usuario us INNER JOIN aluno al ON us.id = al.usuario_id WHERE al.id = %i", $_POST['idAluno']);

try {
  DB::update("aluno", [
    "genero" => $_POST['genero'],
    "escolaridade" => $_POST['escolaridade'],
    "data_nascimento" => $_POST['dataNascimento'],
    "classe_id" => $_POST['classe'],
    "status_aluno" => $_POST['status'],
    "escola" => $_POST['escola'],
  ], "id = %i", $_POST['idAluno']);

  DB::query("UPDATE usuario SET nome = %s WHERE id = %i", $_POST['nome'], $usuario_id);

  // DB::update("usuario", [
  //   "nome" => $_POST['nome']
  // ], "id=%i", $usuario_id);


  echo json_encode(["status" => 1, "swalMessage" => "Os dados do aluno foram editados com sucesso!"]);
} catch (\Throwable $e) {
  echo json_encode(["status" => -1, "swalMessage" => "Algo deu errado na edição do aluno. Pedimos desculpas pelo transtorno!", "error" => $e]);
}
