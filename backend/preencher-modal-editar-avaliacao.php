<?php
require_once "./init-configs.php";

if (!isset($_POST['idAvaliacao'])) {
  header("Location: ../pages/permissao.php");
  exit;
}

try {
  $dadosAvaliacao = DB::queryFirstRow("SELECT * FROM avaliacao WHERE id = %i", $_POST['idAvaliacao']);
  $materias = DB::query('SELECT cm.materia_id, m.nome FROM classe_materia cm INNER JOIN materia m ON cm.materia_id = m.id WHERE classe_id = %i', $dadosAvaliacao['classe_id']);

  $modalBody = "
    <form method='POST'>
      <input type='hidden' id='id-avaliacao' class='form-control' disabled value='{$dadosAvaliacao['id']}' required>
      <fieldset>
        <label for='ipt-edit-representacao-avaliacao' class='form-label'>Representação da Avaliação</label>
        <input type='text' name='ipt-edit-representacao-avaliacao' id='ipt-edit-representacao-avaliacao' class='form-control' value='{$dadosAvaliacao['representacao']}' required placeholder='P1, AV1, ATV1' maxlength='5'>
      </fieldset>

      <fieldset>
        <label for='ipt-edit-nome-avaliacao' class='form-label'>Nome da Avaliação</label>
        <input type='text' name='ipt-edit-nome-avaliacao' id='ipt-edit-nome-avaliacao' class='form-control' value='{$dadosAvaliacao['titulo']}' required>
      </fieldset>

      <fieldset>
        <label for='ipt-edit-descricao-avaliacao' class='form-label'>Descrição da Avaliação</label>
        <textarea name='ipt-edit-descricao-avaliacao' id='ipt-edit-descricao-avaliacao' class='form-control' required>{$dadosAvaliacao['descricao']}</textarea>
      </fieldset>

      <fieldset>
        <label for='slct-edit-materia-avaliacao' class='form-label'>Selecione a Matéria da Avaliação</label>
        <select class='form-control form-select' name='slct-edit-materia-avaliacao' id='slct-edit-materia-avaliacao'>
          <option value='-1' disabled selected>Selecione uma matéria</option>";

  foreach ($materias as $materia) {
    $modalBody .= "<option value='{$materia['materia_id']}' " .  (($dadosAvaliacao['materia_id'] == $materia['materia_id']) ? "selected" : "")  . ">{$materia['nome']}</option>";
  }

  $modalBody .= "
        </select>
      </fieldset>

      <fieldset>
        <label for='ipt-edit-data-prevista-avaliacao' class='form-label'>Data Prevista da Avaliação</label>
        <input type='datetime-local' name='ipt-edit-data-prevista-avaliacao' id='ipt-edit-data-prevista-avaliacao' class='form-control' value='{$dadosAvaliacao['data_prevista']}' required>
      </fieldset>
    </form>
  ";

  echo json_encode(["status" => 1, "modalBody" => $modalBody, "avaliacao" => $dadosAvaliacao]);
} catch (\Throwable $th) {
  echo json_encode(["status" => -1, "message" => "Erro ao preencher modal de detalhes da avaliação", "error" => $th->getMessage()]);
}
