$(document).ready(function () {
    carregaTabelaListaAlunos();
});

function abrirModalEditarAluno(idAluno) {
    $.ajax({
        type: 'POST',
        url: '../backend/lista-alunos_preencher-modal-editar-aluno.php',
        data: {
            idAluno,
        },
        success: function (response) {
            response = JSON.parse(response);
            console.log(response);

            $('#corpo-modal').html(response.modalBody);
        },
        error: (err) => console.log(err),
    });

    $('#edtAlunoModal').modal('show');
}

function editarAluno() {
    let dadosAlteracoes = {
        idAluno: $('#id-aluno').val(),
        nome: $('#nome').val(),
        dataNascimento: $('#data_nascimento').val(),
        escolaridade: $('#escolaridade').val(),
        classe: $('#classe').val(),
        escola: $('#escola').val(),
        genero: $('#genero').val(),
    };

    if (verificaInputsVazios(dadosAlteracoes)) {
        Swal.fire({
            icon: 'error',
            title: 'Opa, algo deu errado!',
            text: 'Para realizar a edição de um aluno, é necessário o preenchimento de todos os  campos.',
        });

        return;
    }

    $.ajax({
        type: 'POST',
        url: '../backend/lista-alunos_editar-aluno.php',
        data: dadosAlteracoes,
        success: function (response) {
            response = JSON.parse(response);
            console.log(response);

            switch (response.status) {
                case -1:
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro Interno',
                        text: response.swalMessage,
                    });

                    console.log(response.error);
                    break;
                case 1:
                    Swal.fire({
                        icon: 'success',
                        title: 'Dados editados!',
                        text: response.swalMessage,
                    });

                    carregaTabelaListaAlunos();
                    break;
            }
            $('#edtAlunoModal').modal('hide');
        },
        error: (err) => console.log(err),
    });
}

function verificaInputsVazios(inputsValue) {
    for (const key in inputsValue) {
        if (inputsValue[key] == '' || inputsValue[key] == null) {
            return true;
        }
    }

    return false;
}

function carregaTabelaListaAlunos() {
    let classeId = $('#classe-id').val();

    $.ajax({
        type: 'POST',
        url: '../backend/carregar-tabela-lista-alunos.php',
        data: {
            classeId,
            liberado: 1,
        },
        success: function (response) {
            response = JSON.parse(response);
            console.log(response);
            $('#tbody-lista-alunos').html(response.tableBody);

            response.quantidadeAlunos == 1
                ? $('#quantidade').text(`${response.quantidadeAlunos} Aluno`)
                : $('#quantidade').text(`${response.quantidadeAlunos} Alunos`);
        },
    });
}

function deletarAluno(idAluno) {
    console.log(idAluno);

    $.ajax({
        type: 'POST',
        url: '../backend/deletar-aluno.php',
        data: {
            idAluno,
        },
        success: function (response) {
            response = JSON.parse(response);
            console.log(response);
            switch (response.status) {
                case -1:
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro Interno!',
                        text: response.swalMessage,
                    });
                    break;
                case 1:
                    Swal.fire({
                        icon: 'success',
                        title: 'Aluno excluído!',
                        text: response.swalMessage,
                    });
                    carregaTabelaListaAlunos();
                    break;
            }
        },
        error: (e) => console.log(e),
    });
}
