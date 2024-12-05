$(document).ready(function () {
  carregarTabelaUsuarios();

  VMasker($(':is(#cpf-professor, #ipt-cpf-responsavel)')).maskPattern(
    '999.999.999-99'
  );
  VMasker($('#ipt-telefone-responsavel')).maskPattern('(99) 99999-9999');
});

function abrirModalEditarUsuario(idUsuario) {
  $.ajax({
    type: 'POST',
    url: '../backend/gerenciar-contas_preencher-modal-editar-usuario.php',
    data: {
      idUsuario,
    },
    success: function (response) {
      response = JSON.parse(response);
      console.log(response);
      $('#modalEditarUsuario .modal-body').html(response.html);
    },
    error: (err) => console.log(err),
  });
  $('#modalEditarUsuario').modal('show');
}

function editarUsuario() {
  let idUsuario = $('#id-usuario').val();
  let nome = $('#ipt-nome').val();
  let email = $('#ipt-email').val();
  let categoria = $('#select-categoria').val();
  let status = $('#select-status').val();

  let data = {
    idUsuario,
    nome,
    email,
    categoria,
    status,
  };

  // switch (categoria) {
  //   case 'Aluno':
  //     data.escola = $('#ipt-escola-aluno').val();
  //     data.dataNascimento = $('#ipt-dataNascimento-aluno').val();
  //     data.genero = $('#select-genero-aluno').val();
  //     data.escolaridade = $('#select-escolaridade').val();
  //     break;
  //   case 'Responsavel':
  //     data.cpf = $('#ipt-cpf-responsavel').val();
  //     data.telefone = $('#ipt-telefone-responsavel').val();
  //     break;
  //   case 'Administrador':
  //     data.cargo = $('#ipt-cargo-adm').val();
  //     break;
  //   case 'Professor':
  //     data.cpf = $('#cpf-professor').val();
  //     break;
  // }

  for (const key in data) {
    if (!data[key]) {
      Swal.fire({
        title: 'Opa, algo deu errado!',
        text: 'Para editar o usuário, é necessário o preenchimento de todos os campos.',
        icon: 'error',
      });
      return;
    }
  }

  console.log(data);
  $.ajax({
    type: 'POST',
    url: '../backend/editar-usuario.php',
    data: data,
    success: function (response) {
      response = JSON.parse(response);

      switch (response.status) {
        case 1:
          Swal.fire({
            title: 'Usuário editado!',
            text: response.swalMessage,
            icon: 'success',
          });
          $('#modalEditarUsuario').modal('hide');

          carregarTabelaUsuarios();
          break;
        case -1:
          Swal.fire({
            title: 'Erro interno!',
            text: response.swalMessage,
            icon: 'error',
          });
          break;
      }
    },
    error: (err) => console.log(err),
  });
}

function excluirUsuario(idUsuario) {
  Swal.fire({
    title: 'Realmente deseja excluir este usuário?',
    text: 'Esta ação não pode ser desfeita!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6e7881',
    confirmButtonText: 'Sim, quero deletar este usuário!',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: 'POST',
        url: '../backend/excluir-usuario.php',
        data: { idUsuario: idUsuario },
        success: function (response) {
          response = JSON.parse(response);

          Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: response.swalMessage,
          });

          carregarTabelaUsuarios();
        },
        error: (err) => console.log(err),
      });
    }
  });
}

function pesquisarUsuario() {
  let pesquisa = $('#pesquisa-usuario').val();
  console.log(pesquisa);
  $.ajax({
    type: 'POST',
    url: '../backend/gerenciar-contas_pesquisar-usuario.php',
    data: {
      pesquisa,
    },
    success: function (response) {
      response = JSON.parse(response);
      $('#table-users tbody').html(response.html);
      console.log(response);
    },
    error: (err) => console.log(err),
  });
}

function abrirModalAdicionarUsuario() {
  limparInputs([
    '#ipt-nome-usuario',
    '#ipt-email-usuario',
    '#ipt-senha-usuario',
    '#select-categoria',
  ]);

  $('[data-categoria]').hide();

  $('#modalAdicionarUsuario').modal('show');
}

function adicionarUsuario() {
  let nome = $('#ipt-nome-usuario').val();
  let email = $('#ipt-email-usuario').val();
  let senha = $('#ipt-senha-usuario').val();
  let categoria = $('#select-categoria').val();

  let data = {
    nome,
    email,
    senha,
    categoria,
  };

  switch (categoria) {
    case 'Aluno':
      data.escola = $('#ipt-escola-aluno').val();
      data.dataNascimento = $('#ipt-dataNascimento-aluno').val();
      data.genero = $('#select-genero-aluno').val();
      data.escolaridade = $('#select-escolaridade').val();
      break;
    case 'Responsável':
      data.cpf = $('#ipt-cpf-responsavel').val();
      data.telefone = $('#ipt-telefone-responsavel').val();
      data.quantidadeFilho = $('#ipt-quantidade-filhos').val();
      break;
    case 'Administrador':
      data.cargo = $('#ipt-cargo-adm').val();
      break;
    case 'Professor':
      data.cpf = $('#cpf-professor').val();
      break;
  }

  for (const key in data) {
    if (!data[key]) {
      Swal.fire({
        title: 'Opa, algo deu errado!',
        text: 'Para adicionar o usuário, é necessário o preenchimento de todos os campos.',
        icon: 'error',
      });
      return;
    }
  }

  $.ajax({
    type: 'POST',
    url: '../backend/adicionar-usuario.php',
    data: data,
    success: function (response) {
      response = JSON.parse(response);

      switch (response.status) {
        case 1:
          Swal.fire({
            title: 'Usuário adicionado!',
            text: response.swalMessage,
            icon: 'success',
          });
          $('#modalAdicionarUsuario').modal('hide');

          carregarTabelaUsuarios();
          break;
        case -1:
          Swal.fire({
            title: 'Erro interno!',
            text: response.swalMessage,
            icon: 'error',
          });
          break;
      }
    },
    error: (err) => console.log(err),
  });
}

function carregarTabelaUsuarios() {
  $.ajax({
    type: 'POST',
    url: '../backend/gerenciar-contas__preencher-tabela-usuarios.php',
    data: {
      liberado: 1,
    },
    success: function (response) {
      response = JSON.parse(response);

      switch (response.status) {
        case -1:
          console.log(response);
          break;

        case 1:
          $('#table-users tbody').html(response.corpoTabela);
          break;
      }
      $('#table-users tbody').html(response.html);
    },
    error: (error) => console.log(error),
  });
}

function trocarCategoriaUsuario(categoria) {
  $('[data-categoria]').hide();

  $(`[data-categoria="${categoria}"]`).show();
}
