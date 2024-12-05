$(document).ready(function () {
  carregarTabelaRecursosEducacionais();
});

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
