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

    DB::insertUpdate(
      'nota',
      [
        'aluno_id' => $alunoId,
        'avaliacao_id' => $avaliacaoId,
        'nota' => $notaValor,
        'bimestre_atual' => $bimestreAtual
      ],
      [
        'nota' => $notaValor
      ]
    );
  }

  echo json_encode(['status' => 1, 'swalMessage' => 'Notas salvas com sucesso.']);
} catch (\Throwable $th) {
  echo json_encode(['status' => -1, 'swalMessage' => 'Erro ao salvar notas.', 'error' => $th->getMessage()]);
}
