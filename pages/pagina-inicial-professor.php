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
                  <button class="btn btn-info">Detalhes</button>
                </td>
              </tr>
              <tr>
                <td>Números Naturais</td>
                <td>
                  <a href="">Acessar</a>
                </td>
                <td>
                  <button class="btn btn-info">Detalhes</button>
                </td>
              </tr>
              <tr>
                <td>Números Naturais</td>
                <td>
                  <a href="">Acessar</a>
                </td>
                <td>
                  <button class="btn btn-info">Detalhes</button>
                </td>
              </tr>
              <tr>
                <td>Números Naturais</td>
                <td>
                  <a href="">Acessar</a>
                </td>
                <td>
                  <button class="btn btn-info">Detalhes</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <a href="" class="materiais-apoio__view-all">Visualizar Todos</a>
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

  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>