<?php

if (!isset($_POST['nome'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

require_once "../db/config.php";

date_default_timezone_set("America/Sao_Paulo");

session_start();

$professor_id = DB::queryFirstField("SELECT pr.id FROM professor pr WHERE pr.usuario_id = %i", $_SESSION['id']);

try {
  DB::insert("evento", [
    "professor_id" => $professor_id,
    "classe_id" => $_POST['classe'],
    "titulo" => $_POST['nome'],
    "descricao" => $_POST['descricao'],
    "inicio" => $_POST['dataInicio'],
    "termino" => $_POST['dataFim'],
    "status_evento" => "Em breve",
  ]);

  echo json_encode(["status" => 1, "swalMessage" => "O evento '$_POST[nome]' foi agendado com sucesso!"]);
} catch (\Throwable $err) {
  echo json_encode(["status" => -1, "swalMessage" => "Algo deu errado na criação do aluno. Pedimos desculpas pelo transtorno!", "error" => $err]);
}
