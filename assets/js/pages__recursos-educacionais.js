function modalCriacaoMaterialApoio() {
    $('#criacaoMaterialApoio').modal('show');
    $('#nome-material').val('');
    $('#descricao-material').val('');
    $('#url-material').val('');
    $('#escolaridade').val('');
    $('#tipo-material').val('');
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
