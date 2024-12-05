<?php
// var_dump($_POST);

require_once "../../db/config.php";

date_default_timezone_set("America/Sao_Paulo");

if (!isset($_POST['faltas'])) {
  header('Location: ../../pages/permissao.php');
  exit;
}

try {
  $dadosFaltas = json_decode($_POST['faltas'], true);

  foreach ($dadosFaltas as $falta) {
    $classeId = DB::queryFirstField("SELECT classe_id FROM aluno WHERE id = %i", $falta['alunoId']);
    $bimestreAtual = DB::queryFirstField("SELECT bimestre_atual FROM classe WHERE id = %i", $classeId);

    DB::insert('falta', [
      "materia_id" => $falta['materiaId'],
      "aluno_id" => $falta['alunoId'],
      "data_falta" => $falta['dataFalta'],
      "bimestre_atual" => $bimestreAtual,
      "motivo" => $falta['motivo']
    ]);
  }

  echo json_encode(['status' => 1, 'swalMessage' => 'Faltas salvas com sucesso.']);
} catch (\Throwable $th) {
  json_encode(['status' => -1, 'swalMessage' => 'Erro ao salvar faltas.', 'error' => $th->getMessage()]);
}
