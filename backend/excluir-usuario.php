<?php
require_once "../db/config.php";

if (!isset($_POST['idUsuario'])) {
  header('Location: ./permissao.php');
  exit;
}

try {
  $categoriaUsuario = DB::queryFirstField("SELECT us.categoria FROM usuario us WHERE us.id = %i", $_POST['idUsuario']);

  function categoriaUsuarioFormatada($categoria)
  {
    $categorias = [
      "Responsavel" => "responsavel",
      "Administrador" => "administrador",
      "Aluno" => "aluno",
      "Professor" => "professor"
    ];

    return $categorias[$categoria];
  }

  $categoria = categoriaUsuarioFormatada($categoriaUsuario);

  if ($categoria == "professor") {
    $tabela = "professor";
  } elseif ($categoria == "aluno") {
    $tabela = "aluno";
  } elseif ($categoria == "responsavel") {
    $tabela = "responsavel";
  } else {
    $tabela = "administrador";
  }

  $id = DB::queryFirstField("SELECT id FROM {$tabela} WHERE usuario_id = %i", $_POST['idUsuario']);

  DB::update("{$categoria}", [
    "status_{$categoria}" => 0,
  ], "id=%i", $id);

  echo json_encode(["status" => 1, "swalMessage" => "Usuário excluído com sucesso!"]);
  exit;
} catch (\Throwable $th) {
  echo json_encode(["status" => -1, "swalMessage" => "Houve um erro interno ao excluir o usuário!"]);
  exit;
}
