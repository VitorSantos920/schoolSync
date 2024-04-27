<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['professor_id'])) {
    // Se não estiver logado, redirecionar para a página de login
    header("Location: index.php");
    exit();
}

// Capturar o id_professor do usuário logado
$professor_id = $_SESSION['professor_id'];

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Conexão com o banco de dados (substitua as credenciais conforme necessário)
    $servername = "localhost"; // Nome do servidor
    $username = "root"; // Nome de usuário do banco de dados
    $password = ""; // Senha do banco de dados
    $dbname = "school_sync"; // Nome do banco de dados

    $conn = new mysqli($servername, $username, $password, $database);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Recupera os dados do formulário
    $titulo = $_POST["titulo"];
    $descricao = $_POST["descricao"];
    $data_inicio = $_POST["data_inicio"];
    $data_termino = $_POST["data_termino"];
    // Adicione mais campos conforme necessário

    // Query SQL para inserir dados na tabela evento
    $sql = "INSERT INTO evento (titulo, descricao, data_inicio, data_termino, professor_id) VALUES ('$titulo', '$descricao', '$data_inicio', '$data_termino' '$professor_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo evento criado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}

// Redireciona de volta para a página original após o processamento do formulário
header("Location: painelAlunoProfessor.php");
exit();
