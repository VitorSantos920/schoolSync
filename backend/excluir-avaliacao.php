<?php
require_once "./init-configs.php";

if (!isset($_POST['idAvaliacao'])) {
  header("Location: ../pages/permissao.php");
  exit;
}

try {
  DB::delete("avaliacao", "id = %i", $_POST['idAvaliacao']);

  if (DB::affectedRows() > 0) {
    echo json_encode(["status" => 1, "swalMessage" => "A avaliação foi excluída com sucesso!"]);
  }
} catch (\Throwable $th) {
  echo json_encode(["status" => -1, "message" => "Erro ao excluir avaliação", "error" => $th->getMessage()]);
}
