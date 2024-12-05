<?php
require_once "./init-configs.php";

if (!isset($_POST['email'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

try {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $categoria = $_POST['categoria'];
  $senha = $_POST['senha'];

  DB::insert('usuario', [
    'nome' => $nome,
    'email' => $email,
    'categoria' => $categoria,
    'senha' => password_hash($senha, PASSWORD_DEFAULT),
    'status' => 1
  ]);

  $idUsuario = DB::insertId();

  switch ($categoria) {
    case 'Aluno':
      DB::insert('aluno', [
        'usuario_id' => $idUsuario,
        'data_nascimento' => $_POST['data_nascimento'],
        'escola' => $_POST['escola'],
        'escolaridade' => $_POST['escolaridade'],
        'genero' => $_POST['genero']
      ]);
      break;

    case 'Professor':
      DB::insert('professor', [
        'usuario_id' => $idUsuario,
        'cpf' => $_POST['cpf']
      ]);
      break;

    case 'Administrador':
      DB::insert('administrador', [
        'usuario_id' => $idUsuario,
        'cargo' => $_POST['cargo']
      ]);
      break;

    case 'Responsável':
      DB::insert('responsavel', [
        'usuario_id' => $idUsuario,
        'cpf' => $_POST['cpf'],
        'telefone' => $_POST['telefone'],
        'quantidade_filho' => $_POST['quantidadeFilho']
      ]);
      break;
  }

  echo json_encode(["status" => 1, "swalMessage" => "O usuário \"$nome\" de categoria \"$categoria\" foi adicionado com sucesso"]);
} catch (\Throwable $th) {
  echo json_encode(["status" => -1, "message" => "Erro ao adicionar usuário", "error" => $th->getMessage()]);
}
