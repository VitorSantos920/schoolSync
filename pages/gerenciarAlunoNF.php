<?php
$servername = "15.235.9.101";
$username = "vfzzdvmy_school_sync";
$password = "L@QCHw9eKZ7yRxz";
$database = "vfzzdvmy_school_sync";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$aluno_id = $_GET['aluno_id'];
$materia_id = $_GET['materia_id'];

$consulta1 = "SELECT usuario_id FROM aluno WHERE id=$aluno_id";
$resultado1 = mysqli_query($conn, $consulta1);
$fila1 = mysqli_fetch_assoc($resultado1);
$usuario_id = $fila1['usuario_id'];
$consulta2 = "SELECT * FROM usuario WHERE id=$usuario_id";
$resultado2 = mysqli_query($conn, $consulta2);
$fila2 = mysqli_fetch_assoc($resultado2);

$sql2 = "SELECT disciplina FROM materia WHERE id=$materia_id";
$resultadoMateria = mysqli_query($conn, $sql2);
$materia = mysqli_fetch_assoc($resultadoMateria)['disciplina'];

mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="icon" href="../assets/img/logo_transparente.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js"></script>
    <style>
        .container {
            width: 100%;
            margin: 15px auto;
        }

        .linha-vertical {
            border-left: 3px solid lightgray;
            height: 130%;
        }

        .linha-horizontal {
            border: none;
            border-top: 3px solid lightgray;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        body {
            font-family: Poppins;
        }
    </style>
    <title>Controle de notas/falta</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="row">
                <?php include_once "../components/sidebarProfessor.php"; ?>
                <h1>Aluno(a): <?php echo $fila2['nome']; ?></h1>
                <h1>Controle da matéria: <?php echo $materia; ?></h1>
                <hr>
                <div class="col-6"><br>
                    <h4>Adicionar nota</h4><br>
                    <form action="processar_formulario_gerenciar_nota.php?aluno_id=<?php echo $aluno_id ?>&materia_id=<?php echo $materia_id ?>" method="post">
                        <label for="titulo">Nome/Título da avaliação:</label><br>
                        <input type="text" id="titulo" name="titulo" required><br><br>

                        <label for="data_avaliacao">Data da avaliação:</label><br>
                        <input type="date" id="data_avaliacao" name="data_avaliacao" required><br><br>

                        <label for="nota">Nota:</label><br>
                        <input type="number" id="nota" name="nota" step="0.01" required><br><br>

                        <label for="observacoes">Observações:</label><br>
                        <textarea id="observacoes" name="observacoes" rows="4" cols="50"></textarea><br><br>

                        <label for="bimestre">Bimestre:</label><br>
                        <select id="bimestre" name="bimestre" required>
                            <option value="1">1º Bimestre</option>
                            <option value="2">2º Bimestre</option>
                            <option value="3">3º Bimestre</option>
                            <option value="4">4º Bimestre</option>
                        </select><br><br>

                        <input type="submit" value="Registrar nota">
                    </form>
                </div>

                <div class="col-6 linha-vertical"><br>
                    <h4>Adicionar falta</h4><br>
                    <form action="processar_formulario_gerenciar_falta.php?aluno_id=<?php echo $aluno_id ?>&materia_id=<?php echo $materia_id ?>" method="post">
                        <label for="motivo">Motivo:</label><br>
                        <textarea id="motivo" name="motivo" rows="4" cols="50" required></textarea><br><br>

                        <label for="bimestre">Bimestre:</label><br>
                        <select id="bimestre" name="bimestre" required>
                            <option value="1">1º Bimestre</option>
                            <option value="2">2º Bimestre</option>
                            <option value="3">3º Bimestre</option>
                            <option value="4">4º Bimestre</option>
                        </select><br><br>

                        <label for="data_falta">Data da ausência:</label><br>
                        <input type="date" id="data_falta" name="data_falta" required><br><br>

                        <input type="submit" value="Registrar ausência">
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>

<script>
    // Verifica se a URL possui o parâmetro "success" igual a 1 e exibe o alerta
    window.onload = function() {
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') == 1) {
            alert("Nota/Falta registrada com sucesso!");
        }
    };
</script>