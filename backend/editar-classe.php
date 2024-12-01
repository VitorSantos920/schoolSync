<?php
require_once("../backend/init-configs.php");

if (!isset($_POST['idClasse'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

$idClasse = $_POST['idClasse'];
$acao = $_POST['acao'];

switch ($acao) {
  case "removerMateria":
    removerMateria($idClasse);
    break;
  case "adicionarMateria":
    adicionarMateria($idClasse);
    break;
  default:
    editarTurma($idClasse);
}


function removerMateria($idClasse)
{
  $idMateria = $_POST['idMateria'];

  try {
    DB::delete(
      "classe_materia",
      "materia_id = %i AND classe_id = %i",
      $idMateria,
      $idClasse
    );


    if (DB::affectedRows() > 0) {
      enviarResposta(1, 'Matéria removida com sucesso!');
    }

    enviarResposta(-1, 'Erro ao remover matéria!');
  } catch (\Throwable $th) {
    enviarResposta(-1, 'Erro ao remover matéria!', $th);
  }
}

function adicionarMateria($idClasse)
{
  $idMateria = $_POST['idMateria'];
  $nomeMateria = DB::queryFirstField("SELECT nome FROM materia WHERE id = %i", $idMateria);

  try {
    DB::insert("classe_materia", [
      "classe_id" => $idClasse,
      "materia_id" => $idMateria
    ]);

    if (DB::affectedRows() > 0) {
      enviarResposta(1, "Sucesso ao adicionar a matéria \"{$nomeMateria}\" à turma!");
    }

    enviarResposta(-1, 'Erro ao adicionar a matéria à turma!');
  } catch (\Throwable $th) {
    enviarResposta(-1, 'Erro ao adicionar a matéria à turma!', $th);
  }
}

function editarTurma($idClasse)
{
  $nomeTurma = $_POST['nomeTurma'];
  $escolaridadeTurma = $_POST['escolaridadeTurma'];

  try {
    DB::update("classe", [
      "nome" => $nomeTurma,
      "serie" => $escolaridadeTurma
    ], "id = %i", $idClasse);

    if (DB::affectedRows() > 0) {
      enviarResposta(1, 'Os dados da turma foram atualizados com sucesso!');
    }

    enviarResposta(-1, 'Erro ao atualizar a turma!');
  } catch (\Throwable $th) {
    enviarResposta(-1, 'Erro ao atualizar a turma!', $th);
  }
}

function enviarResposta($status, $swalMessage, $error = null)
{
  echo json_encode([
    'status' => $status,
    'swalMessage' => $swalMessage,
    'error' => $error
  ]);
  exit;
}
