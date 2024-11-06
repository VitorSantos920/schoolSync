<?php
if (!isset($_POST['liberado'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

require_once "../db/config.php";

$recursosEducacionais = DB::query("SELECT * FROM recurso_educacional");

$tableBody = '';

if (empty($recursosEducacionais)) {
  $tableBody .= "
    <tr>
      <td colspan='6' class='text-center'>Nenhum recurso educacional cadastrado no sistema.</td>
    </tr>
  ";
} else {
  foreach ($recursosEducacionais as $recurso) {
    $tableBody .= "
      <tr>
        <td>{$recurso['id']}</td>
        <td>{$recurso['titulo']}</td>
        <td>{$recurso['descricao']}</td>
        <td>
          <a style='text-decoration: underline' href='{$recurso['url']}' target='_blank'>Acessar</a>
        </td>
        <td>{$recurso['escolaridade']}</td>
        <td>{$recurso['tipo']}</td>
        <td>
          <button class='btn btn-warning' onclick='modalEditarMaterialApoio({$recurso['id']})'>Editar</button>
          <button class='btn btn-danger' onclick='excluirRecurso({$recurso['id']})'>Excluir</button>
        </td>
      </tr>
    ";
  }
}

echo json_encode(["tableBody" => $tableBody]);
