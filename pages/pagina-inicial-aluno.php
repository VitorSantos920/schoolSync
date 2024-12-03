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
    $dadosAluno = DB::queryFirstRow("SELECT al.id, al.classe_id, cl.serie FROM aluno al INNER JOIN classe cl ON al.classe_id = cl.id WHERE al.id = %i", $alunoId);
} else {
    $dadosAluno = DB::queryFirstRow("SELECT al.id, al.classe_id, cl.serie FROM aluno al INNER JOIN classe cl ON al.classe_id = cl.id WHERE usuario_id = %i", $dadosUsuario['id']);

    $sectionSaudacao = "
        <section class='saudacao d-flex align-items-center'>
            <img width='30' src='../assets/img/hand.svg' alt='Emoji de mão amarela acenando.'>
            <h2 class='saudacao__titulo'>Olá, {$dadosUsuario['nome']}!</h2>
        </section>
    ";
    $desempenhoAcademico = "<h1>Confira seu Desempenho Acadêmico</h1>";
}

$avaliacoesClasse = DB::query("SELECT * FROM avaliacao WHERE classe_id = %i AND realizada <> 1 LIMIT 4", $dadosAluno['classe_id']);
$eventosClasse = DB::query("SELECT * FROM evento WHERE classe_id = %i LIMIT 4", $dadosAluno['classe_id']);
$recursosEducacionais = DB::query("SELECT * FROM recurso_educacional WHERE escolaridade = %i LIMIT 4", $dadosAluno['serie']);

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
                <input type="hidden" id="id-aluno" value=<?= $dadosAluno['id'] ?> disabled>

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

                        <?php
                        if (!empty($avaliacoesClasse)) {
                            foreach ($avaliacoesClasse as $avaliacao) {
                                $dataPrevista = date('d/m/Y H:i', strtotime($avaliacao['data_prevista']));

                                echo "<section>
                                        <div class='avaliacoes__sobre'>
                                            <h4 class='avaliacoes__titulo'>$avaliacao[titulo]</h4>
                                            <p class='avaliacoes__data'>$dataPrevista</p>
                                        </div>

                                        <button class='btn btn-schoolsync-bg' onclick='abrirModalDetalhesAvaliacao({$avaliacao['id']})'>Detalhes</button>
                                    </section>";
                            }
                        } else {
                            echo "<p>Não há avaliações futuras nesta classe.</p>";
                        }
                        ?>

                    </article>

                    <article class="agenda-escolar col-4">
                        <header>
                            <h3>
                                <i class="fa-regular fa-calendar"></i>
                                Agenda Escolar
                            </h3>
                            <p>Visualize abaixo o resumo da sua agenda escolar.</p>
                        </header>

                        <?php
                        if (!empty($eventosClasse)) {
                            foreach ($eventosClasse as $evento) {
                                $dataInicio = date('d/m/Y H:i', strtotime($evento['inicio']));
                                $dataTermino = date('d/m/Y H:i', strtotime($evento['termino']));

                                echo "<section>
                                        <h4>$evento[titulo]</h4>
                                        <p>$dataInicio</p>
                                        -
                                        <p>$dataTermino</p>
                                    </section>";
                            }
                        } else {
                            echo "<p>Ainda não há eventos em sua agenda!</p>";
                        }
                        ?>
                    </article>

                    <article class="materiais-apoio col-4">
                        <header>
                            <h3>
                                <i class="fa-regular fa-folder"></i>
                                Materiais de apoio
                            </h3>
                            <p>Acesse abaixo os recursos educacionais disponíveis. </p>
                        </header>

                        <?php
                        if (!empty($recursosEducacionais)) {
                            foreach ($recursosEducacionais as $recurso) {
                                echo "<section>
                                        <h4>$recurso[titulo]</h4>
                                        <button class='btn'>Detalhes</button>
                                        <a class='btn' href='$recurso[url]' target='_blank'>Acessar</a>
                                    </section>";
                            }
                            echo "<p>Visualizar mais</p>";
                        } else {
                            echo "<p>Não há materiais de apoio disponíveis para sua série.</p>";
                        }
                        ?>
                        <!-- <section>
                            <h4>Prova 1 de Matemática</h4>

                            <p>06/05/2024</->
                        </section> -->
                    </article>
                </div>

                <div class="modal fade" id="modalDetalhesAvaliacao" tabindex="-1" aria-labelledby="modalMaterialApoio" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">
                                    <img src="../assets/img/material-apoio.svg" alt="Símbolo de pasta alaranjada dentro de um círculo.">
                                    Detalhes da Avaliação "<span id="nome-avaliacao">Nome Avaliação (Representação)</span>"
                                </h2>
                            </div>

                            <div class="modal-body"></div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/pages__pagina-inicial-aluno.js"></script>
</body>

</html>