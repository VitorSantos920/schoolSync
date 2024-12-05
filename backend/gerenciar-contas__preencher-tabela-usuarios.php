<?php
require_once "./init-configs.php";

if (!isset($_POST['liberado'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

try {
  $usuarios = DB::query("SELECT * FROM usuario");
  $corpoTabela = "";

  foreach ($usuarios as $usuario) {
    $usuarioAtivo = DB::queryFirstField("SELECT status FROM usuario WHERE id = %i", $usuario['id']);

    $categoria = $usuario['categoria'] == 'Responsavel' ? 'Responsável' : $usuario['categoria'];

    $corpoTabela .= "
      <tr>
        <td> $usuario[id] </td>
        <td> $usuario[nome] </td>
        <td> $usuario[email] </td>
        <td> $categoria</td>
        <td> " . ($usuarioAtivo == 0 ? "<i class='fas fa-circle' style='color: red;'></i>" : "<i class='fas fa-circle' style='color: green;'></i>") . "</td>
        <td>
          <button class='btn btn-warning' onclick='abrirModalEditarUsuario($usuario[id])'>Editar</button>
          <button class='btn btn-danger' onclick='excluirUsuario({$usuario['id']})'>Desativar</button>
        </td>
      </tr>
    ";
  }

  echo json_encode(["status" => 1, "corpoTabela" => $corpoTabela]);
} catch (\Throwable $th) {
  echo json_encode(["status" => -1, "message" => "Erro ao editar usuário", "error" => $th->getMessage()]);
}
