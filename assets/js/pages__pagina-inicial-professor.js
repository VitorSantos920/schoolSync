$(document).ready(function () {
    VMasker($('#ipt-cpf-responsavel')).maskPattern('999.999.999-99');
    VMasker($('#ipt-telefone-responsavel')).maskPattern('(99) 99999-9999');
});

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

function abrirModalCriacaoResponsavel() {
    limparInputs([
        '#ipt-nome-responsavel',
        '#ipt-email-responsavel',
        '#ipt-senha-responsavel',
        '#ipt-cpf-responsavel',
        '#ipt-telefone-responsavel',
    ]);

    $('#modalCriacaoResponsavel').modal('show');
}

function criarResponsavel() {
    let dadosRegistro = {
        nome: $('#ipt-nome-responsavel').val(),
        email: $('#ipt-email-responsavel').val(),
        senha: $('#ipt-senha-responsavel').val(),
        cpf: $('#ipt-cpf-responsavel').val(),
        telefone: $('#ipt-telefone-responsavel').val(),
    };

    let verificacao = verificaInputsVazios(dadosRegistro, 'responsavel');

    if (verificacao) {
        alertaErroCadastro(verificacao, 'responsável');

        return;
    }

    if (
        !verificaNomeUsuario(dadosRegistro.nome, 'responsável') ||
        !verificaEmailUsuario(dadosRegistro.email, 'responsável')
    ) {
        return;
    }

    $.ajax({
        type: 'POST',
        url: '../backend/criar-responsavel.php',
        data: dadosRegistro,

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

                    $('#modalCriacaoResponsavel').modal('hide');
                    break;
                }

                case 0: {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao cadastrar o responsável!',
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

                    $('#modalCriacaoResponsavel').modal('hide');
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
    limparInputs([
        '#ipt-nome-aluno',
        '#ipt-email-aluno',
        '#ipt-senha-aluno',
        '#select-responsavel-aluno',
        '#select-classe-aluno',
        '#ipt-escola-aluno',
        '#ipt-dataNascimento-aluno',
        '#select-genero-aluno',
        '#select-escolaridade',
    ]);

    $('#modalCriacaoAluno').modal('show');
}

function criarAluno() {
    let dadosRegistro = {
        nome: $('#ipt-nome-aluno').val(),
        email: $('#ipt-email-aluno').val(),
        senha: $('#ipt-senha-aluno').val(),
        responsavel: $('#select-responsavel-aluno').val(),
        classe: $('#select-classe-aluno').val(),
        escola: $('#ipt-escola-aluno').val(),
        dataNascimento: $('#ipt-dataNascimento-aluno').val(),
        genero: $('#select-genero-aluno').val(),
        escolaridade: $('#select-escolaridade').val(),
    };

    let verificacao = verificaInputsVazios(dadosRegistro, 'aluno');

    if (verificacao) {
        alertaErroCadastro(verificacao, 'aluno');
        return;
    }

    if (
        !verificaNomeUsuario(dadosRegistro.nome, 'aluno') ||
        !verificaEmailUsuario(dadosRegistro.email, 'aluno')
    )
        return;

    $.ajax({
        type: 'POST',
        url: '../backend/criar-aluno.php',
        data: dadosRegistro,

        success: function (response) {
            response = JSON.parse(response);

            switch (response.status) {
                case 1: {
                    Swal.fire({
                        icon: 'success',
                        title: 'Aluno criado!',
                        text: response.swalMessage,
                    });

                    $('#modalCriacaoAluno').modal('hide');
                    break;
                }

                case -1: {
                    Swal.fire({
                        title: 'Erro Interno!',
                        text: response.swalMessage,
                        icon: 'error',
                    });

                    $('#modalCriacaoAluno').modal('hide');
                    console.log(
                        `Status: ${response.status} | Mensagem de Erro: ${response.messageError}`
                    );

                    break;
                }

                case 0: {
                    Swal.fire({
                        title: 'Erro ao cadastrar o aluno!',
                        text: response.swalMessage,
                        icon: 'error',
                    });
                }
            }
        },

        error: (err) => console.log(err),
    });
}

function abrirModalCriacaoTurma() {
    limparInputs(['#ipt-nome-turma', '#select-turma-escolaridade']);

    $('#modalCriacaoTurma').modal('show');
}

function criarTurma() {
    let nome = $('#ipt-nome-turma').val();
    let escolaridade = $('#select-turma-escolaridade').val();

    let dadosRegistro = {
        nome,
        escolaridade,
    };

    let verificacao = verificaInputsVazios(dadosRegistro, 'turma');

    if (verificacao) {
        alertaErroCadastro(verificacao, 'turma');

        return;
    }

    $.ajax({
        type: 'POST',
        url: '../backend/criar-turma.php',
        data: dadosRegistro,
        success: function (response) {
            response = JSON.parse(response);
            switch (response.status) {
                case 1:
                    Swal.fire({
                        icon: 'success',
                        title: 'Turma criada!',
                        text: response.swalMessage,
                    });

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                    break;

                case 2:
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro Interno',
                        text: response.swalMessage,
                    });
                    break;
            }
            console.log(response);
        },
        error: (e) => console.log(e),
    });
}

