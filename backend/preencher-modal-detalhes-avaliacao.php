<?php
require_once "./init-configs.php";

if (!isset($_POST['idAvaliacao'])) {
  header("Location: ../pages/permissao.php");
  exit;
}

try {
  $dadosAvaliacao = DB::queryFirstRow("SELECT * FROM avaliacao WHERE id=%i", $_POST['idAvaliacao']);

  $criadoEm = date('d/m/Y H:i:s', strtotime($dadosAvaliacao['criado_em']));
  $dataPrevista = date('d/m/Y H:i', strtotime($dadosAvaliacao['data_prevista']));
  $materiaAvaliacao = DB::queryFirstField("SELECT nome FROM materia WHERE id = %i", $dadosAvaliacao['materia_id']);
  $professorResponsavel = DB::queryFirstField("SELECT u.nome FROM classe cl INNER JOIN professor pr ON cl.professor_id = pr.id INNER JOIN usuario u ON pr.usuario_id = u.id WHERE cl.id = %i", $dadosAvaliacao['classe_id']);


  $modalBody = "
    <h5><i class='fa-regular fa-note-sticky'></i> Descrição</h5>
    <p id='descricao-avaliacao'>$dadosAvaliacao[descricao]</p>

    <h5><i class='fa-solid fa-book'></i> Matéria da Avaliação</h5>
    <p id='materia-avaliacao'>$materiaAvaliacao</p>

    <h5><i class='fa-regular fa-calendar'></i> Data Prevista da Avaliação</h5>
    <p>$dataPrevista (<i class='fa-solid fa-circle-xmark' style='color: #dc3545;'></i> Ainda não realizada)</p>

    <h5><i class='fa-solid fa-user-tie'></i> Professor Responsável</h5>
    <p>$professorResponsavel</p>

    <p id='created-at'>Criada em: $criadoEm</p>
  ";
  echo json_encode(["modalBody" => $modalBody, "status" => 1, "nomeAvaliacao" => $dadosAvaliacao['titulo'], "representacaoAvaliacao" => $dadosAvaliacao['representacao']]);
} catch (\Throwable $th) {
  echo json_encode([
    'status' => -1,
    "message" => "Erro ao preencher modal de detalhes da avaliação",
    'error' => $th->getMessage()
  ]);
}
