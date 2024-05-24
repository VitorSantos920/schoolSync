<?php

require_once '../db/config.php';

date_default_timezone_set('America/Sao_Paulo');

session_start();

if (!isset($_SESSION['email']) || $_SESSION['categoria'] != "Aluno") {
    header('Location: ./index.php');
    exit;
}

$dadosAluno = DB::queryFirstRow("SELECT *, al.id as 'aluno_id' FROM usuario us INNER JOIN aluno al ON al.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);

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

$dadosProfessor = DB::queryFirstRow("SELECT *, pr.id as 'prof_id' FROM usuario us INNER JOIN professor pr ON pr.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);


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
            height: 100%px;
        }

        .linha-vertical2 {
            border-right: 3px solid lightgray;
            height: 100%px;
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
    <title>Painel do aluno</title>
</head>

<body>
    <?php
    include_once "../components/sidebarAluno.php";
    ?>
    <main>
        <div class="container">
            <h3><img src="../assets/img/maozinha.png" width="30px" alt="Ícone de mão dando saudação."> Olá, <?php echo $dadosAluno["nome"] ?>!</h3>
            <h1>Confira seu desempenho acadêmico.</h1><br>

            <div class="row">
                <?php
                $notas = DB::query("SELECT nota FROM nota WHERE aluno_id = %i", $dadosAluno["aluno_id"]);

                $totalNotas = 0;
                $quantidadeNotas = count($notas);

                foreach ($notas as $nota) {
                    $totalNotas += $nota['nota'];
                }

                if ($quantidadeNotas > 0) {
                    $media = $totalNotas / $quantidadeNotas;
                } else {
                    $media = 0;
                }
                ?>

                <div class="col-8 linha-vertical2">
                    <h3>Média geral de nota: <?php echo number_format($media, 1); ?></h3>
                    <h6>Gráfico de barras representando suas notas por disciplina e bimestre</h6><br>
                    <?php
                    $notasPorDisciplinaEBimestre = DB::query("
                    SELECT 
                        m.disciplina AS disciplina, 
                        n.bimestre AS bimestre, 
                        AVG(nota) AS media_nota 
                    FROM nota n 
                    INNER JOIN materia m ON n.materia_id = m.id 
                    INNER JOIN aluno a ON n.aluno_id = a.id 
                    WHERE a.id = %i 
                    GROUP BY m.disciplina, n.bimestre
                ", $dadosAluno['aluno_id']);

                    $disciplinas = array();
                    $bimestres = array(1, 2, 3, 4);
                    $dataPorDisciplina = array();

                    foreach ($notasPorDisciplinaEBimestre as $nota) {
                        if (!in_array($nota['disciplina'], $disciplinas)) {
                            $disciplinas[] = $nota['disciplina'];
                        }
                        $dataPorDisciplina[$nota['disciplina']][$nota['bimestre']] = $nota['media_nota'];
                    }

                    foreach ($disciplinas as $disciplina) {
                        foreach ($bimestres as $bimestre) {
                            if (!isset($dataPorDisciplina[$disciplina][$bimestre])) {
                                $dataPorDisciplina[$disciplina][$bimestre] = 0;
                            }
                        }
                    }

                    $datasets = array();
                    foreach ($bimestres as $bimestre) {
                        $data = array();
                        foreach ($disciplinas as $disciplina) {
                            $data[] = $dataPorDisciplina[$disciplina][$bimestre];
                        }
                        $datasets[] = array(
                            'label' => 'Bimestre ' . $bimestre,
                            'data' => $data,
                            'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                            'borderColor' => 'rgba(54, 162, 235, 1)',
                            'borderWidth' => 1
                        );
                    }
                    ?>
                    <canvas id="graficoMediasNotas" height="120px"></canvas>
                </div>

                <?php
                $totalFaltas = DB::queryFirstField("SELECT COUNT(*) FROM falta WHERE aluno_id = %i", $dadosAluno["aluno_id"]);
                ?>

                <div class="col-4">
                    <h3>Total de faltas: <?php echo $totalFaltas; ?></h3>
                    <h6>Faltas por Disciplina e Bimestre</h6>
                    <?php
                    $faltasPorDisciplinaEBimestre = DB::query("
                    SELECT 
                        m.disciplina AS disciplina, 
                        f.bimestre AS bimestre, 
                        COUNT(*) AS total_faltas 
                    FROM falta f 
                    INNER JOIN materia m ON f.materia_id = m.id 
                    WHERE f.aluno_id = %i 
                    GROUP BY m.disciplina, f.bimestre
                ", $dadosAluno['aluno_id']);

                    $faltasPorDisciplina = array();

                    foreach ($faltasPorDisciplinaEBimestre as $falta) {
                        if (!isset($faltasPorDisciplina[$falta['disciplina']])) {
                            $faltasPorDisciplina[$falta['disciplina']] = array();
                        }
                        $faltasPorDisciplina[$falta['disciplina']][$falta['bimestre']] = $falta['total_faltas'];
                    }

                    foreach ($faltasPorDisciplina as $disciplina => $faltas) {
                        foreach ($bimestres as $bimestre) {
                            if (!isset($faltasPorDisciplina[$disciplina][$bimestre])) {
                                $faltasPorDisciplina[$disciplina][$bimestre] = 0;
                            }
                        }
                    }

                    $datasetsFaltas = array();
                    foreach ($bimestres as $bimestre) {
                        $data = array();
                        foreach ($faltasPorDisciplina as $disciplina => $faltas) {
                            $data[] = $faltas[$bimestre];
                        }
                        $datasetsFaltas[] = array(
                            'label' => 'Bimestre ' . $bimestre,
                            'data' => $data,
                            'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                            'borderColor' => 'rgba(255, 99, 132, 1)',
                            'borderWidth' => 1
                        );
                    }
                    ?>
                    <canvas id="faltasPorDisciplinaBimestre" height="250px"></canvas>
                </div>

                <hr class="linha-horizontal">
                <div class="col-4"><br>
                    <h4><img src="../assets/img/calendario.png" width="30px" alt="Ícone de calendário."> Próximas avaliações e eventos</h4>
                    <h6>Acompanhe abaixo suas datas importantes. </h6><br>
                    <?php
                    $eventosAluno = $dadosAluno["classe_id"];
                    $eventos = DB::query("SELECT * FROM evento WHERE classe_id = %i ORDER BY inicio DESC LIMIT 4", $eventosAluno);

                    if ($eventos) {
                        foreach ($eventos as $evento) {
                            echo '<div class="row">';
                            echo '<div class="col-12">';
                            echo '<h5>' . $evento["titulo"] . '</h5>';
                            echo '</div>';
                            echo '<div class="col-12">';
                            echo '<h6>' . $evento["descricao"] . '</h6>';
                            echo '</div>';
                            echo '<div class="col-6">';
                            echo '<br>';
                            $inicio_formatado = date('d/m/Y', strtotime($evento["inicio"]));
                            echo '<h6>De: ' . $inicio_formatado . '</h6>';
                            echo '</div>';
                            echo '<div class="col-6">';
                            echo '<br>';
                            $termino_formatado = date('d/m/Y', strtotime($evento["termino"]));
                            echo '<h6>Até: ' . $termino_formatado . '</h6>';
                            echo '</div>';
                            echo '<hr class="linha-horizontal"><br>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Nenhum evento disponível no momento.</p>';
                    }
                    ?>
                </div>

                <div class="col-4 linha-vertical linha-vertical2"><br>
                    <h4><img src="../assets/img/medalha.png" width="30px" alt="Ícone de medalha."> Conquistas escolares</h4>
                    <h6>Visualize suas conquistas! </h6><br>
                    <?php
                    $conquistaAluno = $dadosAluno["aluno_id"];
                    $conquistas = DB::query("SELECT * FROM conquista WHERE aluno_id = %i ORDER BY data_conquista DESC LIMIT 4", $conquistaAluno);

                    if ($conquistas) {
                        foreach ($conquistas as $conquista) {
                            echo '<div class="row">';
                            echo '<div class="col-12">';
                            echo '<h5>' . $conquista["titulo"] . '</h5>';
                            echo '</div>';
                            echo '<div class="col-12">';
                            echo '<h6>' . $conquista["descricao"] . '</h6>';
                            echo '</div>';
                            echo '<div class="col-12">';
                            $data_conquista_formatada = date('d/m/Y', strtotime($conquista["data_conquista"]));
                            echo '<br>';
                            echo '<h6>Alcançada em: ' . $data_conquista_formatada . '</h6>';
                            echo '</div>';
                            echo '<hr class="linha-horizontal"><br>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Nenhuma conquista disponível no momento.</p>';
                    }
                    ?>
                </div>

                <div class="col-4"><br>
                    <h4><img src="../assets/img/pasta.png" width="30px" alt="Ícone de mão dando saudação."> Materiais de apoio</h4>
                    <h6>Acesse abaixo os recursos educacionais disponíveis. </h6><br>
                    <?php
                    $escolaridadeAluno = $dadosAluno["escolaridade"];
                    $recursos = DB::query("SELECT * FROM recurso_educacional WHERE escolaridade = %s ORDER BY created_at DESC LIMIT 4", $escolaridadeAluno);

                    if ($recursos) {
                        foreach ($recursos as $recurso) {
                            echo '<div class="row">';
                            echo '<div class="col-8">';
                            echo '<h5>' . $recurso["titulo"] . '</h5>';
                            echo '</div>';
                            echo '<div class="col-8">';
                            echo '<h6>' . $recurso["descricao"] . '</h6>';
                            echo '</div>';
                            echo '<div class="col-4">';
                            echo '<a href="' . $recurso["url"] . '" target="_blank"><Strong>Acessar</Strong></a>';
                            echo '</div>';
                            echo '<hr class="linha-horizontal"><br>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Nenhum recurso educacional disponível no momento.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
</body>

<script>
    const faltasData = <?php echo json_encode($faltasPorDisciplina); ?>;
    const disciplinas = <?php echo json_encode(array_keys($faltasPorDisciplina)); ?>;
    const bimestres = [1, 2, 3, 4];

    const datasetsFaltas = bimestres.map(bimestre => {
        return {
            label: `Bimestre ${bimestre}`,
            data: disciplinas.map(disciplina => faltasData[disciplina][bimestre] || 0),
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        };
    });

    const ctxFaltas = document.getElementById('faltasPorDisciplinaBimestre').getContext('2d');

    const chartFaltas = new Chart(ctxFaltas, {
        type: 'bar',
        data: {
            labels: disciplinas,
            datasets: datasetsFaltas
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

<script>
    var ctx2 = document.getElementById('graficoMediasNotas').getContext('2d');
    var grafico = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($disciplinas); ?>,
            datasets: <?php echo json_encode($datasets); ?>
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

</html>