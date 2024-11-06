<?php
require_once "../db/config.php";

if (!isset($_POST['pesquisa'])) {
  header("Location: ../pages/permissao.php");
  exit;
}

$html = "";

$retornoDaPesquisa = DB::query("SELECT * FROM usuario us WHERE us.nome LIKE '%{$_POST['pesquisa']}%' OR us.email LIKE '%{$_POST['pesquisa']}%' OR us.categoria LIKE '%{$_POST['pesquisa']}%'");

if (empty($retornoDaPesquisa)) {
  $html = "
    <tr>
      <td colspan='6' class='text-center'>Nenhum resultado encontrado para esta pesquisa.</td>
    </tr>

  ";
} else {
  foreach ($retornoDaPesquisa as $linha) {
    $status = $linha['status'] == 0 ? "<i class='fas fa-circle' style='color: red;'></i>" : "<i class='fas fa-circle' style='color: green;'></i>";
    $html .= "
      <tr>

        <td>{$linha['id']}</td>
        <td>{$linha['nome']}</td>
        <td>{$linha['email']}</td>
        <td>{$linha['categoria']}</td>
        <td>{$status}</td>
       <td>
          <button class='btn btn-warning' onclick='abrirModalEditarUsuario($linha[id])'>Editar</button>
          <button class='btn btn-danger' onclick='excluirUsuario($linha[id])'>Excluir</button>
        </td>
      </tr>
    ";
  }
}

echo json_encode(["html" => $html]);
