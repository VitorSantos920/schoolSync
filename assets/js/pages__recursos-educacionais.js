$(document).ready(function () {
  carregarTabelaRecursosEducacionais();
});

function modalEditarMaterialApoio() {}

function excluirRecurso(idRecurso) {
  Swal.fire({
    title: 'Realmente deseja excluir este material de apoio?',
    text: 'Esta ação não pode ser desfeita!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6e7881',
    confirmButtonText: 'Sim, quero deletar este material!',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: 'POST',
        url: '../backend/excluir-material-apoio.php',
        data: {
          idRecurso,
        },
        success: function (response) {
          response = JSON.parse(response);

          switch (response.status) {
            case 1:
              Swal.fire({
                title: 'Recurso educacional excluído!',
                text: response.swalMessage,
                icon: 'success',
              });

              carregarTabelaRecursosEducacionais();
              break;
            case -1:
              Swal.fire({
                title: 'Ocorreu um erro interno!',
                text: response.swalMessage,
                icon: 'error',
              });

              break;
          }
        },
        error: (err) => console.log(err),
      });
    }
  });
}

function carregarTabelaRecursosEducacionais() {
  $.ajax({
    type: 'POST',
    url: '../backend/carregar-tabela-recursos-educacionais.php',
    data: {
      liberado: 1,
    },
    success: function (tableBody) {
      tableBody = JSON.parse(tableBody);
      console.log(tableBody);

      $('#tbody-recursos-educacionais').html(tableBody.tableBody);
    },
  });
}
