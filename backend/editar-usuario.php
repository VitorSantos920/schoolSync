<?php
require_once "../db/config.php";

if (!isset($_POST['idUsuario'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

try {
  DB::update('usuario', [
    'nome' => $_POST['nome'],
    'email' => $_POST['email'],
    'categoria' => $_POST['categoria'],
    'status' => $_POST['status']
  ], 'id = %i', $_POST['idUsuario']);

  if (DB::affectedRows() > 0) {
    echo json_encode(["status" => 1, "swalMessage" => "Os dados do usuário foram editados com sucesso"]);
  }
} catch (\Throwable $th) {
  echo json_encode(["status" => -1, "message" => "Erro ao editar usuário", "error" => $th->getMessage()]);
}
