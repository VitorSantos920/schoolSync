<?php
require_once "../db/config.php";
date_default_timezone_set('America/Sao_Paulo');
session_start();

if (!isset($_SESSION['id'])) {
  header('Location: ./index.php');
  exit;
}

$dadosUsuario = DB::queryFirstRow("SELECT * FROM usuario u WHERE u.id = %i", $_SESSION['id']);
