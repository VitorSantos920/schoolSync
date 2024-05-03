<?php
require_once '../db/config.php';

// Consulta SQL para recuperar o total de faltas do aluno
$totalFaltas = DB::queryFirstField("SELECT COUNT(*) FROM falta WHERE aluno_id = %i", $dadosAluno["aluno_id"]);

// Retornar os dados em formato JSON
header('Content-Type: application/json');
echo json_encode(['total_faltas' => $totalFaltas]);
?>
