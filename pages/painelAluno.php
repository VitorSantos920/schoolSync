<?php
require_once '../db/config.php';
date_default_timezone_set('America/Sao_Paulo');

session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ./index.php');
    exit;
}

$dadosAluno = DB::queryFirstRow("SELECT *, al.id as 'aluno_id' FROM usuario us INNER JOIN aluno al ON al.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/global.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="../assets/img/logo_transparente.png">
    <link rel="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" />
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
            border-left: 1px solid gray;
            /* ou border-right, dependendo do lado que você quer a linha */
            height: 25vh;
        }

        .linha-horizontal {
            border: none;
            border-top: 1px solid black;
            /* ou border-bottom, dependendo do lado que você quer a linha */
            margin: 0;
            /* Remova as margens */
            padding: 0;
            /* Remova os preenchimentos */
            width: 100%;
            /* Define a largura para ocupar toda a largura da div pai */
        }

        body {
            font-family: Poppins;
        }
    </style>
    <title>Painel do aluno</title>
</head>

<body>

    <div class="container">
        <h3><img src="../assets/img/maozinha.png" width="30px" alt="Ícone de mão dando saudação."> Olá, <?php echo $dadosAluno["nome"] ?></h3>
        <h1>Confira seu desempenho acadêmico.</h1><br>

        <div class="row">
            <?php
            // Consulta SQL para recuperar as notas do aluno
            $notas = DB::query("SELECT nota FROM nota WHERE aluno_id = %i", $dadosAluno["aluno_id"]);

            // Inicializa variáveis para o cálculo da média
            $totalNotas = 0;
            $quantidadeNotas = count($notas);

            // Soma todas as notas
            foreach ($notas as $nota) {
                $totalNotas += $nota['nota'];
            }

            // Calcula a média
            if ($quantidadeNotas > 0) {
                $media = $totalNotas / $quantidadeNotas;
            } else {
                $media = 0;
            }
            ?>

            <div class="col-8">
                <h3>Média geral de nota: <?php echo number_format($media, 1); ?></h3>
                <h6>Gráfico de barras representando suas notas bimestrais por disciplina</h6><br>
                <canvas id="myChart" width="400" height="100"></canvas>
            </div>

            <?php
            // Consulta SQL para recuperar o total de faltas do aluno
            $totalFaltas = DB::queryFirstField("SELECT COUNT(*) FROM falta WHERE aluno_id = %i", $dadosAluno["aluno_id"]);
            ?>

            <div class="col-4 linha-vertical">
                <h3>Total de faltas: <?php echo $totalFaltas; ?></h3>
                <h6>Faltas por Disciplina</h6>
                <canvas id="myChart2" width="200" height="100"></canvas>
            </div>

            <hr class="linha-horizontal">
            <div class="col-4"><br>
                <h4><img src="../assets/img/arquivo.png" width="30px" alt="Ícone de mão dando saudação.">Próximas avaliações</h4>
                <h6>Acompanhe abaixo suas próximas avaliações da escola.</h6><br>
                <div class="row">
                    <div class="col-8">
                        <h5>Prova de História</h5>
                        <h6>24/04/2024</h6>
                    </div>
                    <div class="col-4">
                        <h6>Detalhes</h6>
                    </div>
                    <hr class="linha-horizontal"><br>
                </div>
                <div class="row">
                    <div class="col-8">
                        <h5>Prova de Matemática</h5>
                        <h6>24/04/2024</h6>
                    </div>
                    <div class="col-4">
                        <h6>Detalhes</h6>
                    </div>
                    <hr class="linha-horizontal"><br>
                </div>
            </div>
            <div class="col-4 linha-vertical"><br>
                <h4><img src="../assets/img/calendario.png" width="30px" alt="Ícone de mão dando saudação."> Agenda escolar</h4>
                <h6>Visualize o resumo da sua agenda escolar.</h6><br><br>
                <div class="row">
                    <div class="col-8">
                        <h5>Primeira fase da OBMEP</h5>
                    </div>
                    <div class="col-4">
                        <h6>24/04/2024</h6>
                    </div>
                    <hr class="linha-horizontal"><br>
                </div>
                <div class="row">
                    <div class="col-8">
                        <h5>Segunda fase da OBMEP</h5>
                    </div>
                    <div class="col-4">
                        <h6>24/04/2024</h6>
                    </div>
                    <hr class="linha-horizontal"><br>
                </div>
            </div>
            <div class="col-4 linha-vertical"><br>
                <h4><img src="../assets/img/pasta.png" width="30px" alt="Ícone de mão dando saudação."> Materiais de apoio</h4>
                <h6>Acesse abaixo os recursos educacionais disponíveis. </h6><br>
                <?php
                // Consulta SQL para recuperar os recursos educacionais
                $escolaridadeAluno = $dadosAluno["escolaridade"]; // Supondo que a coluna com a escolaridade do aluno seja "escolaridade"
                $recursos = DB::query("SELECT * FROM recurso_educacional WHERE escolaridade = %s", $escolaridadeAluno);


                // Verificar se há recursos disponíveis
                if ($recursos) {
                    foreach ($recursos as $recurso) {
                        echo '<div class="row">';
                        echo '<div class="col-8">';
                        echo '<h5>' . $recurso["titulo"] . '</h5>';
                        echo '</div>';
                        echo '<div class="col-4">';
                        echo '<a href="' . $recurso["url"] . '">Acessar</a>'; // Link para acessar o recurso
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

</body>
<script>
    var ctx = document.getElementById("myChart2").getContext("2d");
    var myChart2 = new Chart(ctx, {
        type: "line",
        data: {
            labels: [
                "1° Bimestre",
                "2° Bimestre",
                "3° Bimestre",
                "4° Bimestre",
            ],
            datasets: [{
                    label: "Matemática",
                    data: [2, 9, 3, 17],
                    backgroundColor: "rgba(153,205,1,0.6)",

                },
                {
                    label: "História",
                    data: [2, 2, 5, 5],
                    backgroundColor: "rgba(155,153,10,0.6)",
                },
            ],
        },
    });
</script>
<script>
    // Dados do gráfico
    const data = {
        labels: ['História', 'Matemática', 'Geografia'],
        datasets: [{
                label: '1° Bimestre', // barra vermelha
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: [80, 70, 85]
            },
            {
                label: '2° Bimestre', //barra azul
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: [75, 85, 90]
            },
            {
                label: '3° Bimestre', // barra amarela
                backgroundColor: 'rgba(255, 206, 86, 0.5)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1,
                data: [70, 80, 75]
            },
            {
                label: '4° Bimestre', //barra verde
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                data: [85, 90, 80]
            }
        ]
    };

    // Configurações do gráfico
    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Criação do gráfico
    var myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>

</html>