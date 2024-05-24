<?php

$servername = "15.235.9.101";
$username = "vfzzdvmy_school_sync";
$password = "L@QCHw9eKZ7yRxz";
$database = "vfzzdvmy_school_sync";

$conn = mysqli_connect($servername, $username, $password, $database);

$aluno_id = $_GET['aluno_id'];
$consulta1 = "SELECT usuario_id FROM aluno WHERE id=$aluno_id";
$resultado1 = mysqli_query($conn, $consulta1);
$fila1 = mysqli_fetch_assoc($resultado1);

$usuario_id = $fila1['usuario_id'];

$consulta2 = "SELECT * FROM usuario WHERE id=$usuario_id";
$resultado2 = mysqli_query($conn, $consulta2);
$fila2 = mysqli_fetch_assoc($resultado2);

$consultaMedia = "SELECT AVG(nota) as mediaMedia FROM nota WHERE aluno_id=$aluno_id";
$resultadoMedia = mysqli_query($conn, $consultaMedia);
$filaMedia = mysqli_fetch_assoc($resultadoMedia);

$consultaFalta = "SELECT COUNT(*) AS somaFalta FROM falta WHERE aluno_id=$aluno_id";
$resultadoFalta = mysqli_query($conn, $consultaFalta);
$filaFalta = mysqli_fetch_assoc($resultadoFalta);

$consultaEvento = "SELECT classe_id FROM aluno WHERE id = $aluno_id";
$resultadoFilaEvento = mysqli_query($conn, $consultaEvento);
if ($resultadoFilaEvento) {
    $filaEvento = mysqli_fetch_assoc($resultadoFilaEvento);
    $evento_classe_id = $filaEvento['classe_id'];
}

require_once '../db/config.php';
date_default_timezone_set('America/Sao_Paulo');

session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ./index.php');
    exit;
}

