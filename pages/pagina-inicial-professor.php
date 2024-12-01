<?php
require_once "../backend/init-configs.php";


$dadosProfessor = DB::queryFirstRow("SELECT *, pr.id as 'prof_id' FROM usuario us INNER JOIN professor pr ON pr.usuario_id = us.id WHERE us.id = %i", $dadosUsuario['id']);

$materiaisApoio = DB::query("SELECT * FROM recurso_educacional WHERE professor_id = %i LIMIT 6", $dadosProfessor['prof_id']);

$turmasProfessor = DB::query("SELECT * FROM classe cl WHERE cl.professor_id = %i", $dadosProfessor['prof_id']);

$quantidadeTurmasProfessor = DB::queryFirstField("SELECT COUNT(*) as 'quantidade_turmas' FROM classe cl WHERE cl.professor_id = %i", $dadosProfessor['prof_id']);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Página inicial do professor ao realizar o login com sucesso no sistema SchoolSync">
  <meta name="keywords" content="docente, professor, tela inicial">
  <link rel="icon" href="../assets/img/logo_transparente.png">
  <title>Página Inicial - Professor | SchoolSync</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
  <link rel="stylesheet" href="../assets/css/pages__pagina-inicial-professor.css?<?= time() ?>">
</head>

<body>
  <div class="wrapper">
    <div class="content-wrapper">
      <?php
      include_once "../components/header.php";
      include_once "../components/sidebar.php"
      ?>

      <section class="saudacao d-flex align-items-center">
        <img width="30" src="../assets/img/hand.svg" alt="Emoji de mão amarela acenando.">
        <h2 class="saudacao__titulo">Olá, professor (a) <?php echo $dadosProfessor["nome"] ?>!</h2>
      </section>

      <main>
        <section class="turmas">
          <h3 class="turmas__quantidade">Minhas turmas (<?php echo $quantidadeTurmasProfessor; ?>)</h3>

          <ul class="turmas__lista-turmas">
            <?php
            if ($quantidadeTurmasProfessor > 0) {
              foreach ($turmasProfessor as $turma) {
                echo "
                    <li class='turmas__turma'>
                      <a href='./lista-alunos-turma.php?turma_id={$turma['id']}' class='d-flex align-items-center gap-2 justify-content-between'
                        <h4>{$turma['nome']} - {$turma['serie']}° Ano</h4>
                        >
                      </a>
                    </li>
                  ";
              }
            } else {
              echo "
              <li class='turmas__turma' style='padding: .75rem'>
                Você ainda não possui turmas.
              </li>
            ";
            }
            ?>
          </ul>
        </section>

        <section class="cadastros">
          <div class="adicionar-responsavel">
            <h3>Cadastrar responsável</h3>
            <button class="btn" onclick="abrirModalCriacaoResponsavel()">+ Adicionar</button>

            <div class="modal fade" id="modalCriacaoResponsavel" tabindex="-1" aria-labelledby="modalCriacaoResponsavel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h2 class="modal-title">Cadastrar Responsável</h2>
                  </div>
                  <div class="modal-body">
                    <form method='POST'>
                      <fieldset>
                        <label for='ipt-nome-responsavel' class='form-label'>Nome do Responsável</label>
                        <input type='text' name='ipt-nome-responsavel' id='ipt-nome-responsavel' class='form-control' required placeholder="Márcio da Silva">
                      </fieldset>

                      <fieldset>
                        <label for='ipt-email-responsavel' class='form-label'>Email do Responsável</label>
                        <input type='email' name='ipt-email-responsavel' id='ipt-email-responsavel' class='form-control' required placeholder="email@exemplo.com">
                      </fieldset>

                      <fieldset>
                        <label for='ipt-senha-responsavel' class='form-label'>Senha do Responsável</label>
                        <input type='password' name='ipt-senha-responsavel' id='ipt-senha-responsavel' class='form-control' required placeholder="*************">
                      </fieldset>

                      <fieldset>
                        <label for='ipt-cpf-responsavel' class='form-label'>CPF do Responsável</label>
                        <input type='text' name='ipt-cpf-responsavel' id='ipt-cpf-responsavel' class='form-control' required placeholder="XXX.XXX.XXX-XX">
                      </fieldset>

                      <fieldset>
                        <label for='ipt-telefone-responsavel' class='form-label'>Telefone do Responsável</label>
                        <input type='tel' name='ipt-telefone-responsavel' id='ipt-telefone-responsavel' class='form-control' required placeholder="(99) 99999-9999">
                      </fieldset>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="background-color: gray;" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-gray" onclick="criarResponsavel()">Criar Responsável</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="adicionar-turma">
            <h3>Cadastrar turma</h3>
            <button class="btn" onclick="abrirModalCriacaoTurma()">+ Adicionar</button>

            <div class="modal fade" id="modalCriacaoTurma" tabindex="-1" aria-labelledby="modalCriacaoTurma" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h2 class="modal-title">Cadastrar nova Turma</h2>
                  </div>
                  <div class="modal-body">
                    <form method='post'>
                      <fieldset>
                        <label for='ipt-nome-turma' class='form-label'>Nome da Turma</label>
                        <input type='text' name='ipt-nome-turma' id='ipt-nome-turma' class='form-control' required placeholder="Turma 4° Ano B">
                      </fieldset>

                      <fieldset>
                        <label for='select-turma-escolaridade' class='form-label'>Escolaridade/Série da Turma</label>
                        <select class='form-control form-select' name='select-turma-escolaridade' id='select-turma-escolaridade' required>
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
                    <button type="button" class="btn btn-gray" onclick="criarTurma()">Criar Turma</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="adicionar-aluno">
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
                        <input type='text' name='ipt-nome-aluno' id='ipt-nome-aluno' class='form-control' required placeholder="João Vinícius dos Santos">
                      </fieldset>

                      <fieldset>
                        <label for='ipt-email-aluno' class='form-label'>Email do Aluno</label>
                        <input type='email' name='ipt-email-aluno' id='ipt-email-aluno' class='form-control' required placeholder="email@exemplo.com">
                      </fieldset>

                      <fieldset>
                        <label for='ipt-senha-aluno' class='form-label'>Senha do Aluno</label>
                        <input type='password' name='ipt-senha-aluno' id='ipt-senha-aluno' class='form-control' required placeholder="*************">
                      </fieldset>

                      <fieldset>
                        <label for='select-responsavel-aluno' class='form-label'>Responsável pelo Aluno</label>
                        <select name="select-responsavel-aluno" class="form-control form-select" id="select-responsavel-aluno">
                          <option value="-1" disabled selected>Responsável</option>
                          <?php
                          $responsaveis = DB::query("SELECT * FROM usuario u INNER JOIN responsavel res ON res.usuario_id = u.id WHERE u.categoria = 'Responsavel'");

                          foreach ($responsaveis as $responsavel) {
                            echo "
                            <option value='{$responsavel['id']}'>{$responsavel['nome']}</option>
                          ";
                          }
                          ?>
                        </select>
                      </fieldset>

                      <fieldset>
                        <label for='ipt-escola-aluno' class='form-label'>Escola do Aluno</label>
                        <input type='text' name='ipt-escola-aluno' id='ipt-escola-aluno' class='form-control' required placeholder="Escola Estadual Carlos Gomes">
                      </fieldset>

                      <fieldset>
                        <label for='select-classe-aluno' class='form-label'>Turma/Classe do Aluno</label>
                        <?php
                        if ($quantidadeTurmasProfessor > 0) {
                          echo "
                          <select name='select-classe-aluno' class='form-control form-select' id='select-classe-aluno'>
                            <option value='-1' disabled selected>Classe</option>";

                          foreach ($turmasProfessor as $turma) {
                            echo "
                            <option value='{$turma['id']}'>{$turma['nome']}</option>
                            ";
                          }
                        } else {
                          echo "
                          <select name='select-classe-aluno' class='form-control form-select' disabled id='select-classe-aluno'>
                            <option value='-1' disabled selected>Você não possui turmas cadastradas.</option>";
                        }
                        ?>
                        </select>
                      </fieldset>

                      <fieldset>
                        <label for='ipt-dataNascimento-aluno' class='form-label'>Data de Nascimento</label>
                        <input type='date' name='ipt-dataNascimento-aluno' max="2016-12-31" id='ipt-dataNascimento-aluno' class='form-control' required>
                      </fieldset>

                      <fieldset>
                        <label for='select-genero-aluno' class='form-label'>Gênero do Aluno</label>
                        <select class='form-control form-select' name='select-genero-aluno' id='select-genero-aluno' required>
                          <option value='-1' selected disabled>Gênero</option>
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
                    <button type="button" class="btn btn-gray" onclick="criarAluno()">Criar Aluno</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="materiais-apoio">
          <h3 class="materiais-apoio__titulo">Materiais de Apoio</h3>
          <p class="materiais-apoio__descricao">Visualize abaixo os Recursos Educacionais cadastrados nas turmas. </p>
          <button type="button" class="btn adicionar-material" onclick="modalCriacaoMaterialApoio()">+ Adicionar Material</button>

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
                  $created_at = $materialApoio['criado_em'];
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
                    <i class="fa-solid fa-arrow-up-right-from-square" style="color: #ffffff;"></i>
                    Acessar Material
                  </a>
                  <p id="created-at"></p>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="criacaoMaterialApoio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title">
                    <img src="../assets/img/material-apoio.svg" alt="">
                    Criar Material de Apoio
                  </h3>
                </div>
                <div class="modal-body">
                  <form action="#" method="post">
                    <fieldset>
                      <label for="ipt-nome-material" class="form-label">Nome/Título do Material</label>
                      <input type="text" name="ipt-nome-material" id="ipt-nome-material" class="form-control" placeholder="Números Romanos" required>
                    </fieldset>

                    <fieldset>
                      <label for="ipt-descricao-material" class="form-label">Descrição do material</label>
                      <textarea class="form-control" name="ipt-descricao-material" id="ipt-descricao-material" cols="30" rows="5"></textarea>
                    </fieldset>

                    <fieldset>
                      <label for="ipt-url-material" class="form-label">Digite ou cole a URL (link) do Material (Caso seja um material externo [website, vídeo etc.]) </label>
                      <input type="text" name="ipt-url-material" id="ipt-url-material" class="form-control" placeholder="https://mundoescola.com.br" required>
                    </fieldset>

                    <fieldset>
                      <label for="select-escolaridade-material" class="form-label">Selecione a escolaridade ideal para este Material</label>
                      <select class="form-control form-select" name="select-escolaridade-material" id="select-escolaridade-material">
                        <option value="0" selected disabled>Escolaridade</option>
                        <option value="1">1° Ano</option>
                        <option value="2">2° Ano</option>
                        <option value="3">3° Ano</option>
                        <option value="4">4° Ano</option>
                        <option value="5">5° Ano</option>
                      </select>
                    </fieldset>

                    <fieldset>
                      <label for="select-tipo-material" class="form-label">Selecione o tipo deste Material</label>
                      <select class="form-control form-select" name="select-tipo-material" id="select-tipo-material">
                        <option value="0" selected disabled>Tipo</option>
                        <option value="pdf">PDF</option>
                        <option value="site">Site da Internet</option>
                      </select>
                    </fieldset>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <button type="button" class="btn btn-success" onclick="criarMaterialApoio()">Criar Material</button>
                </div>
              </div>
            </div>
          </div>
        </section>


        <section class="agendar-evento-escolar">
          <h3>Agendar novo evento escolar aos alunos</h3>
          <form id="form-agendar-evento">
            <fieldset>
              <label for="nome-evento" class="form-label">Nome/Título do Evento</label>
              <input type="text" name="nome-evento" id="nome-evento" class="form-control" placeholder="Olimpíada Brasileira de Matemática">
            </fieldset>

            <fieldset>
              <label for="classe-evento" class="form-label">Classe do Evento</label>
              <select name="classe-evento" id="classe-evento" class="form-control form-select">
                <option value="-1" selected disabled>Selecione</option>
                <?php
                foreach ($turmasProfessor as $turma) {
                  echo "
                      <option value='{$turma['id']}'>$turma[nome]</option>
                    ";
                }
                ?>
              </select>
            </fieldset>

            <fieldset>
              <label for="descricao-evento" class="form-label">Descrição do Evento</label>
              <textarea class="form-control" name="descricao-evento" id="descricao-evento" cols="30" rows="5" placeholder="Digite aqui a descrição do evento..."></textarea>
            </fieldset>

            <fieldset>
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

      </main>
    </div>
  </div>

  <script src="../assets/js/sweetalert2.all.min.js"></script>
  <script src="../plugins/vanilla-masker.js"></script>

  <script src="../assets/js/utils.js"></script>
  <script src="../assets/js/pages__pagina-inicial-professor.js"></script>
</body>

</html>