<?php
require_once "../backend/init-configs.php";

if (!isset($_POST['titulo'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

$professor_id = DB::queryFirstField("SELECT pr.id FROM professor pr WHERE pr.usuario_id = %i", $dadosUsuario['id']);
$nome_aluno = DB::queryFirstField("SELECT us.nome FROM aluno al INNER JOIN usuario us ON al.usuario_id = us.id WHERE al.id = %i", $_POST['idAluno']);

try {
  DB::insert("conquista_academica", [
    "aluno_id" => $_POST['idAluno'],
    "professor_id" => $professor_id,
    "titulo" => $_POST['titulo'],
    "descricao" => $_POST['descricao'],
    "data_conquista" => $_POST['data'],
    "comentario" => $_POST['comentarios'],
  ]);

  echo json_encode(["status" => 1, "swalMessage" => "A conquista do aluno \"$nome_aluno\" foi registrada com sucesso!"]);
} catch (\Throwable $err) {
  echo json_encode(["status" => -1, "swalMessage" => "Algo deu errado no registro da conquista do aluno. Pedimos desculpas pelo transtorno!", "error" => $err]);
}
