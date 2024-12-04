<?php
require_once '../backend/init-configs.php';

if ($_SESSION['categoria'] != "Professor") {
    header('Location: ./permissao.php');
    exit;
}

$alunoId = $_GET['id_aluno'];

if (!isset($alunoId) && $_SESSION['categoria'] == "Professor") {
    header('Location: ./pagina-inicial-professor.php');
    exit;
}

$dadosAluno = DB::queryFirstRow("SELECT *, al.id as 'id_aluno' FROM aluno al INNER JOIN usuario us ON al.usuario_id = us.id WHERE al.id = %i", $alunoId);



// $dadosProfessor = DB::queryFirstRow("SELECT *, pr.id as 'prof_id' FROM usuario us INNER JOIN professor pr ON pr.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);

// // Obter todas as disciplinas
// $disciplinasDisponiveis = DB::query("SELECT DISTINCT disciplina FROM materia");

// // Consulta SQL para recuperar as médias das notas do aluno em cada disciplina por bimestre
// $notasPorDisciplinaBimestre = DB::query("
//     SELECT m.disciplina AS disciplina, n.bimestre AS bimestre, AVG(n.nota) AS media_nota
//     FROM nota n
//     INNER JOIN materia m ON n.materia_id = m.id
//     WHERE n.aluno_id = %i
//     GROUP BY m.disciplina, n.bimestre
//     ORDER BY m.disciplina, n.bimestre", $aluno_id);

// // Preparando dados para o gráfico de notas por bimestre
// $notasData = [];
// $disciplinas = [];
// foreach ($disciplinasDisponiveis as $disciplina) {
//     $disciplinas[] = $disciplina['disciplina'];
// }
// for ($bimestre = 1; $bimestre <= 4; $bimestre++) {
//     foreach ($disciplinas as $disciplina) {
//         if (!isset($notasData[$bimestre])) {
//             $notasData[$bimestre] = [];
//         }
//         $notasData[$bimestre][$disciplina] = 0; // Inicializa com zero
//     }
// }
// foreach ($notasPorDisciplinaBimestre as $nota) {
//     $notasData[$nota['bimestre']][$nota['disciplina']] = $nota['media_nota'];
// }

// // Consulta SQL para recuperar as faltas do aluno em cada disciplina por bimestre
// $faltasPorDisciplinaBimestre = DB::query("
//     SELECT m.disciplina AS disciplina, f.bimestre AS bimestre, COUNT(*) AS total_faltas
//     FROM falta f
//     INNER JOIN materia m ON f.materia_id = m.id
//     WHERE f.aluno_id = %i
//     GROUP BY m.disciplina, f.bimestre
//     ORDER BY m.disciplina, f.bimestre", $aluno_id);

// // Preparando dados para o gráfico de faltas por bimestre
// $faltasData = [];
// for ($bimestre = 1; $bimestre <= 4; $bimestre++) {
//     foreach ($disciplinas as $disciplina) {
//         if (!isset($faltasData[$bimestre])) {
//             $faltasData[$bimestre] = [];
//         }
//         $faltasData[$bimestre][$disciplina] = 0; // Inicializa com zero
//     }
// }
// foreach ($faltasPorDisciplinaBimestre as $falta) {
//     $faltasData[$falta['bimestre']][$falta['disciplina']] = $falta['total_faltas'];
// }


// mysqli_close($conn);

// // Debug dos dados
// echo "<script>console.log(" . json_encode($notasData) . ");</script>";
// echo "<script>console.log(" . json_encode($faltasData) . ");</script>";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/logo_transparente.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets//css/pages__pagina-inicial-aluno-professor.css">
    <title>Visualização do Perfil do Aluno - Professor | SchoolSync</title>
</head>

