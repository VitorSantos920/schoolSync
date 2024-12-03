<?php
require_once("../backend/init-configs.php");

if (!isset($_POST['idAvaliacao'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

try {
  DB::update(
    "avaliacao",
    [
      "representacao" => $_POST['representacaoAvaliacao'],
      "titulo" => $_POST['tituloAvaliacao'],
      "descricao" => $_POST['descricaoAvaliacao'],
      "materia_id" => $_POST['materiaAvaliacao'],
      "data_prevista" => $_POST['dataPrevista']
    ],
    "id = %i",
    $_POST['idAvaliacao']

  );

  if (DB::affectedRows() > 0) {
    echo json_encode(["status" => 1, "swalMessage" => "Avaliação foi editada com sucesso!"]);
  }
} catch (\Throwable $th) {
  echo json_encode(["status" => -1, "message" => "Erro ao preencher modal de detalhes da avaliação", "error" => $th->getMessage()]);
}
