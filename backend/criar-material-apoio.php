<?php
require_once "../db/config.php";

date_default_timezone_set('America/Sao_Paulo');

if (!isset($_POST['nome'])) {
  header('Location: ../pages/pagina-inicial-professor.php');
  exit;
}

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$url = $_POST['url'];
$escolaridade = $_POST['escolaridade'];
$tipo = $_POST['tipo'];

try {
  DB::insert("recurs_educacional", [
    "administrador_id" => 2,
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
