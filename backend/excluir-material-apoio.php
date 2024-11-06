<?php
require_once "../db/config.php";

if (!isset($_POST['idRecurso'])) {
  header('location: ../pages/permissao.php');
  exit;
}

try {
  $nomeRecurso = DB::queryFirstField("SELECT re.titulo FROM recurso_educacional re WHERE re.id = %i", $_POST['idRecurso']);

  DB::delete("recurso_educacional", "id=%i", $_POST['idRecurso']);
  echo json_encode(["status" => 1, "swalMessage" => "O recurso educacional \"$nomeRecurso\" foi excluído com sucesso!"]);
} catch (\Throwable $th) {
  echo json_encode(["status" => -1, "swalMessage" => "Houve um erro interno ao excluir o recurso educacional!"]);
}
