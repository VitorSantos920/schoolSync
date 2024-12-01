<?php
require_once "../backend/init-configs.php";

if (!isset($_POST['idClasse'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

try {

  $dadosClasse = DB::queryFirstRow("SELECT * FROM classe WHERE id = %i", $_POST['idClasse']);
  $materiasClasse = DB::query("SELECT mat.nome, cm.classe_id, cm.materia_id FROM classe_materia cm INNER JOIN materia mat ON cm.materia_id = mat.id WHERE cm.classe_id = %i ORDER BY mat.nome", $_POST['idClasse']);
  $materiasAusentes = DB::query("SELECT mat.id, mat.nome FROM materia mat LEFT JOIN classe_materia cm ON mat.id = cm.materia_id AND cm.classe_id = %i WHERE cm.classe_id IS NULL ORDER BY mat.nome", $_POST['idClasse']);

  $modalBody = "
    <input type='hidden' id='id-classe' value='{$_POST['idClasse']}'/>

    <fieldset class='informacoes-turma'>
      <div>
          <label for='novo-nome-turma' class='form-label'>Nome da Turma</label>
          <input type='text' class='form-control' id='novo-nome-turma' name='novo-nome-turma' value='{$dadosClasse['nome']}' placeholder='Turma 1'>
      </div>

      <div>
          <label for='nova-escolaridade-turma' class='form-label'>Escolaridade da Turma</label>
          <select class='form-control form-select' name='nova-escolaridade-turma' id='nova-escolaridade-turma' required=''>
            <option value='-1' disabled>Escolaridade</option>
            <option value='1'" . (($dadosClasse['serie'] == 1) ? 'selected' : '') . ">1</option>
            <option value='2'" . (($dadosClasse['serie'] == 2) ? 'selected' : '') . ">2</option>
            <option value='3'" . (($dadosClasse['serie'] == 3) ? 'selected' : '') . ">3</option>
            <option value='4'" . (($dadosClasse['serie'] == 4) ? 'selected' : '') . ">4</option>
            <option value='5'" . (($dadosClasse['serie'] == 5) ? 'selected' : '') . ">5</option>
          </select>
      </div>
    </fieldset>

    <h3>Matérias da turma</h3>
    <p>Caso desejar, adicione ou remova as matérias da classe atual.</p>

    <h4>Adicionar matérias</h4>
    <table class='table'>
      <tbody>
    ";

  if (count($materiasAusentes) > 0) {
    foreach ($materiasAusentes as $materia) {
      $modalBody .= "
        <tr>
          <td><i class='fa-solid fa-book'></i> {$materia['nome']}</td>
          <td>
            <button class='btn btn-success' title='Adicionar Matéria' onclick='adicionarMateriaClasse({$_POST['idClasse']}, {$materia['id']})'>
              <i class='fa-solid fa-book-medical'></i>
            </button>
          </td>
        </tr>
      ";
    }
  } else {

    $modalBody .= "
        <tr>
          <td>Nenhuma matéria disponível para adicionar</td>
        </tr>
      ";
  }


  $modalBody .= "
      </tbody>
    </table>

    <h4>Remover matérias</h4>
    <table class='table'>
      <tbody>
  ";

  if (count($materiasClasse) > 0) {
    foreach ($materiasClasse as $materia) {
      $modalBody .= "
        <tr>
          <td><i class='fa-solid fa-book'></i> {$materia['nome']}</td>
          <td>
            <button class='btn btn-danger' title='Remover Matéria' onclick='removerMateriaClasse({$materia['classe_id']}, {$materia['materia_id']})'>
              <i class='fa-solid fa-trash'></i>
            </button>
          </td>
        </tr>";
    }
  } else {
    $modalBody .= "
      <tr>
        <td>Nenhuma matéria adicionada à turma</td>
      </tr>
    ";
  }


  $modalBody .= "
      </tbody>
  </table>";

  echo json_encode(["status" => 1, "modalBody" => $modalBody]);
} catch (\Throwable $e) {
  echo json_encode(["status" => -1, "swalMessage" => "Algo deu errado na atualização da turma. Pedimos desculpas pelo transtorno!", "error" => $e]);
}
