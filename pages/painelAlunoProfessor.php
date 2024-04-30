<?php
// Inclua o arquivo que contém a definição da classe DB
require_once '../db/config.php';
date_default_timezone_set('America/Sao_Paulo');

$aluno_id = $_GET['aluno_id'];
$sql = DB::queryFirstRow('SELECT usuario_id FROM aluno WHERE id=%i', $aluno_id);
$usuario_id = $sql['usuario_id'];
$dados = DB::query('SELECT * FROM usuario WHERE id=%i', $usuario_id);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="icon" href="../assets/img/logo_transparente.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <title>Visualização de aluno</title>
</head>

<body>

    <div class="container">
        <h3><img src="../assets/img/maozinha.png" width="30px" alt="Ícone de mão dando saudação."> Olá!</h3>
        <h1>Confira o Desempenho Acadêmico de <?php echo $dados["nome"] ?></h1><br>

        <div class="row">
            <div class="col-8">
                <h3>Media geral de nota: 7,9.</h3>
                <h6>Gráfico de barras representando suas notas bimestrais por disciplina</h6><br>
                <canvas id="myChart" width="400" height="100"></canvas>
            </div>
            <div class="col-4 linha-vertical">
                <h3>Faltas no total: 17.</h3>
                <h6>Faltas por Disciplina</h6>
                <canvas id="myChart2" width="200" height="100"></canvas>
            </div>
            <hr class="linha-horizontal">
            <div class="col-6"><br>
                <h4>Agendar novo evento escolar</h4><br>
                <form action="processar_formulario_evento.php" method="post">

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
                <form action="processar_formulario_conquista.php" method="post">

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