<body>
    <div class="wrapper">
        <?php
        include_once "../components/sidebar.php";
        include_once "../components/header.php";
        ?>
        <main>
            <h1 class="mb-3">Confira o Desempenho Acadêmico de: <?= $dadosAluno['nome'] ?></h1>
            <input type="hidden" id="id-aluno" value=<?= $alunoId ?> disabled>
            <div class="row">
                <article class="col-7">
                    <h2>Média Geral de Notas: <span id="media-nota">7,9</span></h2>

                    <figure>
                        <figcaption>Gráfico de barras representando suas notas bimestrais por disciplina</figcaption>
                        <canvas id="grafico-medias-notas-disciplina" height="292" width="730" style="display: block; box-sizing: border-box; height: 292px; width: 730px;"></canvas>
                    </figure>
                </article>
                <article class="col-5">
                    <h2>Faltas por Disciplina</h2>
                    <figure>
                        <figcaption>Gráfico de linhas representando suas suas faltas bimestrais por disciplina</figcaption>
                        <canvas id="grafico-medias-faltas-disciplina" height="257" width="514" style="display: block; box-sizing: border-box; height: 257px; width: 514px;"></canvas>
                    </figure>
                </article>
            </div>
            <div class="row">
                <article class="avaliacoes col-6" aria-labelledby="titulo-agendar-evento-escolar">
                    <header>
                        <h2 id="titulo-agendar-evento-escolar">
                            <svg class="svg-inline--fa fa-newspaper" aria-hidden="true" focusable="false" data-prefix="far" data-icon="newspaper" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor" d="M168 80c-13.3 0-24 10.7-24 24l0 304c0 8.4-1.4 16.5-4.1 24L440 432c13.3 0 24-10.7 24-24l0-304c0-13.3-10.7-24-24-24L168 80zM72 480c-39.8 0-72-32.2-72-72L0 112C0 98.7 10.7 88 24 88s24 10.7 24 24l0 296c0 13.3 10.7 24 24 24s24-10.7 24-24l0-304c0-39.8 32.2-72 72-72l272 0c39.8 0 72 32.2 72 72l0 304c0 39.8-32.2 72-72 72L72 480zM176 136c0-13.3 10.7-24 24-24l96 0c13.3 0 24 10.7 24 24l0 80c0 13.3-10.7 24-24 24l-96 0c-13.3 0-24-10.7-24-24l0-80zm200-24l32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80l32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zM200 272l208 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-208 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80l208 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-208 0c-13.3 0-24-10.7-24-24s10.7-24 24-24z"></path>
                            </svg><!-- <i class="fa-regular fa-newspaper"></i> Font Awesome fontawesome.com -->
                            Agendar novo evento escolar ao aluno
                        </h2>
                    </header>

                    <section>
                        <form id="form-agendar-evento">
                            <input type="hidden" name="classe-evento" id="classe-evento" value=<?= $dadosAluno['classe_id'] ?> disabled />
                            <fieldset>
                                <label for="nome-evento" class="form-label">Nome/Título do Evento</label>
                                <input type="text" name="nome-evento" id="nome-evento" class="form-control" placeholder="Olimpíada Brasileira de Matemática">
                            </fieldset>

                            <fieldset>
                                <label for="descricao-evento" class="form-label">Descrição do Evento</label>
                                <textarea class="form-control" name="descricao-evento" id="descricao-evento" cols="30" rows="5" placeholder="Digite aqui a descrição do evento..."></textarea>
                            </fieldset>

                            <fieldset class="data-inicio-fim">
                                <div>
                                    <label for="data-inicio" class="form-label">Data de Início</label>
                                    <input class="form-control" type="datetime-local" name="data-inicio" id="data-inicio">
                                </div>

                                <div>
                                    <label for="data-fim" class="form-label">Data de Término</label>
                                    <input class="form-control" type="datetime-local" name="data-fim" id="data-fim">
                                </div>
                            </fieldset>
                            <button type="button" class="btn btn-success" onclick="agendarEventoEscolar()">Agendar Evento</button>
                        </form>
                    </section>
                </article>

                <article class="agenda-escolar col-6" aria-labelledby="titulo-registrar-conquista">
                    <header>
                        <h2 id="titulo-registrar-conquista">
                            <i class="fa-solid fa-trophy"></i><!-- <i class="fa-regular fa-calendar"></i> Font Awesome fontawesome.com -->
                            Registrar nova conquista acadêmica ao aluno
                        </h2>
                    </header>

                    <section>
                        <form id="form-registar-conquista-academica" method="post">
                            <fieldset>
                                <label class="form-label" for="titulo">Nome/Título da Conquista</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="2° Lugar na Olimpíada Brasileira de Matemática" required>
                            </fieldset>

                            <fieldset>
                                <label class="form-label" for="descricao">Descrição da Conquista</label>
                                <textarea id="descricao" class="form-control" name="descricao" rows="4" cols="50" placeholder="Insira uma descrição sobre a conquista..." required></textarea>
                            </fieldset>

                            <fieldset>
                                <label class="form-label" for="data">Data da Conquista</label>
                                <input type="date" class="form-control" id="data" name="data" required>
                            </fieldset>

                            <fieldset>
                                <label class="form-label" for="comentarios">Comentários</label>
                                <textarea id="comentarios" class="form-control" name="comentarios" placeholder="Insira seus comentários a respeito da conquista..." rows="4" cols="50"></textarea>
                            </fieldset>
                            <button type="button" class="btn btn-success" onclick="registrarConquistaAcademica()">Registrar Conquista</button>
                        </form>
                    </section>
                </article>
            </div>
        </main>
    </div>

    <script src="../assets/js/utils.js"></script>
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/pages__pagina-inicial-aluno.js"></script>

