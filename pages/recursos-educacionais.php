<?php
require_once "../db/config.php";

$recursosEducacionais = DB::query("SELECT * FROM recurso_educacional");
?>

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
  <?php
  include_once "../components/sidebar.php";
  ?>
  <main>
    <button class="btn btn-success" onclick="modalCriacaoMaterialApoio()">Abrir Modal Criação Material de Apoio</button>
    <div class="table-responsive">
      <table class="table table-borderless align-middle caption-top" id="table-users">
        <caption>Lista de Recursos Educacionais</caption>
        <thead>
          <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>URL</th>
            <th>Escolaridade</th>
            <th>Tipo</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($recursosEducacionais) {
            foreach ($recursosEducacionais as $recursoEducacional) {
              echo "
                <tr>
                  <td>{$recursoEducacional['id']}</td>
                  <td>{$recursoEducacional['titulo']}</td>
                  <td>{$recursoEducacional['descricao']}</td>
                  <td>
                    <a style='text-decoration: underline' href='{$recursoEducacional['url']}' target='_blank'>Acessar</a>
                  </td>
                  <td>{$recursoEducacional['escolaridade']}</td>
                  <td>{$recursoEducacional['tipo']}</td>
                </tr>
              ";
            }
          } else {
            echo "
              <tr>
                <td colspan='6' class='text-center'>Nenhum recurso educacional cadastrado no sistema.</td>
              </tr>
            ";
          }
          ?>
        </tbody>
      </table>
      <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuario" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title">Editar Usuário</h2>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type='submit' class='btn' onclick='editarUsuario()'>Editar Usuário</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modalAdicionarUsuario" tabindex="-1" aria-labelledby="modalAdicionarUsuario" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title">Adicionar Usuário</h2>
            </div>
            <div class="modal-body">
              <form action="#" method="post">

                <fieldset>
                  <label for="ipt-nome-usuario" class="form-label">Nome do usuário</label>
                  <input type="text" name="ipt-nome-usuario" id="ipt-nome-usuario" class="form-control" placeholder="Números Romanos" required>
                </fieldset>


                <fieldset>
                  <label for="ipt-email-usuario" class="form-label">Email do usuário</label>
                  <input type="email" name="ipt-email-usuario" id="ipt-email-usuario" class="form-control" placeholder="https://mundoescola.com.br" required>
                </fieldset>

                <fieldset>
                  <label for="ipt-senha-usuario" class="form-label">Senha do usuário</label>
                  <input type="text" name="ipt-senha-usuario" id="ipt-senha-usuario" class="form-control" placeholder="https://mundoescola.com.br" required>
                </fieldset>

                <fieldset>
                  <label for="select-categoria" class="form-label">Selecione a categoria do usuário</label>
                  <select class="form-control form-select" name="select-categoria" id="select-categoria">
                    <option value="0" selected disabled>Categoria</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Professor">Professor</option>
                    <option value="Responsável">Responsável</option>
                    <option value="Aluno">Aluno</option>
                  </select>
                </fieldset>

                </fieldset>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type='submit' class='btn' onclick='editarUsuario()'>Adicionar Usuário</button>
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
  <script src="../assets/js/pages__pagina-inicial-administrador.js"></script>

</body>

</html>