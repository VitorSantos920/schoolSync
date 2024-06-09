<?php
include_once "../db/config.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura o e-mail do formulário e salva em uma variável
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    // Verifica se o e-mail é válido
    if ($email) {
        // Salva o e-mail em uma variável
        $emailRecuperacao = $email;
        // Retorna uma mensagem de sucesso para o JavaScript
        echo json_encode(array("status" => "success"));
    } else {
        // Retorna uma mensagem de erro para o JavaScript
        echo json_encode(array("status" => "invalid"));
    }
} else {
    // Retorna uma mensagem de erro para o JavaScript
    echo json_encode(array("status" => "error"));
}
