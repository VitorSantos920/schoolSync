<?php
require_once "../../db/config.php";

date_default_timezone_set("America/Sao_Paulo");

if (!isset($_POST['idAluno'])) {
  header('Location: ../../pages/permissao.php');
  exit;
}

$idAluno = $_POST['idAluno'];

$result = DB::query("SELECT materia.nome AS materia, falta.bimestre_atual, COUNT(falta.id) AS total_faltas
                     FROM falta
                     JOIN materia ON falta.materia_id = materia.id
                     GROUP BY materia.nome, falta.bimestre_atual
                     ORDER BY falta.bimestre_atual, materia.nome");

// Inicializando o array de bimestres e faltas
$bimestres = ['1º Bimestre', '2º Bimestre', '3º Bimestre', '4º Bimestre'];
$faltasPorMateria = [];

// Processando os resultados da consulta
foreach ($result as $row) {
  $materia = $row['materia'];
  $bimestreAtual = $row['bimestre_atual'] - 1; // Ajustando o índice para 0 a 3
  $totalFaltas = $row['total_faltas'];

  // Inicializando o array para a matéria se não existir ainda
  if (!isset($faltasPorMateria[$materia])) {
    $faltasPorMateria[$materia] = [0, 0, 0, 0]; // Inicializa com 0 faltas para todos os bimestres
  }

  // Armazenando o total de faltas no bimestre correto
  $faltasPorMateria[$materia][$bimestreAtual] = $totalFaltas;
}

// Garantindo que todas as matérias tenham dados para todos os bimestres
foreach ($faltasPorMateria as $materia => $faltasBimestre) {
  for ($i = 0; $i < count($bimestres); $i++) {
    if (!isset($faltasBimestre[$i])) {
      $faltasPorMateria[$materia][$i] = 0; // Se não tiver faltas, coloca 0
    }
  }
}

// Criando a resposta
$response = [
  'bimestres' => $bimestres,  // Array com os bimestres
  'faltasPorMateria' => $faltasPorMateria,  // Faltas por matéria, com os bimestres corretos
];

// Retornando a resposta como JSON
echo json_encode($response);
