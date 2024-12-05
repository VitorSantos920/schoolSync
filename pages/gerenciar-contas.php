<?php
require_once "../backend/init-configs.php";

if ($_SESSION['categoria'] != "Administrador") {
  header('Location: ./permissao.php');
  exit;
}
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
  <link rel="shortcut icon" href="../assets/img/logo_transparente.png" type="image/x-icon">
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

                    <!-- Aluno -->
                    <fieldset data-categoria='Aluno'>
                      <label for='ipt-escola-aluno' class='form-label'>Escola do Aluno</label>
                      <input type='text' name='ipt-escola-aluno' id='ipt-escola-aluno' class='form-control' placeholder='E.E. Carlos Gomes' required>
                    </fieldset>
                    <fieldset data-categoria='Aluno'>
                      <label for='ipt-dataNascimento-aluno' class='form-label'>Data de Nascimento</label>
                      <input type='date' name='ipt-dataNascimento-aluno' id='ipt-dataNascimento-aluno' class='form-control' required>
                    </fieldset>
                    <fieldset data-categoria='Aluno'>
                      <label for='select-genero-aluno' class='form-label'>Gênero do Aluno</label>
                      <select class='form-control form-select' name='select-genero-aluno' id='select-genero-aluno' required>
                        <option value='0' disabled selected>Gênero</option>
                        <option value='Masculino'>Masculino</option>
                        <option value='Feminino'>Feminino</option>
                      </select>
                    </fieldset>
                    <fieldset data-categoria='Aluno'>
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

                    <!-- Professor -->
                    <fieldset data-categoria="Professor">
                      <label for='ipt-cpf' class='form-label'>CPF do Professor</label>
                      <input type='text' id='cpf-professor' class='form-control' placeholder='999-999-999-99' required>
                    </fieldset>

                    <!-- Administrador -->
                    <fieldset data-categoria="Administrador">
                      <label for='ipt-cargo-adm' class='form-label'>Cargo do Administrador</label>
                      <input type='text' name='ipt-cargo-adm' id='ipt-cargo-adm' class='form-control' placeholder='Feedbacks' required>
                    </fieldset>
                    <fieldset>

                      <!-- Responsável -->
                      <fieldset data-categoria="Responsável">
                        <label for='ipt-cpf-responsavel' class='form-label'>CPF do Responsável</label>
                        <input type='text' name='ipt-cpf-responsavel' id='ipt-cpf-responsavel' class='form-control' placeholder='999-999-999-99' required>
                      </fieldset>
                      <fieldset data-categoria="Responsável">
                        <label for='ipt-telefone-responsavel' class='form-label'>Telefone do Responsável</label>
                        <input type='text' id='ipt-telefone-responsavel' name='ipt-telefone-responsavel' placeholder='(99) 99999-9999' class='form-control' required>
                      </fieldset>
                      <fieldset data-categoria="Responsável">
                        <label for='ipt-quantidade-filhos' class='form-label'>Quantidade de Filhos</label>
                        <input type='text' id='ipt-quantidade-filhos' name='ipt-quantidade-filhos' placeholder='1' class='form-control' required>
                      </fieldset>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn" onclick="adicionarUsuario()">Adicionar Usuário</button>
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
  <script src="../plugins/vanilla-masker.js"></script>
  <script src="../assets/js/gerenciar-contas.js"></script>
</body>

</html>