<?php
require_once("../db/config.php");

session_start();

date_default_timezone_set("America/Sao_Paulo");

$idProfessor = DB::queryFirstField("SELECT id FROM professor WHERE usuario_id = %i", $_SESSION['id']);

if (!isset($_POST['nome'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

try {
  DB::insert("classe", [
    "nome" => $_POST['nome'],
    "serie" => $_POST['escolaridade'],
    "professor_id" => $idProfessor,
    "created_at" => DB::sqleval("NOW()")
  ]);

  echo json_encode(["status" => 1, "swalMessage" => "A turma '{$_POST['nome']}' foi criada com sucesso!"]);
} catch (\Throwable $e) {
  echo json_encode(["status" => -1, "swalMessage" => "Algo deu errado na criação doa turma. Pedimos desculpas pelo transtorno!", "error" => $e]);
}
