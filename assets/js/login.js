function realizar_login() {
    let var_form = $('#form_login');
    var_form.submit((e) => {
        e.preventDefault();
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
                    let timerInterval;
                    Swal.fire({
                        title: 'Seja bem-vindo!',
                        html: 'Você será redirecionado em breve.',
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
                    let timerInterval;
                    Swal.fire({
                        title: 'Credenciais incorretas!',
                        html: 'Email e/ou senha incorretos.',
                        icon: 'error',
                        timer: 1200,
                        timerProgressBar: true,
                        didOpen: () => {
                            const timer = Swal.getPopup().querySelector('b');
                            timerInterval = setInterval(() => {
                                timer.textContent = `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        },
                    });
                }
            },
            error: function (erro) {
                console.log(erro);
            },
        });
    });
}
