<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos foram preenchidos
    if (isset($_POST["motivo"]) && isset($_POST["data_falta"]) && isset($_POST["bimestre"]) && isset($_GET["aluno_id"]) && isset($_GET["materia_id"])) {

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
        $motivo = $_POST["motivo"];
        $data_falta = $_POST["data_falta"];
        $bimestre = $_POST["bimestre"];
        $aluno_id = $_GET["aluno_id"];
        $materia_id = $_GET["materia_id"];
        $created_at = date('Y-m-d H:i:s'); // Pega a data e hora atual

        // Prepara a consulta SQL para inserir os dados na tabela `falta`
        $sql = "INSERT INTO falta (aluno_id, materia_id, data_falta, motivo, created_at, bimestre) VALUES ('$aluno_id', '$materia_id', '$data_falta', '$motivo', '$created_at', '$bimestre')";

        // Executa a consulta SQL
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            header("Location: gerenciarAlunoNF.php?aluno_id=$aluno_id&materia_id=$materia_id&success=1");
            exit;
        } else {
            echo "Erro ao registrar falta: " . mysqli_error($conn);
        }

        // Fecha a conexão com o banco de dados
        mysqli_close($conn);
    } else {
        echo "Todos os campos do formulário devem ser preenchidos.";
    }
} else {
    echo "O formulário não foi submetido.";
}