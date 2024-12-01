<?php
require_once "./init-configs.php";

if (!isset($_POST['classeId'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

try {
  $classe_id = $_POST['classeId'];
  $classe_materias = DB::query("SELECT cm.materia_id, m.nome FROM classe_materia cm INNER JOIN materia m ON cm.materia_id = m.id WHERE classe_id = %i", $classe_id);

  $botoes = "";

  foreach ($classe_materias as $materia) {
    $avaliacoesRealizadas = DB::query("SELECT av.id, av.representacao FROM avaliacao av WHERE av.classe_id = %i AND av.realizada = 1 AND av.materia_id = %i", $classe_id, $materia['materia_id']);
    $alunosClasse = DB::query("SELECT *, a.id as 'aluno_id' FROM aluno a INNER JOIN usuario u ON a.usuario_id = u.id WHERE a.classe_id = %i", $classe_id);

    if (empty($avaliacoesRealizadas)) continue;

    $botao = "
        <button class='btn btn-secondary d-block mb-3 w-25' type='button' data-bs-toggle='collapse' data-bs-target='#materia-{$materia['materia_id']}' aria-expanded='false' aria-controls='materia-{$materia['materia_id']}'>
            {$materia['nome']}
        </button>
    ";

    $cabecalhoTabela = "
        <thead>
            <tr>
                <th>ID Aluno</th>
                <th>Aluno</th>
    ";

    foreach ($avaliacoesRealizadas as $avaliacao) {
      $cabecalhoTabela .= "
                <th>{$avaliacao['representacao']}</th>";
    }

    $cabecalhoTabela .= "
                <th>Ações</th>
            </tr>
        </thead>
    ";

    $corpoTabela = "
        <tbody>";

    foreach ($alunosClasse as $aluno) {
      $corpoTabela .= "
            <tr data-aluno-id='{$aluno['aluno_id']}' data-materia-id='{$materia['materia_id']}'>
                <td>{$aluno['id']}</td>
                <td>{$aluno['nome']}</td>";

      foreach ($avaliacoesRealizadas as $avaliacao) {
        $notaAvaliacao = DB::queryFirstField("SELECT nota FROM nota WHERE avaliacao_id = %i AND aluno_id = %i", $avaliacao['id'], $aluno['aluno_id']);

        $corpoTabela .= "
                <td>
                    <input 
                      type='number' 
                      class='form-control nota-avaliacao' 
                      name='nota' 
                      id='nota-{$aluno['id']}-{$avaliacao['id']}' 
                      placeholder='Nota na avaliação {$avaliacao['representacao']}'
                      data-avaliacao-id='{$avaliacao['id']}'
                      value='{$notaAvaliacao}'
                    />
                </td>";
      }

      $corpoTabela .= "
                <td>
                  <button
                    type='button'
                    class='btn btn-success salvar-notas'
                    data-aluno-id='{$aluno['aluno_id']}'
                    data-materia-id='{$materia['materia_id']}'
                  >
                    <i class='fa-solid fa-pen icone'></i>
                    Salvar Notas
                  </button>
                </td>
      ";

      $corpoTabela .= "
            </tr>";
    }

    $corpoTabela .= "
        </tbody>";

    $card = "
        <div class='collapse mb-3' id='materia-{$materia['materia_id']}'>
            <div class='card card-body'>
                <table class='table'>
                    $cabecalhoTabela
                    $corpoTabela
                </table>
            </div>
        </div>
    ";

    $botoes .= $botao . $card;
  }

  echo json_encode([
    'status' => 1,
    'botoes' => $botoes
  ]);
} catch (\Throwable $th) {
  echo json_encode([
    'status' => -1,
    'message' => 'Ocorreu um erro ao carregar as avaliações da turma!',
    'error' => $th->getMessage()
  ]);
}
