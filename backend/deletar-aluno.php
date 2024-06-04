<?php
if (!isset($_POST['idAluno'])) {
  header('Locatio: ../pages/permissao.php');
  exit;
}

require_once "../db/config.php";

try {

  $nomeAluno = DB::queryFirstField("SELECT us.nome FROM aluno al INNER JOIN usuario us ON al.usuario_id = us.id WHERE al.id = %i", $_POST['idAluno']);

  $responsavelAluno = DB::queryFirstRow("SELECT res.id, res.quantidade_filho FROM aluno al INNER JOIN responsavel res ON al.responsavel_id = res.id WHERE al.id = %i", $_POST['idAluno']);

  DB::update("aluno", [
    "status_aluno" => 0
  ], "id = %i", $_POST['idAluno']);

  echo json_encode(["status" => 1, "swalMessage" => "O(A) aluno(a) '{$nomeAluno}' foi excluído(a) com sucesso!"]);
} catch (\Throwable $err) {
  echo json_encode(["status" => -1, "swalMessage" => "Ocorreu um erro interno ao deletar o aluno. Pedimos desculpas pelo transtorno!", "error" => $err]);
}
