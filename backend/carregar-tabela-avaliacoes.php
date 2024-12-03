<?php
require_once "./init-configs.php";

if (!isset($_POST['liberado'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

try {
  $classe_id = $_POST['classeId'];
  $avaliacoesTurma = DB::query('SELECT a.id, a.titulo, a.descricao, a.realizada, m.nome as nome_materia, a.data_prevista FROM avaliacao a INNER JOIN classe c ON a.classe_id = c.id INNER JOIN materia m ON a.materia_id = m.id WHERE c.id = %i', $classe_id);
  $tableBody = "";

  if (!empty($avaliacoesTurma)) {
    foreach ($avaliacoesTurma as $avaliacao) {
      $dataPrevista = date('d/m/Y H:i', strtotime($avaliacao['data_prevista']));

      if ($avaliacao['realizada'] == 1) {
        $botaoConfirmacao = "
          <button class='btn' disabled>
            <i class='fa-solid fa-circle-info'></i>
            Avaliação Realizada
          </button>
        ";
      } else {
        $botaoConfirmacao = "
          <button class='btn btn-success' onclick='confirmarRealizacao({$classe_id}, {$avaliacao['id']})'>
            <i class='fa-solid fa-circle-check'></i>
            Confirmar Realização
          </button>
        ";
      }


      $tableBody .= "
        <tr>
          <td>{$avaliacao['titulo']}</td>
          <td>{$avaliacao['descricao']}</td>
          <td>{$avaliacao['nome_materia']}</td>
          <td>{$dataPrevista}</td>
          <td>
            <div class='dropdown'>
                <button class='btn btn-secondary dropdown-toggle' id='btnPrincipal' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                    Lista de Ações
                </button>
                <ul class='dropdown-menu'>
                    <li>
                        <button type='button' class='btn' onclick='abrirModalEditarAvaliacao({$avaliacao['id']})'>
                          <i class='fa-solid fa-pen icone'></i>
                          Editar Avaliação
                        </button>
                    </li>
                    <li>
                    " .  $botaoConfirmacao . "
                    </li>
                    <li>
                        <button type='button' class='btn btn-danger' onclick='excluirAvaliacao({$avaliacao['id']})'>
                          <i class='fa-solid fa-trash icone'></i>
                          Deletar Avaliação
                        </button>
                    </li>
                </ul>
            </div>
            
          </td>
        </tr>
      ";
    }
  } else {
    $tableBody = "
      <tr>
        <td colspan='5' class='text-center'>As avaliações adicionadas para esta turma aparecerão aqui.</td>
      </tr>
    ";
  }

  echo json_encode([
    'status' => 1,
    'tableBody' => $tableBody
  ]);
} catch (\Throwable $th) {
  echo json_encode([
    'status' => -1,
    'message' => 'Ocorreu um erro ao carregar as avaliações da turma!',
    'error' => $th->getMessage()
  ]);
}
