<?php
require_once "./init-configs.php";

if (!isset($_POST['tituloAvaliacao'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

try {
  $classe_id = $_POST['classe'];
  $representacao = $_POST['representacaoAvaliacao'];
  $titulo = $_POST['tituloAvaliacao'];
  $descricao = $_POST['descricaoAvaliacao'];
  $materia = $_POST['materiaAvaliacao'];
  $data_prevista = $_POST['dataPrevista'];

  DB::insert('avaliacao', [
    'classe_id' => $classe_id,
    'materia_id' => $materia,
    'representacao' => $representacao,
    'titulo' => $titulo,
    'descricao' => $descricao,
    'data_prevista' => $data_prevista,
  ]);

  if (DB::affectedRows() > 0) {
    echo json_encode([
      'status' => 1,
      'swalMessage' => 'A avaliação foi adicionada com sucesso!'
    ]);
    exit;
  }

  echo json_encode([
    'status' => -1,
    'swalMessage' => 'Ocorreu um erro ao adicionar a avaliação!'
  ]);
} catch (\Throwable $th) {
  echo json_encode([
    'status' => -1,
    'swalMessage' => 'Ocorreu um erro ao adicionar a avaliação!',
    'error' => $th->getMessage()
  ]);
}
