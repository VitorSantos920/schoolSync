<?php
require_once '../backend/init-configs.php';

if ($_SESSION['categoria'] != "Aluno" && $_SESSION['categoria'] != "Responsavel" && $_SESSION['categoria'] != "Administrador") {
    header('Location: ./index.php');
    exit;
}


$alunoId;
$sectionSaudacao = "";
$desempenhoAcademico = "";

if ($_SESSION['categoria'] == "Responsavel" && !isset($_GET['aluno_id'])) {
    header('Location: ./pagina-inicial-responsavel.php');
} elseif ($_SESSION['categoria'] == "Responsavel" && isset($_GET['aluno_id'])) {
    $alunoId = $_GET['aluno_id'];
    $nomeResponsavel = DB::queryFirstField("SELECT us.nome FROM aluno al INNER JOIN responsavel res ON al.responsavel_id = res.id INNER JOIN usuario us ON res.usuario_id = us.id WHERE al.id = %i", $alunoId);
    $nomeAluno = DB::queryFirstField("SELECT us.nome FROM aluno al INNER JOIN usuario us ON al.usuario_id = us.id WHERE al.id = %i", $alunoId);
    $desempenhoAcademico = "<h1>Desempenho Acadêmico de:  {$nomeAluno}</h1>";
} else {
    $alunoId = DB::queryFirstField("SELECT id FROM aluno WHERE usuario_id = %i", $dadosUsuario['id']);

    $sectionSaudacao = "
        <section class='saudacao d-flex align-items-center'>
            <img width='30' src='../assets/img/hand.svg' alt='Emoji de mão amarela acenando.'>
            <h2 class='saudacao__titulo'>Olá, {$dadosUsuario['nome']}!</h2>
        </section>
    ";
    $desempenhoAcademico = "<h1>Confira seu Desempenho Acadêmico</h1>";
}


$dadosAluno = DB::queryFirstRow(
    "SELECT *, al.id as 'aluno_id'
    FROM aluno al
    INNER JOIN responsavel res
      ON al.responsavel_id = res.id
    INNER JOIN usuario u
      ON al.usuario_id = u.id
    INNER JOIN usuario u_responsavel
      ON res.usuario_id = u_responsavel.id
    WHERE al.usuario_id = %i",
    $alunoId
);

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $dadosUsuario['nome'] ?> - Página Inicial do Aluno | SchoolSync</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/pages__pagina-inicial-aluno.css">
    <link rel="icon" href="../assets/img/logo_transparente.png">

</head>

