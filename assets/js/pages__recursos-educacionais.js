$(document).ready(function () {
    carregarTabelaRecursosEducacionais();
});

function modalCriacaoMaterialApoio() {
    $('#criacaoMaterialApoio').modal('show');
    $('#ipt-nome-material').val('');
    $('#ipt-descricao-material').val('');
    $('#ipt-url-material').val('');
    $('#select-escolaridade').val(0);
    $('#select-tipo-material').val(0);
}

function criarMaterialApoio() {
    let nomeMaterial = $('#ipt-nome-material').val();
    let descricaoMaterial = $('#ipt-descricao-material').val();
    let urlMaterial = $('#ipt-url-material').val();
    let escolaridade = $('#select-escolaridade').val();
    let tipoMaterial = $('#select-tipo-material').val();

    if (
        !nomeMaterial ||
        !descricaoMaterial ||
        !urlMaterial ||
        !escolaridade ||
        !tipoMaterial
    ) {
        Swal.fire({
            title: 'Opa, algo deu errado!',

            text: 'Para criar o Recurso Educacional, é necessário o preenchimento de todos os campos.',

            icon: 'error',
        });

        return;
    }

    $.ajax({
        type: 'POST',
        url: '../backend/criar-material-apoio.php',
        data: {
            nome: nomeMaterial,
            descricao: descricaoMaterial,
            url: urlMaterial,
            escolaridade,
            tipo: tipoMaterial,
        },

        success: function (response) {
            response = JSON.parse(response);
            console.log(response);
            switch (response.status) {
                case 1: {
                    Swal.fire({
                        title: 'Recurso criado!',
                        text: response.message,
                        icon: 'success',
                    });

                    carregarTabelaRecursosEducacionais();
                    break;
                }

                case -1: {
                    Swal.fire({
                        title: 'Erro Interno!',
                        text: response.swalMessage,
                        icon: 'error',
                    });

                    console.log(
                        `Status: ${response.status} | Mensagem de Erro: ${response.messageError}`
                    );

                    break;
                }
            }
            $('#criacaoMaterialApoio').modal('hide');
        },

        error: (err) => console.log(err),
    });
}

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
