<?php
require_once "../db/config.php";

date_default_timezone_set("America/Sao_Paulo");

if (!isset($_POST['idAluno'])) {
  header('Location: ../pages/permissao.php');
  exit;
}


try {
  $aluno = DB::queryFirstRow("SELECT * FROM usuario us INNER JOIN aluno al ON al.usuario_id = us.id WHERE al.id = %i", $_POST['idAluno']);

  $classeAluno = DB::queryFirstField("SELECT nome FROM classe cl WHERE cl.id = %i", $aluno['classe_id']);

  $classes = DB::query("SELECT * FROM classe");

  $modalBody = "<div class='container'>
                <input type='hidden' id='id-aluno' value='$aluno[id]'/>
                <div class='row'>
                  <div class='col-md-6'>
                      <label for='nome' class='form-label'>Nome</label>
                      <input type='text' class='form-control' id='nome' name='nome' value='$aluno[nome]'>
                  </div>

                  <div class='col-md-6'>
                      <label for='data_nascimento' class='form-label'>Data de Nascimento</label>
                      <input type='date' class='form-control' id='data_nascimento' name='data_nascimento' value='$aluno[data_nascimento]'>
                  </div>
                </div>
              </div>

              <div class='container'>
                <div class='row'>
                    <div class='col-md-6'>
                        <label for='escolaridade' class='form-label'>Escolaridade</label>
                        <input type='text' class='form-control' id='escolaridade' name='escolaridade' value='$aluno[escolaridade]'>
                    </div>
                    <div class='col-md-6'>
                        <label for='classe' class='form-label'>Classe</label>
                        <select class='form-control form-select' name='classe' id='classe'>
                          <option value='' disabled>Selecione</option>
                        ";

  foreach ($classes as $classe) {
    $selected = ($classe['nome'] == $classeAluno) ? "selected" : "";
    $modalBody .= "<option value='{$classe['id']}' $selected>$classe[nome]</option>";
  }

  $modalBody .= "                      
                        </select>
                    </div>
                </div>
              </div>

              <div class='container'>
                <div class='row'>
                    <div class='col-md-6'>
                        <label for='escola' class='form-label'>Escola</label>
                        <input type='text' class='form-control' id='escola' name='escola' value='$aluno[escola]'>
                    </div>
                    <div class='col-md-6'>
                      <label for='genero' class='form-label'>Gênero do Aluno</label>
                      <select class='form-control form-select' id='genero' name='genero'>
                        <option value='' disabled>Selecione</option>
                        <option value='Feminino' " . ($aluno['genero'] == 'Feminino' ? "selected" : "") . ">Feminino</option>
                        <option value='Masculino' " . ($aluno['genero'] == 'Masculino' ? "selected" : "") . ">Masculino</option>
                      </select>
                    </div>
                </div>
              </div>
                ";
  echo json_encode(["modalBody" => $modalBody]);
} catch (\Throwable $e) {
  json_encode(["status" => -1, "swalMessage" => "Algo deu errado na edição do aluno. Pedimos desculpas pelo transtorno!", "error" => $e]);
}
