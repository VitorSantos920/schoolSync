<?php

require_once "../db/config.php";



session_start();



if (!isset($_SESSION['email']) || $_SESSION['categoria'] != "Administrador") {

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

  <title>Gerenciar Contas | Administrador</title>

  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

  <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">

  <link rel="stylesheet" href="../assets/css/gerenciar-contas.css">

</head>



<body>

  <?php

  include_once "../components/sidebarAdmin.php"

  ?>

  <main>



    <h1>Gerenciar Contas</h1>



    <section class="acoes d-flex align-align-items-md-center gap-2">

      <input type="text" name="pesquisa-usuario" id="pesquisa-usuario" placeholder="Pesquise pelo nome, email ou categoria" onchange="pesquisarUsuario()">

      <button class="btn btn-adicionar-usuario" onclick="abrirModalAdicionarUsuario()">Adicionar Usuário</button>

    </section>



    <div class="table-responsive">

      <table class="table table-borderless align-middle caption-top" id="table-users">

        <caption>Lista de Usuários</caption>

        <thead>

          <tr>

            <th>Nome</th>

            <th>Email</th>

            <th>Categoria</th>

            <th>Ações</th>

          </tr>

        </thead>

        <tbody>

          <?php

          foreach ($usuarios as $usuario) {

            echo "

              <tr>

                <td>{$usuario['nome']}</td>

                <td>{$usuario['email']}</td>

                <td>{$usuario['categoria']}</td>

                <td>

                  <button class='btn btn-warning' onclick='abrirModalEditarUsuario($usuario[id])'>Editar</button>

                  <button class='btn btn-danger' onclick='excluirUsuario($usuario[id])'>Excluir</button>

                </td>

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

  </main>

  <script src="../assets/js/jquery.min.js"></script>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>

  <script src="../assets/js/sweetalert2.all.min.js"></script>

  <script src="../assets/js/gerenciar-contas.js"></script>

</body>



</html>