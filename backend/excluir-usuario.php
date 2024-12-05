<?php
require_once "../db/config.php";

if (!isset($_POST['idUsuario'])) {
  header('Location: ./permissao.php');
  exit;
}

try {
  DB::update("usuario", [
    "status" => 0,
  ], "id=%i", $_POST['idUsuario']);

  echo json_encode(["status" => 1, "swalMessage" => "Usuário desativado com sucesso!"]);
  exit;
} catch (\Throwable $th) {
  echo json_encode(["status" => -1, "swalMessage" => "Houve um erro interno ao desativar o usuário!"]);
  exit;
}