$dadosProfessor = DB::queryFirstRow("SELECT *, pr.id as 'prof_id' FROM usuario us INNER JOIN professor pr ON pr.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);

// Consulta SQL para recuperar as médias das notas do aluno em cada disciplina por bimestre
$notasPorDisciplinaBimestre = DB::query("
    SELECT m.disciplina AS disciplina, n.bimestre AS bimestre, AVG(n.nota) AS media_nota
    FROM nota n
    INNER JOIN materia m ON n.materia_id = m.id
    WHERE n.aluno_id = %i
    GROUP BY m.disciplina, n.bimestre
    ORDER BY m.disciplina, n.bimestre", $aluno_id);

// Preparando dados para o gráfico de notas por bimestre
$notasData = array();
$disciplinas = [];
foreach ($notasPorDisciplinaBimestre as $nota) {
    if (!in_array($nota['disciplina'], $disciplinas)) {
        $disciplinas[] = $nota['disciplina'];
    }
    if (!isset($notasData[$nota['bimestre']])) {
        $notasData[$nota['bimestre']] = array_fill_keys($disciplinas, null); // Inicializando todas as disciplinas com null
    }
    $notasData[$nota['bimestre']][$nota['disciplina']] = $nota['media_nota'];
}

// Consulta SQL para recuperar as faltas do aluno em cada disciplina por bimestre
$faltasPorDisciplinaBimestre = DB::query("
    SELECT m.disciplina AS disciplina, f.bimestre AS bimestre, COUNT(*) AS total_faltas
    FROM falta f
    INNER JOIN materia m ON f.materia_id = m.id
    WHERE f.aluno_id = %i
    GROUP BY m.disciplina, f.bimestre
    ORDER BY m.disciplina, f.bimestre", $aluno_id);

// Preparando dados para o gráfico de faltas por bimestre
$faltasData = array();
foreach ($faltasPorDisciplinaBimestre as $falta) {
    if (!isset($faltasData[$falta['bimestre']])) {
        $faltasData[$falta['bimestre']] = array_fill_keys($disciplinas, 0); // Inicializando todas as disciplinas com 0
    }
    $faltasData[$falta['bimestre']][$falta['disciplina']] = $falta['total_faltas'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="icon" href="../assets/img/logo_transparente.png">
    <link rel="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" />
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
            height: 100%;
        }

        .linha-vertical2 {
            border-right: 3px solid lightgray;
            height: 100%;
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
    <title>Visualização de aluno</title>
</head>

<body>
    <?php include_once "../components/sidebarProfessor.php"; ?>
    <main>
        <div class="container">
            <h3><img src="../assets/img/maozinha.png" width="30px" alt="Ícone de mão dando saudação."> Olá!</h3>
            <h1><?php echo "Confira o Desempenho Acadêmico de " . $fila2['nome']; ?></h1><br>

            <div class="row">
                <div class="col-8">
                    <h3><?php echo "Média geral de notas: " . number_format($filaMedia['mediaMedia'], 1); ?></h3>
                    <h6>Gráfico de barras representando suas notas por disciplina e bimestre</h6><br>
                    <canvas id="graficoMediasNotas" height="120px"></canvas>
                </div>
                <div class="col-4 linha-vertical"><br>
                    <h3><?php echo "Total de faltas: " . $filaFalta['somaFalta']; ?></h3>
                    <h6>Faltas por Disciplina e Bimestre</h6>
                    <canvas id="faltasPorDisciplina" height="250px"></canvas>
                </div>

                <hr class="linha-horizontal">

                <div class="col-6"><br>
                    <h4>Agendar novo evento escolar</h4><br>
                    <form action="processar_formulario_evento.php?professor_id=<?php echo $dadosProfessor['id'] ?>&classe_id=<?php echo $evento_classe_id ?>&aluno_id=<?php echo $aluno_id ?>" method="post">
                        <label for="titulo">Nome/Título do Evento:</label><br>
                        <input type="text" id="titulo" name="titulo" required><br><br>
                        <label for="descricao">Descrição do Evento:</label><br>
                        <textarea id="descricao" name="descricao" rows="4" cols="50" required></textarea><br><br>
                        <label for="data_inicio">Data de Início:</label><br>
                        <input type="date" id="data_inicio" name="data_inicio" required><br><br>
                        <label for="data_termino">Data de Término:</label><br>
                        <input type="date" id="data_termino" name="data_termino" required><br><br>
                        <input type="submit" value="Agendar Evento">
                    </form>
                </div>

                <div class="col-6 linha-vertical"><br>
                    <h4>Registrar nova conquista acadêmica</h4><br>
                    <form action="processar_formulario_conquista.php?professor_id=<?php echo $dadosProfessor["id"] ?>&aluno_id=<?php echo $aluno_id ?>" method="post">
                        <label for="titulo">Nome/Título da Conquista:</label><br>
                        <input type="text" id="titulo" name="titulo" required><br><br>
                        <label for="descricao">Descrição da Conquista:</label><br>
                        <textarea id="descricao" name="descricao" rows="4" cols="50" required></textarea><br><br>
                        <label for="data">Data:</label><br>
                        <input type="date" id="data" name="data" required><br><br>
                        <label for="comentarios">Comentários:</label><br>
                        <textarea id="comentarios" name="comentarios" rows="4" cols="50"></textarea><br><br>
                        <input type="submit" value="Registrar Conquista">
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

<script>
    // Dados das faltas por disciplina e bimestre
    const faltasData = <?php echo json_encode($faltasData); ?>;

    // Dados das notas por disciplina e bimestre
    const notasData = <?php echo json_encode($notasData); ?>;

    // Obtenha o contexto do canvas
    const ctxFaltas = document.getElementById('faltasPorDisciplina').getContext('2d');
    const ctxNotas = document.getElementById('graficoMediasNotas').getContext('2d');

    // Função para criar gráficos de barras empilhadas
    function criarGrafico(ctx, data, label, backgroundColors, borderColors) {
        const bimestres = ['1º Bimestre', '2º Bimestre', '3º Bimestre', '4º Bimestre'];
        const datasets = bimestres.map((bimestre, index) => {
            const dataset = {
                label: bimestre,
                data: [],
                backgroundColor: backgroundColors[index],
                borderColor: borderColors[index],
                borderWidth: 1
            };
            for (const disciplina of Object.keys(data[1])) {
                dataset.data.push(data[index + 1][disciplina] !== undefined ? data[index + 1][disciplina] : 0);
            }
            return dataset;
        });
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(data[1]),
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        stacked: true
                    }
                }
            }
        });
    }

    // Cores para os bimestres
    const backgroundColors = [
        'rgba(255, 165, 0, 0.5)', // Laranja claro
        'rgba(255, 140, 0, 0.5)', // Laranja
        'rgba(255, 120, 0, 0.5)', // Laranja mais escuro
        'rgba(255, 100, 0, 0.5)' // Laranja escuro
    ];

    const borderColors = [
        'rgba(255, 165, 0, 1)', // Laranja claro
        'rgba(255, 140, 0, 1)', // Laranja
        'rgba(255, 120, 0, 1)', // Laranja mais escuro
        'rgba(255, 100, 0, 1)' // Laranja escuro
    ];


    // Criando gráfico de faltas por disciplina e bimestre
    criarGrafico(ctxFaltas, faltasData, 'Faltas', backgroundColors, borderColors);

    // Criando gráfico de notas por disciplina e bimestre
    criarGrafico(ctxNotas, notasData, 'Média das Notas', backgroundColors, borderColors);
</script>

<script>