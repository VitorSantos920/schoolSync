<?php
require_once "../../db/config.php";

session_start();
date_default_timezone_set("America/Sao_Paulo");

if (!isset($_POST['dadosNota'])) {
  header('Location: ../../pages/permissao.php');
  exit;
}

$dadosNotas = json_decode($_POST['dadosNota'], true);
$retorno = [];


$idProfessor = DB::queryFirstField("SELECT id FROM professor WHERE usuario_id = %i", $_SESSION['id']);

try {
  foreach ($dadosNotas as $nota) {
    $alunoId = $nota['alunoId'];
    $avaliacaoId = $nota['avaliacaoId'];
    $notaValor = $nota['nota'];
    $classeId = DB::queryFirstField("SELECT classe_id FROM aluno WHERE id = %i", $alunoId);

    $bimestreAtual = DB::queryFirstField("SELECT bimestre_atual FROM classe WHERE id = %i", $classeId);

    $existeNota = DB::queryFirstField(
      "SELECT COUNT(*) FROM nota WHERE aluno_id = %i AND avaliacao_id = %i AND bimestre_atual = %i",
      $alunoId,
      $avaliacaoId,
      $bimestreAtual
    );

    if ($existeNota) {
      DB::update(
        'nota',
        ['nota' => $notaValor],
        'aluno_id = %i AND avaliacao_id = %i AND bimestre_atual = %i',
        $alunoId,
        $avaliacaoId,
        $bimestreAtual
      );
    } else {
      DB::insert('nota', [
        'aluno_id' => $alunoId,
        'avaliacao_id' => $avaliacaoId,
        'nota' => $notaValor,
        'bimestre_atual' => $bimestreAtual
      ]);
    }
  }

  echo json_encode(['status' => 1, 'swalMessage' => 'Notas salvas com sucesso.']);
} catch (\Throwable $th) {
  echo json_encode(['status' => -1, 'swalMessage' => 'Erro ao salvar notas.', 'error' => $th->getMessage()]);
}
