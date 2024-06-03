function abrirModalEditarUsuario(idUsuario) {
    console.log(idUsuario);
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
    console.log(categoria);
    let data = {
        idUsuario,
        nome,
        email,
        categoria,
    };
    switch (categoria) {
        case 'Aluno':
            data.escola = $('#ipt-escola-aluno').val();
            data.dataNascimento = $('#ipt-dataNascimento-aluno').val();
            data.genero = $('#select-genero-aluno').val();
            data.escolaridade = $('#select-escolaridade').val();
            break;
        case 'Responsavel':
            data.cpf = $('#ipt-cpf-responsavel').val();
            data.telefone = $('#ipt-telefone-responsavel').val();
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
        success: function (response) {},
        error: (err) => console.log(err),
    });
}

function excluirUsuario(idUsuario) {
    console.log(idUsuario);
    $.ajax({
        type: 'POST',
        url: '',
        data: {},
        success: function (response) {},
        erro: (err) => console.log(err),
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
    $('#modalAdicionarUsuario').modal('show');
}
