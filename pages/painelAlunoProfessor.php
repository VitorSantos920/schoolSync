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



$consultaFalta = "SELECT aluno_id, COUNT(*) AS somaFalta FROM falta GROUP BY aluno_id";

$resultadoFalta = mysqli_query($conn, $consultaFalta);

$filaFalta = mysqli_fetch_assoc($resultadoFalta);



$consultaEvento = "SELECT classe_id FROM aluno WHERE id = $aluno_id";

$resultadoFilaEvento = mysqli_query($conn, $consultaEvento);

if ($resultadoFilaEvento) {

    $filaEvento = mysqli_fetch_assoc($resultadoFilaEvento);

    $evento_classe_id = $filaEvento['classe_id'];

    // Certifique-se de que $evento_classe_id está definido antes de usá-lo no formulário

}



//mysqli_close($conn);

?>

<?php

require_once '../db/config.php';

date_default_timezone_set('America/Sao_Paulo');



session_start();

if (!isset($_SESSION['email'])) {

    header('Location: ./index.php');

    exit;
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

    <title>Visualização de aluno</title>

</head>



<body>

    <?php

    include_once "../components/sidebarProfessor.php";

    ?>

    <main>

        <div class="container">

            <h3><img src="../assets/img/maozinha.png" width="30px" alt="Ícone de mão dando saudação."> Olá!</h3>

            <h1><?php echo "Confira o Desempenho Acadêmico de " . $fila2['nome']; ?></h1><br>



            <div class="row">

                <div class="col-8">

                    <h3><?php echo "Média geral de notas: " . number_format($filaMedia['mediaMedia'], 1); ?></h3>

                    <h6>Gráfico de barras representando suas notas por disciplina</h6><br>

                    <?php

                    // Consulta SQL para recuperar as médias das notas do aluno em cada disciplina

                    $notasPorDisciplina = DB::query("SELECT m.disciplina AS disciplina, AVG(nota) AS media_nota FROM nota n INNER JOIN materia m ON n.materia_id = m.id INNER JOIN aluno a ON n.aluno_id = a.id WHERE a.id = %i GROUP BY m.disciplina", $aluno_id);

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

                <div class="col-4 linha-vertical"><br>

                    <h3><?php echo "Total de faltas: " . $filaFalta['somaFalta']; ?></h3>

                    <h6>Faltas por Disciplina</h6>

                    <?php

                    $faltasPorDisciplina = DB::query("SELECT m.disciplina AS disciplina, COUNT(*) as total_faltas FROM falta f INNER JOIN materia m ON f.materia_id = m.id WHERE f.aluno_id = %i GROUP BY m.disciplina", $aluno_id);

                    $faltasData = array();

                    foreach ($faltasPorDisciplina as $falta) {

                        $faltasData[$falta['disciplina']] = $falta['total_faltas'];
                    }

                    ?>

                    <canvas id="faltasPorDisciplina" height="250px"></canvas>

                </div>

                <hr class="linha-horizontal">

                <div class="col-6"><br>

                    <h4>Agendar novo evento escolar</h4><br>

                    <form action="processar_formulario_evento.php?professor_id=<?php echo $dadosProfessor['id'] ?>&classe_id=<?php echo $evento_classe_id ?>" method="post">

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