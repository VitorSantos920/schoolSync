<?php
require_once "../../db/config.php";

date_default_timezone_set("America/Sao_Paulo");


if (!isset($_POST['idAluno'])) {
  header('Location: ../../pages/permissao.php');
  exit;
}





$notasAluno = DB::query("SELECT *, mt.nome as 'nome_materia' FROM nota nt INNER JOIN materia mt ON nt.materia_id = mt.id WHERE nt.aluno_id = %i", $_POST['idAluno']);

$medias = [];

foreach ($notasAluno as $nota) {
  $materia_id = $nota['materia_id'];
  $bimestre_atual = $nota['bimestre_atual'];
  $nota_valor = $nota['nota'];

  // Inicializa o array se ainda não existir
  if (!isset($medias[$bimestre_atual])) {
    $medias[$bimestre_atual] = []; // Cria um novo bimestre
  }

  // Inicializa a matéria se ainda não existir
  if (!isset($medias[$bimestre_atual][$materia_id])) {
    $medias[$bimestre_atual][$materia_id] = [
      "nome_materia" => $nota['nome_materia'],
      'soma' => 0,
      'quantidade' => 0,
    ];
  }

  // Soma a nota e incrementa a quantidade
  $medias[$bimestre_atual][$materia_id]['soma'] += $nota_valor;
  $medias[$bimestre_atual][$materia_id]['quantidade'] += 1;
}

// Agora vamos calcular a média
$medias_resultantes = [];

foreach ($medias as $bimestre => $materias) {
  foreach ($materias as $materia_id => $dados) {
    $media = $dados['soma'] / $dados['quantidade'];
    // Armazena a média no formato desejado
    $medias_resultantes[$bimestre][$materia_id] = ["nome_materia" => $dados['nome_materia'], "media" => $media];
  }
}

echo json_encode($medias_resultantes);