<body>
    <div class="wrapper">
        <div class="content-wrapper">
            <?php
            include_once "../components/header.php";
            include_once "../components/sidebar.php"
            ?>

            <main>
                <?= $sectionSaudacao; ?>

                <h1><?= $desempenhoAcademico; ?></h1>
                <input type="hidden" id="id-aluno" value=<?= $alunoId ?> disabled>

                <div class="row">
                    <article class="col-7">
                        <h3>Média Geral de Notas: <span id="media-nota">7,9</span></h3>

                        <figure>
                            <figcaption>Gráfico de barras representando suas notas bimestrais por disciplina</figcaption>
                            <canvas id="grafico-medias-notas-disciplina" height="120"></canvas>
                        </figure>
                    </article>
                    <article class="col-5">
                        <h3>Faltas por Disciplina</h3>
                        <figure>
                            <figcaption>Gráfico de linhas representando suas suas faltas bimestrais por disciplina</figcaption>
                            <canvas id="grafico-medias-faltas-disciplina" height="150"></canvas>
                        </figure>
                    </article>
                </div>
                <div class="row">
                    <article class="avaliacoes col-4">
                        <header>
                            <h3>
                                <i class="fa-regular fa-newspaper"></i>
                                Próximas Avaliações
                            </h3>
                            <p>Acompanhe abaixo suas próximas avaliações da escola.</p>
                        </header>

                        <section>
                            <div class="avaliacoes__sobre">
                                <h4 class="avaliacoes__titulo">Prova 1 de Matemática</h4>
                                <p class="avaliacoes__data">06/05/2024</p>
                            </div>

                            <button class="btn">Detalhes</button>
                        </section>
                    </article>

                    <article class="agenda-escolar col-4">
                        <header>
                            <h3>
                                <i class="fa-regular fa-calendar"></i>
                                Agenda Escolar
                            </h3>
                            <p>Visualize abaixo o resumo da sua agenda escolar.</p>
                        </header>

                        <section>
                            <h4>Prova 1 de Matemática</h4>

                            <p>06/05/2024</->
                        </section>
                    </article>

                    <article class="materiais-apoio col-4">
                        <header>
                            <h3>
                                <i class="fa-regular fa-folder"></i>
                                Materiais de apoio
                            </h3>
                            <p>Acesse abaixo os recursos educacionais disponíveis. </p>
                        </header>

                        <section>
                            <h4>Prova 1 de Matemática</h4>

                            <p>06/05/2024</->
                        </section>
                    </article>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let idAluno = $('#id-aluno').val();

        $(document).ready(function() {
            carregarGraficoNotasDisciplina();
            carregarGraficoFaltasDisciplina();
        });

        function carregarGraficoNotasDisciplina() {
            $.ajax({
                type: 'POST',
                url: '../backend/aluno/retorna-dados-notas-disciplina.php',
                data: {
                    idAluno
                },
                success: function(response) {
                    response = JSON.parse(response)

                    let bimestres = new Array(Object.keys(response).length);
                    let labelsMaterias = []

                    Object.keys(response).forEach((bimestre, index) => {
                        bimestres[index] = response[bimestre];
                    });


                    bimestres.forEach((bimestre) => {
                        for (const key in bimestre) {
                            if (!labelsMaterias.includes(bimestre[key].nome_materia)) {
                                labelsMaterias.push(bimestre[key].nome_materia);
                            }
                        }
                    })

                    console.log(retornaDatasets(bimestres))

                    const data = {
                        labels: labelsMaterias,
                        datasets: retornaDatasets(bimestres)
                    };


                    const config = {
                        type: 'bar',
                        data: data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    min: 0,
                                    ticks: {
                                        stepSize: 2
                                    },
                                    max: 10,
                                    grid: {
                                        display: false
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }

                            },
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    align: 'start',
                                    labels: {
                                        boxHeight: 10,
                                        boxWidth: 10,
                                        usePointStyle: true,
                                        padding: 20
                                    }
                                },
                            }
                        }
                    };

                    let myChart = new Chart(
                        document.getElementById('grafico-medias-notas-disciplina').getContext('2d'),
                        config
                    );
                },
                error: function(error) {
                    console.log(error);
                }
            })


        }

        function retornaDatasets(bimestres) {
            const coresBimestres = ['#0DCAF0', '#3AD1EF', '#66D8EE', '#93DEEE'];
            let datasets = [];

            bimestres.forEach((bimestre, index) => {
                let medias = [];

                for (const key in bimestre) {
                    medias.push(bimestre[key].media);
                }

                datasets.push({
                    label: `${index + 1}° Bimestre`,
                    backgroundColor: coresBimestres[index],
                    data: medias
                });
            });

            return datasets;
        }

        function carregarGraficoFaltasDisciplina() {
            var ctx = document.getElementById('grafico-medias-faltas-disciplina').getContext('2d');
            var lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['1º Bimestre', '2º Bimestre', '3º Bimestre', '4º Bimestre'],
                    datasets: [{
                            label: 'Matemática',
                            data: [7, 8.5, 9, 8],
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'História',
                            data: [6.5, 7, 8.5, 9],
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'História',
                            data: [7.5, 8, 9.5, 19],
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'História',
                            data: [8.5, 9, 11, 12],
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: false,
                            tension: 0.1
                        },
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            align: 'start',

                            labels: {
                                boxHeight: 10,
                                boxWidth: 10,
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 2,
                            },

                            grid: {
                                display: false
                            }
                        },

                        x: {
                            grid: {

                                display: false
                            }
                        }
                    }
                }
            });

        }
    </script>
</body>

</html>