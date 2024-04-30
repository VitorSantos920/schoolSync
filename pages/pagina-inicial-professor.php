<?php
require_once '../db/config.php';
date_default_timezone_set('America/Sao_Paulo');

session_start();
if (!isset($_SESSION['email'])) {
  header('Location: ./index.php');
  exit;
}

$materiaisApoio = DB::query("SELECT * FROM recurso_educacional ");

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
  <section class="saudacao d-flex align-items-center">
    <img width="30" src="../assets/img/hand.svg" alt="Emoji de mão amarela acenando.">
    <h2 class="saudacao__titulo">Olá, professor (a) <?php echo $dadosProfessor["nome"] ?>!</h2>
    <button class="btn btn-success" onclick="modalCriacaoMaterialApoio()">Abrir Modal Criação Material de Apoio</button>
  </section>

  <?php
  echo date('H:i:s');
  ?>
  <main class="d-flex gap-5">
    <div class="left-side">
      <section class="turmas">
        <h3 class="turmas__quantidade">Suas turmas:<?php echo $quantidadeTurmasProfessor; ?></h3>
        <ul class="turmas__lista-turmas">
          <?php
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
                <h3 id="titulo-material">Números Naturiais</h3>

                <h5>Descrição</h5>
                <p id="descricao-material">Os Números Naturais N = {0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12...} são numeros inteiros positivos (não-negativos) que se agrupam num conjunto chamado de N, composto de um número ilimitado de elementos. Se um número é inteiro e positivo, podemos dizer que é um número natural.
                  Quando o zero não faz parte do conjunto, é representado com um asterisco ao lado da letra N e, nesse caso, esse conjunto é denominado de Conjunto dos Números Naturais Não-Nulos: N* = {1, 2, 3, 4, 5, 6, 7, 8, 9...}.</p>

                <h5>Tipo do Material</h5>
                <p id="tipo-material">Site da Internet</p>

                <h5>Escolaridade</h5>
                <p id="escolaridade-material">2° Ano</p>

                <a id="url-material" class="btn btn-info" target="_blank">
                  Acessar Material <i class="fa-solid fa-arrow-up-right-from-square" style="color: #ffffff;"></i>
                </a>

                <p id="created-at">Criado em: 07/04/2024</p>
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
        <button class="btn">+ Adicionar</button>
      </section>

      <section class="adicionar-responsavel">

        <h3>Cadastrar responsável</h3>
        <button class="btn">+ Adicionar</button>
      </section>

      <section class="adicionar-responsavel">

        <h3>Cadastrar Turma</h3>
        <button class="btn">+ Adicionar</button>
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
              <label for="select-escolaridade" class="form-label">Selecione a escolaridade ideal para este Material</label>
              <select class="form-control form-select" name="select-escolaridade" id="select-escolaridade">
                <option value="0" selected disabled>Escolaridade</option>
                <option value="1">1°Ano</option>
                <option value="2">2°Ano</option>
                <option value="3">3°Ano</option>
                <option value="4">4°Ano</option>
                <option value="5">5°Ano</option>
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
  <script src="https://kit.fontawesome.com/4ac8bcd2f5.js" crossorigin="anonymous"></script>
  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sweetalert2.all.min.js"></script>
  <script src="../assets/js/pages__pagina-inicial-professor.js"></script>
  <script>
    function modalCriacaoMaterialApoio() {
      $('#criacaoMaterialApoio').modal('show')
      let nomeMaterial = $('#nome-material').val('');
      let descricaoMaterial = $('#descricao-material').val('');
      let urlMaterial = $('#url-material').val('');
      let escolaridade = $('#escolaridade').val('');
      let tipoMaterial = $('#tipo-material').val('');
    }

    function criarMaterialApoio() {
      let nomeMaterial = $('#ipt-nome-material').val();
      let descricaoMaterial = $('#ipt-descricao-material').val();
      let urlMaterial = $('#ipt-url-material').val();
      let escolaridade = $('#select-escolaridade').val();
      let tipoMaterial = $('#select-tipo-material').val();

      console.log(nomeMaterial)
      console.log(descricaoMaterial)
      console.log(urlMaterial)
      console.log(escolaridade)
      console.log(tipoMaterial)

      if (!nomeMaterial || !descricaoMaterial || !urlMaterial || !escolaridade || !tipoMaterial) {
        Swal.fire({
          title: "Opa, algo deu errado!",
          text: "Para criar o Recurso Educacional, é necessário o preenchimento de todos os campos.",
          icon: "error"
        })
        return;
      }

      $.ajax({
        type: "POST",
        url: "../backend/criar-material-apoio.php",
        data: {
          nome: nomeMaterial,
          descricao: descricaoMaterial,
          url: urlMaterial,
          escolaridade,
          tipo: tipoMaterial
        },
        success: function(response) {
          response = JSON.parse(response)
          console.log(response)
          switch (response.status) {
            case 1: {
              Swal.fire({
                title: "Recurso criado!",
                text: response.message,
                icon: "success"
              })

              break;
            }
            case -1: {
              Swal.fire({
                title: "Erro Interno!",
                text: response.swalMessage,
                icon: "error"
              })

              console.log(`Status: ${response.status} | Mensagem de Erro: ${response.messageError}`)
              break;
            }
          }

          $('#criacaoMaterialApoio').modal('hide');
        },
        error: (err) => console.log(err)
      })
    }
  </script>
</body>

</html>