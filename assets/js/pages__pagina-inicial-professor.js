function abrirModalDetalhes(
    id,
    titulo,
    descricao,
    url,
    escolaridade,
    tipoMaterial,
    criadoEm
) {
    $('#id-material').text(`#${id}`);
    $('#titulo-material').text(`${titulo}`);
    $('#descricao-material').text(`${descricao}`);
    $('#tipo-material').text(`${tipoMaterial}`);
    $('#escolaridade-material').text(`${escolaridade}`);
    $('#url-material').attr('href', url);
    $('#created-at').text(`Criado em: ${criadoEm}`);

    $('#modalMaterialApoio').modal('show');
}

// abrirModalCriacaoAluno();

function abrirModalCriacaoResponsavel() {
    $('#ipt-nome-responsavel').val('');
    $('#ipt-email-responsavel').val('');
    $('#ipt-senha-responsavel').val('');
    $('#ipt-cpf-responsavel').val('');
    $('#ipt-telefone-responsavel').val('');
    $('#modalCriacaoResponsavel').modal('show');
}

function criarResponsavel() {
    let nome = $('#ipt-nome-responsavel').val();
    let email = $('#ipt-email-responsavel').val();
    let senha = $('#ipt-senha-responsavel').val();
    let cpf = $('#ipt-cpf-responsavel').val();
    let telefone = $('#ipt-telefone-responsavel').val();

    if (
        nome == '' ||
        email == '' ||
        senha == '' ||
        cpf == '' ||
        telefone == ''
    ) {
        Swal.fire({
            icon: 'error',
            title: 'Opa, algo deu errado!',
            text: 'Para realizar o cadastro de um responsável, todos os campos devem estar preenchidos!',
        });

        return;
    }
    $.ajax({
        type: 'POST',
        url: '../backend/criar-responsavel.php',
        data: {
            nome,
            email,
            senha,
            cpf,
            telefone,
        },
        success: function (response) {
            response = JSON.parse(response);
            console.log(response);

            switch (response.status) {
                case 1: {
                    Swal.fire({
                        icon: 'success',
                        title: 'Responsável criado!',
                        text: response.swalMessage,
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
        },
        error: (err) => console.log(err),
    });
}

function abrirModalCriacaoAluno() {
    $('#ipt-nome').val('');
    $('#ipt-email').val('');
    $('#ipt-senha').val('');
    $('#ipt-escola-aluno').val('');
    $('#ipt-dataNascimento-aluno').val('');
    $('#select-genero-aluno').val('');
    $('#select-escolaridade').val('');
    $('#modalCriacaoAluno').modal('show');
}

function criarAluno() {
    let nome = $('#ipt-nome-aluno').val();
    let email = $('#ipt-email-aluno').val();
    let senha = $('#ipt-senha-aluno').val();
    let escola = $('#ipt-escola-aluno').val();
    let dataNascimento = $('#ipt-dataNascimento-aluno').val();
    let genero = $('#select-genero-aluno').val();
    let escolaridade = $('#select-escolaridade').val();

    if (
        nome == '' ||
        email == '' ||
        senha == '' ||
        escola == '' ||
        dataNascimento == '' ||
        genero == '' ||
        escolaridade == ''
    ) {
        Swal.fire({
            icon: 'error',
            title: 'Opa, algo deu errado!',
            text: 'Para realizar o cadastro de um aluno, todos os campos devem estar preenchidos!',
        });

        return;
    }
    $.ajax({
        type: 'POST',
        url: '../backend/criar-aluno.php',
        data: {
            nome,
            email,
            senha,
            escola,
            dataNascimento,
            genero,
            escolaridade,
        },
        success: function (response) {
            response = JSON.parse(response);
            console.log(response);

            switch (response.status) {
                case 1: {
                    Swal.fire({
                        icon: 'success',
                        title: 'Aluno criado!',
                        text: response.swalMessage,
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
        },
        error: (err) => console.log(err),
    });
}
