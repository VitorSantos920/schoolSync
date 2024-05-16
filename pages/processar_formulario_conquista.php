<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos foram preenchidos
    if (isset($_POST["titulo"]) && isset($_POST["descricao"]) && isset($_POST["data"]) && isset($_POST["comentarios"]) && isset($_GET["professor_id"]) && isset($_GET["aluno_id"])) {
        // Conecta-se ao banco de dados
        $servername = "15.235.9.101";
        $username = "vfzzdvmy_school_sync";
        $password = "L@QCHw9eKZ7yRxz";
        $database = "vfzzdvmy_school_sync";
        $conn = mysqli_connect($servername, $username, $password, $database);

        // Verifica se a conexão foi bem sucedida
        if (!$conn) {
            die("Erro de conexão: " . mysqli_connect_error());
        }

        // Obtém os valores do formulário
        $titulo = $_POST["titulo"];
        $descricao = $_POST["descricao"];
        $data = $_POST["data"];
        $comentarios = $_POST["comentarios"];
        $professor_id = $_GET["professor_id"];
        $aluno_id = $_GET["aluno_id"];

        // Prepara a consulta SQL para inserir os dados da conquista acadêmica na tabela
        $sql = "INSERT INTO conquista (aluno_id, professor_id, titulo, descricao, data_conquista, comentario) VALUES ('$aluno_id', '$professor_id', '$titulo', '$descricao', '$data', '$comentarios')";
        echo $sql;
        // Executa a consulta SQL
        if (mysqli_query($conn, $sql)) {
            echo "Conquista registrada com sucesso!";
        } else {
            echo "Erro ao registrar conquista: " . mysqli_error($conn);
        }

        // Fecha a conexão com o banco de dados
        mysqli_close($conn);
    } else {
        echo "Todos os campos do formulário devem ser preenchidos.";
    }
} else {
    echo "O formulário não foi submetido.";
}
// Verifica se a variável HTTP_REFERER está definida e não está vazia
if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
    // Redireciona o usuário de volta para a mesma URL exata de onde a solicitação foi feita
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    // Se a variável HTTP_REFERER não estiver presente, redireciona o usuário para uma URL padrão
    header("Location: index.php"); // Substitua "pagina_principal.php" pela URL desejada
    exit;
}