</body>
<script>
    let idAluno = $('#id-aluno').val();

    $(document).ready(function() {
        carregarGraficoNotasDisciplina();
        carregarGraficoFaltasDisciplina()
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
        const coresBimestres = ['#4A90E2', '#50E3C2', '#F8E71C', '#D0021B'];
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
        $.ajax({
            type: 'POST',
            url: '../backend/aluno/retorna-dados-faltas-disciplina.php',
            data: {
                idAluno,
            },
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);
                var ctx = document
                    .getElementById('grafico-medias-faltas-disciplina')
                    .getContext('2d');

                const coresVivas = [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(231, 76, 60, 1)',
                    'rgba(46, 204, 113, 1)',
                    'rgba(52, 152, 219, 1)',
                    'rgba(241, 196, 15, 1)',
                ];

                var lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: response.bimestres,
                        datasets: Object.keys(response.faltasPorMateria).map(function(
                            materia,
                            index
                        ) {
                            return {
                                label: materia,
                                data: response.faltasPorMateria[materia],
                                borderColor: coresVivas[index % coresVivas.length],
                                backgroundColor: coresVivas[index % coresVivas.length],
                                fill: false,
                                tension: 0.1,
                            };
                        }),
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
                                    padding: 20,
                                },
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 2,
                                },
                                grid: {
                                    display: false,
                                },
                            },
                            x: {
                                grid: {
                                    display: false,
                                },
                            },
                        },
                    },
                });
            },
            error: function(error) {
                console.log(error);
            },
        });
    }

    function agendarEventoEscolar() {
        let dadosAgendamento = {
            nome: $('#nome-evento').val(),
            classe: $('#classe-evento').val(),
            descricao: $('#descricao-evento').val(),
            dataInicio: $('#data-inicio').val(),
            dataFim: $('#data-fim').val(),
        };


        for (const key in dadosAgendamento) {
            if (dadosAgendamento[key] == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Opa, algo deu errado no agendamento do evento!',
                    text: 'Preencha todos os campos para agendar o evento!'
                });
                return;
            }
        }

        // let verificacao = verificarInputsVazios(dadosAgendamento);

        // if (verificacao) {
        //     alertaErroCadastro(verificacao, 'evento');
        //     return;
        // }

        if (dadosAgendamento.dataFim <= dadosAgendamento.dataInicio) {
            Swal.fire({
                icon: 'error',
                title: 'Opa, algo deu errado no agendamento do evento!',
                text: 'A data de término do evento deve ser maior do que sua data de início!',
            });
            return;
        }

        $.ajax({
            type: 'POST',
            url: '../backend/agendar-evento-escolar.php',
            data: dadosAgendamento,
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);

                switch (response.status) {
                    case 1:
                        Swal.fire({
                            icon: 'success',
                            title: 'Evento agendado!',
                            text: response.swalMessage,
                        });

                        limparInputs([
                            '#nome-evento',
                            '#classe-evento',
                            '#descricao-evento',
                            '#data-inicio',
                            '#data-fim',
                        ]);
                        break;
                    case -1:
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro Interno!',
                            text: response.swalMessage,
                        });

                        console.log(response.error);
                        break;
                }
            },
            error: (err) => console.log(err),
        });
    }

    function registrarConquistaAcademica() {
        let dadosConquista = {
            idAluno,
            titulo: $('#titulo').val(),
            descricao: $('#descricao').val(),
            data: $('#data').val(),
            comentarios: $('#comentarios').val(),
        };

        for (const key in dadosConquista) {
            if (dadosConquista[key] == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Opa, algo deu errado no registro da conquista!',
                    text: 'Preencha todos os campos para registrar a conquista!'
                });
                return;
            }
        }

        console.log(dadosConquista)

        $.ajax({
            type: 'POST',
            url: '../backend/registrar-conquista-academica.php',
            data: dadosConquista,
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);

                switch (response.status) {
                    case 1:
                        Swal.fire({
                            icon: 'success',
                            title: 'Conquista registrada!',
                            text: response.swalMessage,
                        });

                        limparInputs([
                            '#titulo',
                            '#descricao',
                            '#data',
                            '#comentarios',
                        ]);
                        break;
                    case -1:
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro Interno!',
                            text: response.swalMessage,
                        });

                        console.log(response.error);
                        break;
                }
            },
            error: (err) => console.log(err),
        });
    }
    // Definir todas as disciplinas e bimestres
    // const bimestres = ['1º Bimestre', '2º Bimestre', '3º Bimestre', '4º Bimestre'];
    // const disciplinas = <?php // echo json_encode($disciplinas); 
                            ?>; // Obtido da consulta PHP

    // // Dados das faltas por disciplina e bimestre
    // const faltasData = <?php // echo json_encode($faltasData); 
                            ?>;
    // // Dados das notas por disciplina e bimestre
    // const notasData = <?php // echo json_encode($notasData); 
                            ?>;

    // console.log(faltasData);
    // console.log(notasData);

    // // Função para criar gráficos de barras empilhadas
    // function criarGrafico(ctx, data, label, backgroundColors, borderColors) {
    //     const datasets = bimestres.map((bimestre, index) => {
    //         const dataset = {
    //             label: bimestre,
    //             data: [],
    //             backgroundColor: backgroundColors[index],
    //             borderColor: borderColors[index],
    //             borderWidth: 1
    //         };
    //         for (const disciplina of disciplinas) {
    //             dataset.data.push(data[index + 1] && data[index + 1][disciplina] !== undefined ? data[index + 1][disciplina] : 0);
    //         }
    //         return dataset;
    //     });
    //     new Chart(ctx, {
    //         type: 'bar',
    //         data: {
    //             labels: disciplinas,
    //             datasets: datasets
    //         },
    //         options: {
    //             scales: {
    //                 y: {
    //                     beginAtZero: true
    //                 },
    //                 x: {
    //                     stacked: true
    //                 }
    //             }
    //         }
    //     });
    // }

    // // Cores para os bimestres
    // const backgroundColors = [
    //     'rgba(255, 165, 0, 0.5)', // Laranja claro
    //     'rgba(255, 140, 0, 0.5)', // Laranja
    //     'rgba(255, 120, 0, 0.5)', // Laranja mais escuro
    //     'rgba(255, 100, 0, 0.5)' // Laranja escuro
    // ];

    // const borderColors = [
    //     'rgba(255, 165, 0, 1)', // Laranja claro
    //     'rgba(255, 140, 0, 1)', // Laranja
    //     'rgba(255, 120, 0, 1)', // Laranja mais escuro
    //     'rgba(255, 100, 0, 1)' // Laranja escuro
    // ];

    // // Obtenha o contexto do canvas
    // const ctxFaltas = document.getElementById('faltasPorDisciplina').getContext('2d');
    // const ctxNotas = document.getElementById('graficoMediasNotas').getContext('2d');

    // // Verificar se os dados estão corretos antes de criar os gráficos
    // if (faltasData && Object.keys(faltasData).length > 0) {
    //     criarGrafico(ctxFaltas, faltasData, 'Faltas', backgroundColors, borderColors);
    // } else {
    //     console.error('Dados de faltas inválidos ou vazios');
    // }

    // if (notasData && Object.keys(notasData).length > 0) {
    //     criarGrafico(ctxNotas, notasData, 'Média das Notas', backgroundColors, borderColors);
    // } else {
    //     console.error('Dados de notas inválidos ou vazios');
    // }
</script>


</html>