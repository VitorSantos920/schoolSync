document.addEventListener('DOMContentLoaded', function () {
    const maxAttempts = 3;
    const lockoutTime = 30000; // 30 seconds lockout time for demonstration purposes

    function realizar_login() {
        let var_form = $('#form_login');
        var_form.submit((e) => {
            e.preventDefault();

            // Verifica se o usuário está bloqueado
            const lockout = localStorage.getItem('lockout');
            if (lockout && new Date().getTime() < lockout) {
                const remainingTime = (lockout - new Date().getTime()) / 1000;
                Swal.fire({
                    title: 'Você está bloqueado!',
                    html: `Tente novamente em ${Math.ceil(
                        remainingTime
                    )} segundos.`,
                    icon: 'error',
                    timer: 2000,
                    timerProgressBar: true,
                });
                return;
            } else if (lockout) {
                // Reseta o bloqueio se estourar o tempo
                localStorage.removeItem('lockout');
                localStorage.setItem('loginAttempts', 0);
            }

            let var_email = $('#email').val();
            let var_senha = $('#senha').val();

            $.ajax({
                type: 'POST',
                url: '../backend/loginback.php',
                data: {
                    email: var_email,
                    senha: var_senha,
                },
                success: function (response) {
                    response = JSON.parse(response);
                    console.log(response);
                    console.log(response.link);
                    console.log(response.categoria);
                    if (response.status == 1) {
                        // Reseta attempts no login com sucesso
                        localStorage.setItem('loginAttempts', 0);
                        let timerInterval;
                        Swal.fire({
                            title: 'Seja bem-vindo!',
                            html: 'Você será redirecionado em breve.',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                const timer =
                                    Swal.getPopup().querySelector('b');
                                timerInterval = setInterval(() => {
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);

                                switch (response.categoria) {
                                    case 'Aluno':
                                        window.location.href = response.link;
                                        break;
                                    case 'Professor':
                                        window.location.href = response.link;
                                        break;
                                    case 'Responsavel':
                                        window.location.href = response.link;
                                        break;
                                    case 'Administrador':
                                        window.location.href = response.link;
                                        break;
                                }
                            },
                        });
                    } else {
                        let attempts =
                            localStorage.getItem('loginAttempts') || 0;
                        attempts++;
                        localStorage.setItem('loginAttempts', attempts);
                        if (attempts >= maxAttempts) {
                            const lockoutExpires =
                                new Date().getTime() + lockoutTime;
                            localStorage.setItem('lockout', lockoutExpires);
                            Swal.fire({
                                title: 'Você está bloqueado!',
                                html: `Tente novamente em ${
                                    lockoutTime / 1000
                                } segundos.`,
                                icon: 'error',
                                timer: 2000,
                                timerProgressBar: true,
                            });
                        } else {
                            let timerInterval;
                            Swal.fire({
                                title: 'Credenciais incorretas!',
                                html: 'Email e/ou senha incorretos.',
                                icon: 'error',
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    const timer =
                                        Swal.getPopup().querySelector('b');
                                    timerInterval = setInterval(() => {
                                        timer.textContent = `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                },
                            });
                        }
                    }
                },
                error: function (erro) {
                    console.log(erro);
                },
            });
        });
    }

    // Função para lidar com o envio do formulário de recuperação de senha
    function handleFormSubmit(event) {
        event.preventDefault(); // Impede o envio padrão do formulário
        redirecionarParaLogin(); // Chama a função para enviar o email de recuperação
    }

    // Função da pág de esqueceu a senha para redirecionar para o login e mostrar mensagem de sucesso
    function redirecionarParaLogin() {
        $.ajax({
            type: 'POST',
            url: '../backend/send_reset_email.php',
            data: { email: $('#email').val() },
            success: function (response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    // Exibir modal de sucesso
                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Seu pedido foi enviado e em breve você receberá seu login temporário!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        window.location.href = 'index.php'; // Redirecionar para a tela de login
                    });
                } else if (response.status === 'invalid') {
                    // Exibir modal de e-mail inválido
                    Swal.fire({
                        title: 'Email Inválido!',
                        text: 'Por favor, insira um email válido.',
                        icon: 'warning',
                        confirmButtonText: 'OK',
                    });
                } else {
                    // Exibir modal de erro genérico
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Ocorreu um erro ao processar sua solicitação. Por favor, tente novamente mais tarde.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                }
            },
            error: function (erro) {
                // Exibir modal de erro genérico
                Swal.fire({
                    title: 'Erro!',
                    text: 'Ocorreu um erro ao processar sua solicitação. Por favor, tente novamente mais tarde.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
            },
        });
    }

    // Adiciona um ouvinte de evento ao formulário de recuperação de senha
    document.getElementById('formRecuperarSenha').addEventListener('submit', handleFormSubmit);

    realizar_login();

});
