<?php
if (!isset($_POST['idAluno'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

require_once "../db/config.php";

try {
  $nomeAluno = DB::queryFirstField("SELECT us.nome FROM aluno al INNER JOIN usuario us ON al.usuario_id = us.id WHERE al.id = %i", $_POST['idAluno']);

  $responsavelAluno = DB::queryFirstRow("SELECT res.id, res.quantidade_filho FROM aluno al INNER JOIN responsavel res ON al.responsavel_id = res.id WHERE al.id = %i", $_POST['idAluno']);

  $idUsuarioAluno = DB::queryFirstField("SELECT usuario_id FROM aluno WHERE id = %i", $_POST['idAluno']);

  DB::update("usuario", [
    "status" => 0
  ], "id = %i", $idUsuarioAluno);

  DB::update("responsavel", [
    "quantidade_filho" => $responsavelAluno['quantidade_filho'] - 1
  ], "id = %i", $responsavelAluno['id']);

  echo json_encode(["status" => 1, "swalMessage" => "O(A) aluno(a) '{$nomeAluno}' foi excluído(a) com sucesso!"]);
} catch (\Throwable $err) {
  echo json_encode(["status" => -1, "swalMessage" => "Ocorreu um erro interno ao deletar o aluno. Pedimos desculpas pelo transtorno!", "error" => $err]);
}
