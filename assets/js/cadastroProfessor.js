$(document).ready(function () {
    VMasker($('#cpf')).maskPattern('999.999.999-99');
});

$('#form-cadastro').submit(function (e) {
    e.preventDefault();

    let dadosRegistro = {
        nome: $('#nome').val(),
        email: $('#email').val(),
        senha: $('#senha').val(),
        cpf: $('#cpf').val(),
    };

    if (
        !verificaNomeUsuario(dadosRegistro.nome) ||
        !verificaEmailUsuario(dadosRegistro.email)
    ) {
        return;
    }

    if (dadosRegistro.senha.length < 7) {
        $('#senha + div').html(
            '<div class="erro">Insira uma senha com, no mínimo, 7 caracteres.</div>'
        );
        return;
    } else {
        $('#senha + div').html('');
    }

    if (dadosRegistro.senha != $('#confirmar-senha').val()) {
        $('#confirmar-senha + div').html(
            "<div class='erro'>As senhas não coincidem!</div>"
        );
        return;
    } else {
        $('#confirmar-senha + div').html('');
    }

    $.ajax({
        type: 'POST',
        url: '../backend/processar_cadastro.php',
        data: dadosRegistro,
        success: function (response) {
            response = JSON.parse(response);

            switch (response.status) {
                case -1:
                    const errors = {
                        cpfEmUso: 'O cpf já está em uso!',
                        emailEmUso: 'O email já está em uso!',
                        emailInvalido: 'Email inválido!',
                    };

                    const exibirErros = $('.exibir-erro');
                    exibirErros.html('');

                    for (const errorKey in errors) {
                        if (response.hasOwnProperty(errorKey)) {
                            const errorMessage = errors[errorKey];

                            if (
                                errorKey == 'emailEmUso' ||
                                errorKey == 'emailInvalido'
                            ) {
                                exibirErros
                                    .eq(0)
                                    .html(
                                        `<div class='erro'>${errorMessage}</div>`
                                    );
                            } else {
                                exibirErros
                                    .eq(3)
                                    .html(
                                        `<div class='erro'>${errorMessage}</div>`
                                    );
                            }
                        }
                    }
                    break;
                case 0:
                    Swal.fire({
                        title: 'Erro Interno!',
                        text: response.swalMessage,
                        icon: 'error',
                    });
                    break;
                case 1:
                    let timerInterval;
                    Swal.fire({
                        title: 'Professor cadastrado!',
                        html: response.message,
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            const timer = Swal.getPopup().querySelector('b');
                            timerInterval = setInterval(() => {
                                timer.textContent = `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                            window.location.href = response.url;
                        },
                    });
                    break;
            }
            console.log(response);
        },
        error: (e) => console.log(e),
    });
});

function verificaNomeUsuario(nome) {
    const regexNome =
        /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]*[^\d\s][A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]*$/;

    if (!regexNome.test(nome)) {
        Swal.fire({
            icon: 'error',
            title: `Erro ao cadastrar o professor!`,
            text: `Não é possível cadastrar um professor com este nome. Verifique-o e tente novamente!`,
        });

        return false;
    }

    if (nome.length < 3) {
        Swal.fire({
            icon: 'error',
            title: `Erro ao cadastrar o professor!`,
            text: `O nome do professor é muito curto!`,
        });

        return false;
    }

    if (!nome.includes(' ')) {
        Swal.fire({
            icon: 'error',
            title: `Erro ao cadastrar o professor!`,
            text: `É necessário inserir, no mínimo, o nome e sobrenome do professor!`,
        });

        return false;
    }
    return true;
}

function verificaEmailUsuario(email) {
    const regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (!regexEmail.test(email)) {
        Swal.fire({
            icon: 'error',
            title: `Erro ao cadastrar o professor`,
            text: `Não é possível cadastrar um professor com este email. Verifique-o e tente novamente!`,
        });

        return false;
    }

    return true;
}
