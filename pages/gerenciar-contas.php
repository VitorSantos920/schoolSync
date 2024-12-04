<?php
require_once "../backend/init-configs.php";

if ($_SESSION['categoria'] != "Administrador") {
  header('Location: ./permissao.php');
  exit;
}

$usuarios = DB::query("SELECT * FROM usuario");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar Contas - Administrador | SchoolSync</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
  <link rel="stylesheet" href="../assets/css/gerenciar-contas.css">
</head>

<body>
  <div class="wrapper">
    <div class="content-wrapper">
      <?php
      include_once "../components/sidebar.php";
      include_once "../components/header.php"
      ?>

      <main>
        <h1>Gerenciar Contas</h1>
        <section class="acoes d-flex align-align-items-md-center gap-2">
          <input type="text" class="form-control" name="pesquisa-usuario" id="pesquisa-usuario" placeholder="Pesquise pelo nome, email ou categoria" onchange="pesquisarUsuario()">
          <button class="btn btn-adicionar-usuario" onclick="abrirModalAdicionarUsuario()">+ Adicionar Usuário</button>
        </section>

        <div class="table-responsive">
          <table class="table table-borderless align-middle caption-top" id="table-users">
            <caption>Lista de Usuários</caption>
            <thead>
              <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Categoria</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($usuarios as $usuario) {
                if ($usuario['categoria'] == "Professor") {
                  $tabela = "professor";
                } elseif ($usuario['categoria'] == "Aluno") {
                  $tabela = "aluno";
                } elseif ($usuario['categoria'] == "Responsavel") {
                  $tabela = "responsavel";
                } else {
                  $tabela = "administrador";
                }

                $usuarioAtivo = DB::queryFirstField("SELECT status FROM usuario WHERE id = %i", $usuario['id']);

              ?>
                <tr>
                  <td><?= $usuario['id'] ?></td>
                  <td><?= $usuario['nome'] ?></td>
                  <td><?= $usuario['email'] ?></td>
                  <td><?= $usuario['categoria'] ?></td>
                  <td><?= ($usuarioAtivo == 0 ? "<i class='fas fa-circle' style='color: red;'></i>" : "<i class='fas fa-circle' style='color: green;'></i>") ?></td>
                  <td>
                    <button class="btn btn-warning" onclick="abrirModalEditarUsuario(<?= $usuario['id'] ?>)">Editar</button>
                    <button class="btn btn-danger" onclick="excluirUsuario(<?= $usuario['id'] ?>)">Excluir</button>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

          <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuario" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h2 class="modal-title">Editar Usuário</h2>
                </div>
                <div class="modal-body">
                  <!-- Conteúdo do modal -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn" onclick="editarUsuario()">Editar Usuário</button>
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
                      <input type="text" name="ipt-nome-usuario" id="ipt-nome-usuario" class="form-control" placeholder="João Guilherme" required>
                    </fieldset>
                    <fieldset>
                      <label for="ipt-email-usuario" class="form-label">Email do usuário</label>
                      <input type="email" name="ipt-email-usuario" id="ipt-email-usuario" class="form-control" placeholder="email@exemplo.com" required>
                    </fieldset>
                    <fieldset>
                      <label for="ipt-senha-usuario" class="form-label">Senha do usuário</label>
                      <input type="password" name="ipt-senha-usuario" id="ipt-senha-usuario" class="form-control" placeholder="*********" required>
                    </fieldset>
                    <fieldset>
                      <label for="select-categoria" class="form-label">Selecione a categoria do usuário</label>
                      <select class="form-control form-select" name="select-categoria" id="select-categoria" onchange="trocarCategoriaUsuario(this.value)">
                        <option value="-1" selected disabled>Categoria</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Professor">Professor</option>
                        <option value="Responsável">Responsável</option>
                        <option value="Aluno">Aluno</option>
                      </select>
                    </fieldset>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn" onclick="editarUsuario()">Adicionar Usuário</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>


  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sweetalert2.all.min.js"></script>
  <script src="../assets/js/utils.js"></script>
  <script src="../assets/js/gerenciar-contas.js"></script>
</body>

</html>