function limparInputs(inputsId) {
    inputsId.forEach((id) => {
        $(id).val('');
    });
}

function verificaInputsVazios(valuesInput, categoria) {
    let campos = [];

    let camposLegiveis = {
        nome: 'Nome',
    };

    if (categoria == 'responsavel') {
        camposLegiveis.cpf = 'CPF';
        camposLegiveis.telefone = 'Telefone';
        camposLegiveis.email = 'Email';
        camposLegiveis.senha = 'Senha';
    } else if (categoria == 'aluno') {
        camposLegiveis.email = 'Email';
        camposLegiveis.senha = 'Senha';
        camposLegiveis.responsavel = 'Responsável';
        camposLegiveis.classe = 'Classe';
        camposLegiveis.escola = 'Escola';
        camposLegiveis.dataNascimento = 'Data de Nascimento';
        camposLegiveis.genero = 'Gênero';
        camposLegiveis.escolaridade = 'Escolaridade';
    } else if (categoria == 'turma') {
        camposLegiveis.escolaridade = 'Escolaridade';
    } else {
        camposLegiveis.descricao = 'Descrição';
        camposLegiveis.classe = 'Classe';
        camposLegiveis.dataInicio = 'Data de Início';
        camposLegiveis.dataFim = 'Data de Término';
    }

    for (const key in valuesInput) {
        if (valuesInput[key] == '' || valuesInput[key] == null) {
            campos.push(camposLegiveis[key]);
        }
    }

    if (campos.length > 0) return campos;

    return false;
}

function alertaErroCadastro(camposVazios, cadastroDe) {
    let text = `Para realizar o cadastro de um(a) ${cadastroDe}, preencha os campos restantes: `;

    camposVazios.forEach((campo, index) => {
        if (camposVazios.length == 1) {
            text += `${campo}.`;
        } else if (index == camposVazios.length - 1) {
            text += `e ${campo}.`;
        } else if (index == camposVazios.length - 2) {
            text += `${campo} `;
        } else {
            text += `${campo}, `;
        }
    });

    Swal.fire({
        icon: 'error',
        title: 'Opa, algo deu errado!',
        text,
    });
}

function verificaNomeUsuario(nome, categoria) {
    const regexNome =
        /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]*[^\d\s][A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]*$/;

    if (!regexNome.test(nome)) {
        Swal.fire({
            icon: 'error',
            title: `Erro ao cadastrar o ${categoria}!`,
            text: `Não é possível cadastrar um ${categoria} com este nome. Verifique-o e tente novamente!`,
        });

        return false;
    }

    if (nome.length < 3) {
        Swal.fire({
            icon: 'error',
            title: `Erro ao cadastrar o ${categoria}!`,
            text: `O nome do ${categoria} é muito curto!`,
        });

        return false;
    }

    if (!nome.includes(' ')) {
        Swal.fire({
            icon: 'error',
            title: `Erro ao cadastrar o ${categoria}!`,
            text: `É necessário inserir, no mínimo, o nome e sobrenome do ${categoria}!`,
        });

        return false;
    }
    return true;
}

function verificaEmailUsuario(email, categoria) {
    const regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (!regexEmail.test(email)) {
        Swal.fire({
            icon: 'error',
            title: `Erro ao cadastrar o ${categoria}`,
            text: `Não é possível cadastrar um ${categoria} com este email. Verifique-o e tente novamente!`,
        });

        return false;
    }

    return true;
}

function agendarEventoEscolar() {
    let dadosAgendamento = {
        nome: $('#nome-evento').val(),
        classe: $('#classe-evento').val(),
        descricao: $('#descricao-evento').val(),
        dataInicio: $('#data-inicio').val(),
        dataFim: $('#data-fim').val(),
    };

    let verificacao = verificaInputsVazios(dadosAgendamento);

    if (verificacao) {
        alertaErroCadastro(verificacao, 'evento');
        return;
    }

    $.ajax({
        type: 'POST',
        url: '../backend/agendar-evento-escolar.php',
        data: dadosAgendamento,
        success: function (response) {
            response = JSON.parse(response);
            console.log(response);

            switch (response.status) {
                case 1:
                    Swal.fire({
                        icon: 'success',
                        title: 'Evento agendado!',
                        text: response.swalMessage,
                    });

                    limparInputs([
                        '#nome-evento',
                        '#classe-evento',
                        '#descricao-evento',
                        '#data-inicio',
                        '#data-fim',
                    ]);
                    break;
                case -1:
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro Interno!',
                        text: response.swalMessage,
                    });

                    console.log(response.error);
                    break;
            }
        },
        error: (err) => console.log(err),
    });
}
