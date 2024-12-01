<?php
require_once './init-configs.php';

if (!isset($_POST['classeId'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

$classeId = $_POST['classeId'];
$classeBimestre = DB::queryFirstField('SELECT bimestre_atual FROM classe WHERE id = %i', $classeId);
$proximoBimestre = $classeBimestre + 1;

try {
  DB::update('classe', [
    'bimestre_atual' => $proximoBimestre
  ], 'id = %i', $classeId);

  echo json_encode(["status" => 1, "swalMessage" => "O bimestre da classe foi fechado com sucesso. A partir de agora, as próximas notas e faltas lançadas serão contabilizadas para o {$proximoBimestre}° bimestre !"]);
} catch (\Throwable $th) {
  echo json_encode(["status" => -1, "swalMessage" => "Algo deu errado ao fechar o bimestre da classe. Pedimos desculpas pelo transtorno!", "messageError" => "Erro: " . $th]);
}
