<?php
require_once "../db/config.php";
session_start();

date_default_timezone_set('America/Sao_Paulo');

if (!isset($_POST['nome'])) {
  header('Location: ../pages/pagina-inicial-professor.php');
  exit;
}

$admin_id = DB::queryFirstField("SELECT adm.id FROM administrador adm INNER JOIN usuario us ON adm.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$url = $_POST['url'];
$escolaridade = $_POST['escolaridade'];
$tipo = $_POST['tipo'];

try {
  DB::insert("recurso_educacional", [
    "administrador_id" => $admin_id,
    "titulo" => $nome,
    "descricao" => $descricao,
    "url" => $url,
    "escolaridade" => $escolaridade,
    "tipo" => $tipo,
    "created_at" => DB::sqleval("NOW()")
  ]);

  echo json_encode(["status" => 1, "tituloMaterial" => $nome, "message" => "O Recurso Educacional '{$nome}' foi criado com sucesso!"]);
  exit;
} catch (\Throwable $e) {
  echo json_encode(["status" => -1, "swalMessage" => 'Algo deu errado na criação do Recurso Educacional. Tente novamente mais tarde!', "messageError" => "Erro: " . $e]);
  exit;
}
