<?php

// Verifica se o formulário foi submetido

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifica se todos os campos foram preenchidos

    if (isset($_POST["titulo"]) && isset($_POST["descricao"]) && isset($_POST["data_inicio"]) && isset($_POST["data_termino"]) && isset($_GET["professor_id"]) && isset($_GET["classe_id"]) && isset($_GET["aluno_id"])) {

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

        $data_inicio = $_POST["data_inicio"];

        $data_termino = $_POST["data_termino"];

        $professor_id = $_GET["professor_id"];

        $classe_id = $_GET["classe_id"];

        $aluno_id = $_GET["aluno_id"];


        // Prepara a consulta SQL para inserir os dados do evento na tabela

        $sql = "INSERT INTO evento (titulo, descricao, inicio, termino, professor_id, classe_id) VALUES ('$titulo', '$descricao', '$data_inicio', '$data_termino', '$professor_id', '$classe_id')";

        // Executa a consulta SQL

        if (mysqli_query($conn, $sql)) {

            mysqli_close($conn);
            header("Location: painelAlunoProfessor.php?aluno_id=$aluno_id&success=1");
            exit;
        } else {

            echo "Erro ao agendar evento: " . mysqli_error($conn);
        }



        // Fecha a conexão com o banco de dados

        mysqli_close($conn);
    } else {

        echo "Todos os campos do formulário devem ser preenchidos.";
    }
} else {

    echo "O formulário não foi submetido.";
}