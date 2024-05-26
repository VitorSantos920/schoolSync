$('#form-cadastro').submit(function (e) {
    e.preventDefault();

    let dadosRegistro = {
        nome: $('#nome').val(),
        email: $('#email').val(),
        senha: $('#senha').val(),
        cpf: $('#cpf').val(),
    };

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
                                    .eq(1)
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
