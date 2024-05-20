<?php

require_once '../db/config.php';

date_default_timezone_set('America/Sao_Paulo');



session_start();

if (!isset($_SESSION['email']) || $_SESSION['categoria'] != "Aluno") {

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

            /* ou border-right, dependendo do lado que você quer a linha */

            height: 100%px;

        }



        .linha-vertical2 {

            border-right: 3px solid lightgray;

            /* ou border-right, dependendo do lado que você quer a linha */

            height: 100%px;

        }



        .linha-horizontal {

            border: none;

            border-top: 3px solid lightgray;

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

    <?php

    include_once "../components/sidebarAluno.php";

    ?>

    <main>

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



            <div class="col-8 linha-vertical linha-vertical2">

                <h3>Média geral de nota: <?php echo number_format($media, 1); ?></h3>

                <h6>Gráfico de barras representando suas notas por disciplina</h6><br>

                <?php

                // Consulta SQL para recuperar as médias das notas do aluno em cada disciplina

                $notasPorDisciplina = DB::query("SELECT m.disciplina AS disciplina, AVG(nota) AS media_nota FROM nota n INNER JOIN materia m ON n.materia_id = m.id INNER JOIN aluno a ON n.aluno_id = a.id WHERE a.id = %i GROUP BY m.disciplina", $dadosAluno['aluno_id']);

                // Preparando dados para o gráfico

                $labels = array();

                $data = array();

                foreach ($notasPorDisciplina as $nota) {

                    $labels[] = $nota['disciplina'];

                    $data[] = $nota['media_nota'];
                }

                ?>

                <canvas id="graficoMediasNotas" height="120px"></canvas>

            </div>



            <?php

            // Consulta SQL para recuperar o total de faltas do aluno

            $totalFaltas = DB::queryFirstField("SELECT COUNT(*) FROM falta WHERE aluno_id = %i", $dadosAluno["aluno_id"]);

            ?>



            <div class="col-4 linha-vertical2">

                <h3>Total de faltas: <?php echo $totalFaltas; ?></h3>

                <h6>Faltas por Disciplina</h6>

                <?php

                $faltasPorDisciplina = DB::query("SELECT m.disciplina AS disciplina, COUNT(*) as total_faltas FROM falta f INNER JOIN materia m ON f.materia_id = m.id WHERE f.aluno_id = %i GROUP BY m.disciplina", $dadosAluno['aluno_id']);

                $faltasData = array();

                foreach ($faltasPorDisciplina as $falta) {

                    $faltasData[$falta['disciplina']] = $falta['total_faltas'];
                }

                ?>

                <canvas id="faltasPorDisciplina" height="250px"></canvas>

            </div>





            <hr class="linha-horizontal">

            <div class="col-4 linha-vertical"><br>

                <h4><img src="../assets/img/calendario.png" width="30px" alt="Ícone de calendário."> Próximas avaliações e eventos</h4>

                <h6>Acompanhe abaixo suas datas importantes. </h6><br>

                <?php

                // Consulta SQL para recuperar os recursos educacionais

                $eventosAluno = $dadosAluno["classe_id"]; // Supondo que a coluna com a escolaridade do aluno seja "escolaridade"

                // $eventos = DB::query("SELECT * FROM evento WHERE classe_id = %", $eventosAluno);

                $eventos = DB::query("SELECT * FROM evento");



                // Verificar se há recursos disponíveis

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

                        // Formatando a data de início

                        $inicio_formatado = date('d/m/Y', strtotime($evento["inicio"]));

                        echo '<h6>De: ' . $inicio_formatado . '</h6>';

                        echo '</div>';

                        echo '<div class="col-6">';

                        // Formatando a data de término

                        $termino_formatado = date('d/m/Y', strtotime($evento["termino"]));

                        echo '<h6>Até: ' . $termino_formatado . '</h6>';

                        echo '</div>';

                        echo '<hr class="linha-horizontal"><br>';

                        echo '</div>';
                    }
                } else {

                    echo '<p>Nenhum recurso educacional disponível no momento.</p>';
                }

                ?>



            </div>

            <div class="col-4 linha-vertical linha-vertical2"><br>

                <h4><img src="../assets/img/medalha.png" width="30px" alt="Ícone de medalha."> Conquistas escolares</h4>

                <h6>Visualize suas conquistas! </h6><br>

                <?php

                // Consulta SQL para recuperar as conquistas do aluno

                $conquistaAluno = $dadosAluno["aluno_id"]; // Supondo que a coluna com o ID do aluno seja "aluno_id"

                $conquistas = DB::query("SELECT * FROM conquista WHERE aluno_id = %i", $conquistaAluno);



                // Verificar se há conquistas disponíveis

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

                        // Formatando a data de conquista

                        $data_conquista_formatada = date('d/m/Y', strtotime($conquista["data_conquista"]));

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

            <div class="col-4 linha-vertical2"><br>

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

                        echo '<div class="col-8">';

                        echo '<h5>' . $recurso["descricao"] . '</h5>';

                        echo '</div>';

                        echo '<div class="col-4">';

                        echo '<a href="' . $recurso["url"] . '" target="_blank">Acessar</a>'; // Link para acessar o recurso

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
    // Dados das faltas por disciplina

    const faltasData = <?php echo json_encode($faltasData); ?>;



    // Obtenha o contexto do canvas

    const ctx = document.getElementById('faltasPorDisciplina').getContext('2d');



    // Crie o gráfico de barras

    const chart = new Chart(ctx, {

        type: 'bar',

        data: {

            labels: Object.keys(faltasData), // Nomes das disciplinas

            datasets: [{

                label: 'Faltas',

                data: Object.values(faltasData), // Quantidade de faltas

                backgroundColor: 'rgba(54, 162, 235, 0.5)', // Cor de preenchimento das barras

                borderColor: 'rgba(54, 162, 235, 1)', // Cor da borda das barras

                borderWidth: 1

            }]

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
    // Configuração do gráfico

    var ctx2 = document.getElementById('graficoMediasNotas').getContext('2d');

    var grafico = new Chart(ctx2, {

        type: 'bar',

        data: {

            labels: <?php echo json_encode($labels); ?>,

            datasets: [{

                label: 'Média das Notas',

                data: <?php echo json_encode($data); ?>,

                backgroundColor: 'rgba(54, 162, 235, 0.5)',

                borderColor: 'rgba(54, 162, 235, 1)',

                borderWidth: 1

            }]

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