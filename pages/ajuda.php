<?php
require_once '../backend/init-configs.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="icon" href="../assets/img/logo_transparente.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/ajuda.css?<?= time() ?>">

    <title>Ajuda e FAQ | SchoolSync</title>
</head>

<body>
    <div class="wrapper">

        <?php
        include_once "../components/header.php";
        include_once "../components/sidebar.php";
        ?>
        <main>

            <div>
                <h1>Perguntas Frequentes (FAQ)</h1>
            </div>

            <div class="accordion mt-3" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            O que é o SchoolSync?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>O SchoolSync é uma plataforma acadêmica desenvolvida para facilitar a comunicação entre escolas, professores, alunos e responsáveis, oferecendo uma visão abrangente da vida escolar dos alunos.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Sobre a equipe por trás do SchoolSync
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>Somos um grupo de estudantes do 5° semestre de Análise e Desenvolvimento de Sistemas (ADS), da Faculdade de Tecnologia (FATEC) de Campinas. Para nosso Trabalho de Graduação (TG), queremos desenvolver um produto com impacto e benefícios reais para os usuários, chamado SchoolSync.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Como nos contatar?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>Para entrar em contato utilize o email: schoolsyncoficial@gmail.com</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Quais são os principais recursos oferecidos pelo SchoolSync?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>O SchoolSync oferece recursos como acompanhamento de notas, registro de faltas, agenda escolar, comunicação direta entre pais/responsáveis e professores, acesso a materiais de apoio educacional e muito mais.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Quais são os benefícios de usar o SchoolSync?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>O SchoolSync promove uma maior participação dos pais na vida escolar dos filhos, melhora a comunicação entre a escola e a família, oferece uma visão abrangente do desempenho acadêmico dos alunos e facilita o acesso a recursos educacionais.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            Como os pais podem acessar o SchoolSync?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>Os pais podem acessar o SchoolSync através de uma plataforma online, utilizando um login e senha fornecidos pela escola de seus filhos.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            Como os professores utilizam o SchoolSync?
                        </button>
                    </h2>
                    <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>Os professores podem utilizar o SchoolSync para inserir e atualizar notas, registrar faltas, enviar comunicados aos pais, compartilhar materiais educacionais e manter uma agenda escolar atualizada.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            O SchoolSync está disponível apenas para escolas de Ensino Fundamental I?
                        </button>
                    </h2>
                    <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>No momento, o SchoolSync está focado em atender as necessidades das escolas de Ensino Fundamental I, mas futuramente pode ser expandido para outras séries e níveis de ensino.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                            O SchoolSync garante a privacidade dos dados dos alunos e famílias?
                        </button>
                    </h2>
                    <div id="collapseNine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>Sim, o SchoolSync adere a rigorosas políticas de privacidade e segurança de dados para garantir a proteção das informações dos alunos e famílias.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                            Como posso obter suporte técnico para o SchoolSync?
                        </button>
                    </h2>
                    <div id="collapseTen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>Para obter suporte técnico relacionado ao SchoolSync, entre em contato com a equipe de suporte da plataforma, que estará disponível para ajudar com qualquer dúvida ou problema.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                            Como posso solicitar novos recursos ou sugerir melhorias para o SchoolSync?
                        </button>
                    </h2>
                    <div id="collapseEleven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>Os usuários podem enviar sugestões de novos recursos ou melhorias para o SchoolSync através do canal de feedback disponível na plataforma. A equipe de desenvolvimento avaliará todas as sugestões e trabalhará para implementar as melhores ideias.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                            O SchoolSync é uma solução paga?
                        </button>
                    </h2>
                    <div id="collapseTwelve" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>Sim, o SchoolSync é uma solução gratuita para pais, responsáveis, professores e alunos. Não há custos associados ao uso da plataforma, que é disponibilizada pela instituição educacional em parceria com o SchoolSync para facilitar a comunicação e o acompanhamento da vida escolar dos alunos.</p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>