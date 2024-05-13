<?php
require_once '../db/config.php';
date_default_timezone_set('America/Sao_Paulo');
session_start();

if (!isset($_SESSION['email']) || $_SESSION["categoria"] != "Professor") {
  header('Location: ./index.php');
  exit;
}

$materiaisApoio = DB::query("SELECT * FROM recurso_educacional LIMIT 6");

// Recupera todos os dados do Professor
$dadosProfessor = DB::queryFirstRow("SELECT *, pr.id as 'prof_id' FROM usuario us INNER JOIN professor pr ON pr.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);

// Recupera as turmas (classes) deste professor
$turmasProfessor = DB::query("SELECT *, COUNT(*) as 'quantidade_turmas' FROM classe cl WHERE cl.professor_id = %i", $dadosProfessor['prof_id']);
$quantidadeTurmasProfessor = DB::queryFirstField("SELECT COUNT(*) as 'quantidade_turmas' FROM classe cl WHERE cl.professor_id = %i", $dadosProfessor['prof_id']);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Página inicial do professor ao realizar o login com sucesso no sistema SchoolSync">
  <meta name="keywords" content="docente, professor, tela inicial">
  <title>Professor | Página Inicial</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
  <link rel="stylesheet" href="../assets/css/pages__pagina-inicial-professor.css">
</head>

<body>
  <?php
  include_once "../components/sidebar.php";
  ?>

  <section class="saudacao d-flex align-items-center">
    <img width="30" src="../assets/img/hand.svg" alt="Emoji de mão amarela acenando.">
    <h2 class="saudacao__titulo">Olá, professor (a) <?php echo $dadosProfessor["nome"] ?>!</h2>
  </section>

  <main class="d-flex gap-5">
    <div class="left-side">
      <section class="turmas">
        <h3 class="turmas__quantidade">Suas turmas: <?php echo $quantidadeTurmasProfessor; ?></h3>
        <ul class="turmas__lista-turmas">
          <?php
          if ($quantidadeTurmasProfessor > 0) {
            foreach ($turmasProfessor as $turma) {
              echo "
                  <li class='turmas__turma'>
                    <a href='./lista_alunos_da_turma.php?turma_id={$turma['id']}' class='d-flex align-items-center gap-2 justify-content-between'
                      <h4>{$turma['nome']} - {$turma['serie']}° Ano</h4>
                      >
                    </a>
                  </li>
                ";
            }
          } else {
            echo "
              <li class='turmas__turma'>
                Você ainda não possui turmas.
              </li>   
            ";
          }

          ?>
        </ul>
      </section>
      <section class="materiais-apoio">
        <h3 class="materiais-apoio__titulo">Materiais de Apoio</h3>
        <p class="materiais-apoio__descricao">Visualize abaixo os Recursos Educacionais cadastrados nas turmas. </p>

        <div class="table-responsive">
          <table class="table">
            <tbody>
              <?php
              foreach ($materiaisApoio as $materialApoio) {
                $id = $materialApoio['id'];
                $titulo = $materialApoio['titulo'];
                $descricao = $materialApoio['descricao'];
                $url = $materialApoio['url'];
                $escolaridade = $materialApoio['escolaridade'];
                $tipo = $materialApoio['tipo'];

                $created_at = $materialApoio['created_at'];
                $created_at = date('d/m/Y H:i:s', strtotime($created_at));

                echo "
                    <tr>
                      <td>{$titulo}</td>
                      <td>
                        <a href='{$url}' target='_blank'>Acessar</a>
                      </td>
                      <td>
                        <button class='btn btn-info' onclick='abrirModalDetalhes({$id}, \"{$titulo}\", \"{$descricao}\", \"{$url}\", \"{$escolaridade}\", \"{$tipo}\", \"{$created_at}\")'>Detalhes</button>
                      </td>
                    </tr>
                  ";
              }
              ?>
            </tbody>
          </table>
        </div>
        <a href="" class="materiais-apoio__view-all">Visualizar Todos</a>

        <div class="modal fade" id="modalMaterialApoio" tabindex="-1" aria-labelledby="modalMaterialApoio" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">
                  <img src="../assets/img/material-apoio.svg" alt="Símbolo de pasta alaranjada dentro de um círculo.">
                  Material de Apoio <span id="id-material"></span>
                </h2>
              </div>
              <div class="modal-body">
                <h3 id="titulo-material"></h3>

                <h5>Descrição</h5>
                <p id="descricao-material"></p>

                <h5>Tipo do Material</h5>
                <p id="tipo-material"></p>

                <h5>Escolaridade</h5>
                <p id="escolaridade-material"></p>

                <a id="url-material" class="btn btn-info" target="_blank">
                  Acessar Material <i class="fa-solid fa-arrow-up-right-from-square" style="color: #ffffff;"></i>
                </a>

                <p id="created-at"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="vr"></div>

    <div class="right-side">
      <section class="adicionar-aluno">
        <h3>Cadastrar aluno</h3>
        <button class="btn" onclick="abrirModalCriacaoAluno()">+ Adicionar</button>

        <div class="modal fade" id="modalCriacaoAluno" tabindex="-1" aria-labelledby="modalCricacaoAluno" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">
                  Cadastrar Aluno
                </h2>
              </div>
              <div class="modal-body">
                <form method='POST'>
                  <fieldset>
                    <label for='ipt-nome-aluno' class='form-label'>Nome do Aluno</label>
                    <input type='text' name='ipt-nome-aluno' id='ipt-nome-aluno' class='form-control' required>
                  </fieldset>
                  <fieldset>
                    <label for='ipt-email-aluno' class='form-label'>Email do Aluno</label>
                    <input type='text' name='ipt-email-aluno' id='ipt-email-aluno' class='form-control' required>
                  </fieldset>
                  <fieldset>
                    <label for='ipt-senha-aluno' class='form-label'>Senha do Aluno</label>
                    <input type='text' name='ipt-senha-aluno' id='ipt-senha-aluno' class='form-control' required>
                  </fieldset>

                  <fieldset>
                    <label for='ipt-escola-aluno' class='form-label'>Escola do Aluno</label>
                    <input type='text' name='ipt-escola-aluno' id='ipt-escola-aluno' class='form-control' required>
                  </fieldset>
                  <fieldset>
                    <label for='ipt-dataNascimento-aluno' class='form-label'>Data de Nascimento</label>
                    <input type='date' name='ipt-dataNascimento-aluno' id='ipt-dataNascimento-aluno' class='form-control' required>
                  </fieldset>
                  <fieldset>
                    <label for='select-genero-aluno' class='form-label'>Gênero do Aluno</label>
                    <select class='form-control form-select' name='select-genero-aluno' id='select-genero-aluno' required>
                      <option value='0' selected disabled>Gênero</option>
                      <option value='Masculino'>Masculino</option>
                      <option value='Feminino'>Feminino</option>
                    </select>
                  </fieldset>
                  <fieldset>
                    <label for='select-escolaridade' class='form-label'>Escolaridade do Aluno</label>
                    <select class='form-control form-select' name='select-escolaridade' id='select-escolaridade' required>
                      <option value='-1' selected disabled>Escolaridade</option>
                      <option value='1'>1</option>
                      <option value='2'>2</option>
                      <option value='3'>3</option>
                      <option value='4'>4</option>
                      <option value='5'>5</option>
                    </select>
                  </fieldset>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="background-color: gray;" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-gray" data-bs-dismiss="modal" onclick="criarAluno()">Criar Aluno</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="adicionar-responsavel">

        <h3>Cadastrar responsável</h3>
        <button class="btn" onclick="abrirModalCriacaoResponsavel()">+ Adicionar</button>

        <div class="modal fade" id="modalCriacaoResponsavel" tabindex="-1" aria-labelledby="modalCriacaoResponsavel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">
                  Cadastrar Responsável
                </h2>
              </div>
              <div class="modal-body">
                <form method='POST'>
                  <fieldset>
                    <label for='ipt-nome-responsavel' class='form-label'>Nome do Responsável</label>
                    <input type='text' name='ipt-nome-responsavel' id='ipt-nome-responsavel' class='form-control' required>
                  </fieldset>
                  <fieldset>
                    <label for='ipt-email-responsavel' class='form-label'>Email do Responsável</label>
                    <input type='email' name='ipt-email-responsavel' id='ipt-email-responsavel' class='form-control' required>
                  </fieldset>
                  <fieldset>
                    <label for='ipt-senha-responsavel' class='form-label'>Senha do Responsável</label>
                    <input type='password' name='ipt-senha-responsavel' id='ipt-senha-responsavel' class='form-control' required>
                  </fieldset>
                  <fieldset>
                    <label for='ipt-cpf-responsavel' class='form-label'>CPF do Responsável</label>
                    <input type='text' name='ipt-cpf-responsavel' id='ipt-cpf-responsavel' class='form-control' required>
                  </fieldset>
                  <fieldset>
                    <label for='ipt-telefone-responsavel' class='form-label'>Telefone do Responsável</label>
                    <input type='tel' name='ipt-telefone-responsavel' id='ipt-telefone-responsavel' class='form-control' required>
                  </fieldset>

                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="background-color: gray;" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-gray" data-bs-dismiss="modal" onclick="criarResponsavel()">Criar Aluno</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="adicionar-responsavel">

        <h3>Cadastrar Turma</h3>
        <button class="btn" onclick="abrirModalCriacaoTurma()">+ Adicionar</button>
      </section>

      <section class="agendar-evento-escolar">
        <h3>Agendar novo evento escolar aos alunos</h3>
        <form action="#" method="post">
          <fieldset>
            <label for="nome-evento" class="form-label">Nome/Título do Evento</label>
            <input type="text" name="nome-evento" id="nome-evento" class="form-control" placeholder="Olimpíada Brasileira de Matemática" required>
          </fieldset>
          <fieldset>
            <label for="descricao-evento" class="form-label">Descrição do Evento</label>
            <textarea class="form-control" name="descricao-evento" id="descricao-evento" cols="30" rows="5"></textarea>
          </fieldset>
          <fieldset class="row">
            <div class="col">
              <label for="data-inicio" class="form-label">Data de Início</label>
              <input class="form-control" type="datetime-local" name="data-inicio" id="data-inicio">
            </div>
            <div class="col">
              <label for="data-fim" class="form-label">Data de Término</label>
              <input class="form-control" type="datetime-local" name="data-fim" id="data-fim">
            </div>
          </fieldset>
          <button type="submit" class="btn btn-success">Agendar Evento</button>
        </form>
      </section>
    </div>
  </main>


  <script src="https://kit.fontawesome.com/4ac8bcd2f5.js" crossorigin="anonymous"></script>
  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sweetalert2.all.min.js"></script>
  <script src="../assets/js/pages__pagina-inicial-professor.js"></script>

</body>

</html>