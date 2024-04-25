<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Página inicial do professor ao realizar o login com sucesso no sistema SchoolSync">
  <meta name="keywords" content="docente, professor, tela inicial">
  <title>Professor | Página Inicial</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/pages__pagina-inicial-professor.css">
</head>

<body>
  <section class="saudacao d-flex align-items-center">
    <img width="30" src="../assets/img/hand.svg" alt="Emoji de mão amarela acenando.">
    <h2 class="saudacao__titulo">Olá, professor (a) Márcio!</h2>
  </section>

  <main class="d-flex gap-5">
    <div class="left-side">
      <section class="turmas">
        <h3 class="turmas__quantidade">Suas turmas: 2</h3>
        <ul class="turmas__lista-turmas">
          <li class="turmas__turma">
            <a href="" class="d-flex align-items-center gap-2">
              <h4>Turma A - 3° Ano B - 23 alunos</h4>
              >
            </a>
          </li>
          <li class="turmas__turma d-flex align-items-center gap-2">
            <a href="" class="d-flex align-align-items-center gap-2">
              <h4>Turma C - 1° Ano A - 19 alunos</h4>
              >
            </a>
          </li>
        </ul>
      </section>
      <section class="materiais-apoio">
        <h3 class="materiais-apoio__titulo">Materiais de Apoio</h3>
        <p class="materiais-apoio__descricao">Visualize abaixo os Recursos Educacionais cadastrados nas turmas. </p>

        <div class="table-responsive">
          <table class="table">
            <tbody>
              <tr>
                <td>Números Naturais</td>
                <td>
                  <a href="">Acessar</a>
                </td>
                <td>
                  <button class="btn btn-info" onclick="abrirModalDetalhes('')">Detalhes</button>
                </td>
              </tr>
              <tr>
                <td>Números Naturais</td>
                <td>
                  <a href="">Acessar</a>
                </td>
                <td>
                  <button class="btn btn-info" onclick="abrirModalDetalhes('')">Detalhes</button>
                </td>
              </tr>
              <tr>
                <td>Números Naturais</td>
                <td>
                  <a href="">Acessar</a>
                </td>
                <td>
                  <button class="btn btn-info" onclick="abrirModalDetalhes('')">Detalhes</button>
                </td>
              </tr>
              <tr>
                <td>Números Naturais</td>
                <td>
                  <a href="">Acessar</a>
                </td>
                <td>
                  <button class="btn btn-info" onclick="abrirModalDetalhes('')">Detalhes</button>
                </td>
              </tr>
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
                  Material de Apoio #7462
                </h2>
              </div>
              <div class="modal-body">
                <h3>Números Naturiais</h3>

                <h5>Descrição</h5>
                <p>Os Números Naturais N = {0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12...} são numeros inteiros positivos (não-negativos) que se agrupam num conjunto chamado de N, composto de um número ilimitado de elementos. Se um número é inteiro e positivo, podemos dizer que é um número natural.
                  Quando o zero não faz parte do conjunto, é representado com um asterisco ao lado da letra N e, nesse caso, esse conjunto é denominado de Conjunto dos Números Naturais Não-Nulos: N* = {1, 2, 3, 4, 5, 6, 7, 8, 9...}.</p>

                <h5>Tipo do Material</h5>
                <p>Site da Internet</p>

                <h5>Escolaridade</h5>
                <p>2° Ano</p>

                <a href="" class="btn btn-info">
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

      <section class="agendar-evento-escolar">
        <h3>Agendar novo evento escolar</h3>
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
              <label for="data-inicio" class="form-label">Data de Início</label>
              <input class="form-control" type="datetime-local" name="data-inicio" id="data-inicio">
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
  <script src="../assets/js/pages__pagina-inicial-professor.js"></script>
</body>

</html>