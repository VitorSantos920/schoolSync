<?php

require_once "../backend/init-configs.php";

if (!isset($_POST['nome'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

// $professorId = DB::queryFirstField("SELECT pro.id FROM professor pro INNER JOIN usuario us ON pro.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);
$professorId = DB::queryFirstField("SELECT id FROM professor WHERE usuario_id = %i", $_SESSION['id']);
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$url = $_POST['url'];
$escolaridade = $_POST['escolaridade'];
$tipo = $_POST['tipo'];

try {
  DB::insert("recurso_educacional", [
    "professor_id" => $professorId,
    "titulo" => $nome,
    "descricao" => $descricao,
    "url" => $url,
    "escolaridade" => $escolaridade,
    "tipo" => $tipo,
    "criado_em" => DB::sqleval("NOW()")
  ]);

  echo json_encode(["status" => 1, "tituloMaterial" => $nome, "message" => "O Recurso Educacional '{$nome}' foi criado com sucesso!"]);
  exit;
} catch (\Throwable $e) {
  echo json_encode(["status" => -1, "swalMessage" => 'Algo deu errado na criação do Recurso Educacional. Tente novamente mais tarde!', "messageError" => "Erro: " . $e]);
  exit;
}
