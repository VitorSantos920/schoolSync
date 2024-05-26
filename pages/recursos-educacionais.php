<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Página inicial do professor ao realizar o login com sucesso no sistema SchoolSync">
  <meta name="keywords" content="docente, professor, tela inicial">
  <title>Recursos Educacionais | Administrador</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
  <link rel="stylesheet" href="../assets/css/pages__pagina-inicial-professor.css">

  <style>
    table.table th {
      background-color: var(--brand-color);
    }
  </style>
</head>

<body>
  <?php include_once "../components/sidebarAdmin.php"; ?>

  <main>
    <button class="btn btn-success" onclick="modalCriacaoMaterialApoio()">Criar Material de Apoio</button>
    <div class="table-responsive">
      <table class="table table-borderless align-middle caption-top" id="table-recursos-educacionais">
        <caption>Lista de Recursos Educacionais</caption>
        <thead>
          <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>URL</th>
            <th>Escolaridade</th>
            <th>Tipo</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="tbody-recursos-educacionais">

        </tbody>
      </table>

      <div class="modal fade" id="modalEditarRecurso" tabindex="-1" aria-labelledby="modalEditarRecurso" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title">Editar Material de Apoio</h2>
            </div>
            <div class="modal-body">
              <!-- Conteúdo do modal de edição -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type='submit' class='btn' onclick='editarUsuario()'>Editar Usuário</button>
            </div>
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
  </main>

  <script src="https://kit.fontawesome.com/4ac8bcd2f5.js" crossorigin="anonymous"></script>
  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sweetalert2.all.min.js"></script>
  <script src="../assets/js/pages__recursos-educacionais.js"></script>
</body>

</html>