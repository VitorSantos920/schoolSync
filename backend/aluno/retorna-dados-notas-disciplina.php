<?php
require_once "../../db/config.php";

date_default_timezone_set("America/Sao_Paulo");

if (!isset($_POST['idAluno'])) {
  header('Location: ../../pages/permissao.php');
  exit;
}

$notasAluno = DB::query(
  " SELECT
      nt.*,
      av.representacao AS representacao_avaliacao,
      av.titulo AS titulo_avaliacao,
      av.descricao AS descricao_avaliacao,
      av.data_prevista,
      av.realizada,
      mt.nome AS 'nome_materia',
      mt.id AS 'materia_id'
    FROM nota nt
    INNER JOIN avaliacao av ON nt.avaliacao_id = av.id
    INNER JOIN materia mt ON av.materia_id = mt.id
    WHERE nt.aluno_id = %i",
  $_POST['idAluno']
);

$materias_unicas = [];
foreach ($notasAluno as $nota) {
  $materias_unicas[$nota['materia_id']] = $nota['nome_materia'];
}

$medias = [];

foreach ($notasAluno as $nota) {
  $materia_id = $nota['materia_id'];
  $bimestre_atual = $nota['bimestre_atual'];
  $nota_valor = $nota['nota'];

  if (!isset($medias[$bimestre_atual])) {
    $medias[$bimestre_atual] = [];
  }

  if (!isset($medias[$bimestre_atual][$materia_id])) {
    $medias[$bimestre_atual][$materia_id] = [
      "nome_materia" => $nota['nome_materia'],
      'soma' => 0,
      'quantidade' => 0,
    ];
  }

  $medias[$bimestre_atual][$materia_id]['soma'] += $nota_valor;
  $medias[$bimestre_atual][$materia_id]['quantidade'] += 1;
}

foreach ($materias_unicas as $materia_id => $nome_materia) {
  foreach (array_keys($medias) as $bimestre) {
    if (!isset($medias[$bimestre][$materia_id])) {
      $medias[$bimestre][$materia_id] = [
        "nome_materia" => $nome_materia,
        'soma' => 0,
        'quantidade' => 0
      ];
    }
  }
}

// Calcula as médias
$medias_resultantes = [];
foreach ($medias as $bimestre => $materias) {
  foreach ($materias as $materia_id => $dados) {
    $media = $dados['quantidade'] > 0 ? $dados['soma'] / $dados['quantidade'] : 0;

    $medias_resultantes[$bimestre][$materia_id] = [
      "nome_materia" => $dados['nome_materia'],
      "media" => $media
    ];
  }
}

echo json_encode($medias_resultantes);
