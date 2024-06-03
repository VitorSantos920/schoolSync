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
  foreach ($recursosEducacionais as $recursoEducacional) {
    $tableBody .= "
      <tr>
        <td>{$recursoEducacional['id']}</td>
        <td>{$recursoEducacional['titulo']}</td>
        <td>{$recursoEducacional['descricao']}</td>
        <td>
          <a style='text-decoration: underline' href='{$recursoEducacional['url']}' target='_blank'>Acessar</a>
        </td>
        <td>{$recursoEducacional['escolaridade']}</td>
        <td>{$recursoEducacional['tipo']}</td>
        <td>
          <button class='btn btn-warning' onclick='modalEditarMaterialApoio()'>Editar</button>
          <button class='btn btn-danger' onclick='excluirRecurso({$recursoEducacional['id']})'>Excluir</button>
        </td>
      </tr>
    ";
  }
}

echo json_encode(["tableBody" => $tableBody]);
