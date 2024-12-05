<?php
require_once '../backend/init-configs.php';

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
  <meta name="description" content="Página inicial do professor ao realizar o login com sucesso no sistema SchoolSync">
  <meta name="keywords" content="docente, professor, tela inicial">
  <title>Recursos Educacionais - Administrador | SchoolSync</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
  <link rel="shortcut icon" href="../assets/img/logo_transparente.png" type="image/x-icon">


  <style>
    table.table th {
      background-color: var(--brand-color);
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="content-wrapper">
      <?php
      include_once "../components/sidebar.php";
      include_once "../components/header.php";
      ?>

      <main>
        <div class="table-responsive">
          <table class="table table-borderless align-middle caption-top" id="table-recursos-educacionais">
            <caption>Lista de Recursos Educacionais Cadastrados no SchoolSync</caption>
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
            <tbody id="tbody-recursos-educacionais"></tbody>
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


      </main>
    </div>
  </div>

  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/sweetalert2.all.min.js"></script>
  <script src="../assets/js/pages__recursos-educacionais.js"></script>
</body>

</html>