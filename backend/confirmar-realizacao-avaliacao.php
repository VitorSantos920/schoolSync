<?php
require_once "./init-configs.php";

if (!isset($_POST['avaliacaoId'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

try {
  $avaliacaoId = $_POST['avaliacaoId'];

  DB::update('avaliacao', [
    'realizada' => 1
  ], 'id = %i', $avaliacaoId);

  if (DB::affectedRows() > 0) {
    echo json_encode([
      'status' => 1,
      'message' => 'Avaliação realizada com sucesso.'
    ]);
    exit;
  }


  echo json_encode([
    'status' => -1,
    'message' => 'Erro ao confirmar realização da avaliação.'
  ]);
} catch (\Throwable $th) {
  json_encode([
    'status' => -1,
    'message' => 'Erro ao confirmar realização da avaliação.',
    'error' => $th->getMessage()
  ]);
}
