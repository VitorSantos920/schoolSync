<?php
require_once "../db/config.php";

if (!isset($_POST['idUsuario'])) {
  header('Location: ../pages/permissao.php');
  exit;
}
