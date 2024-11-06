$(document).ready(function () {
  VMasker($('#cpf-professor')).maskPattern('999.999.999-99');

  let inputSenha = $('#senha-professor');
  inputSenha.on('input', function () {
    let valorSenha = inputSenha.val();

    verificaSenha(valorSenha);
  });
});

$('#form').submit(function (e) {
  e.preventDefault();

  let dadosRegistro = {
    nome: $('#nome-professor').val(),
    email: $('#email-professor').val(),
    senha: $('#senha-professor').val(),
    cpf: $('#cpf-professor').val(),
  };

  if (
    !verificaNomeUsuario(dadosRegistro.nome) ||
    !verificaEmailUsuario(dadosRegistro.email) ||
    !verificaSenha(dadosRegistro.senha)
  ) {
    return;
  }

  if (dadosRegistro.senha.length < 7) {
    $('#senha-professor + div + div').html(
      '<div class="erro">Insira uma senha com, no mínimo, 7 caracteres.</div>'
    );
    return;
  } else {
    $('#senha-professor + div + div').html('');
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
    url: '../backend/processar-cadastro.php',
    data: dadosRegistro,
    success: function (response) {
      response = JSON.parse(response);

      console.log(response);

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

              if (errorKey == 'emailEmUso' || errorKey == 'emailInvalido') {
                exibirErros
                  .eq(0)
                  .html(`<div class='erro'>${errorMessage}</div>`);
              } else {
                exibirErros
                  .eq(3)
                  .html(`<div class='erro'>${errorMessage}</div>`);
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
    },
    error: (e) => console.log(e),
  });
});

function verificaNomeUsuario(nome) {
  const regexNome =
    /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]*[^\d\s][A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]*$/;

  nome = nome.trim();

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

function verificaSenha(valorSenha) {
  let requisitosVerificados = {
    numero: false,
    especial: false,
    maiuscula: false,
  };

  if (/\d/.test(valorSenha)) {
    $('#has-number').removeClass('invalid').addClass('valid');
    requisitosVerificados.numero = true;
  } else {
    $('#has-number').removeClass('valid').addClass('invalid');
    requisitosVerificados.numero = false;
  }

  // Verificar caractere especial
  if (/[!@#$%^&*(),.?":{}|<>]/.test(valorSenha)) {
    requisitosVerificados.especial = true;
    $('#has-special').removeClass('invalid').addClass('valid');
  } else {
    requisitosVerificados.especial = false;
    $('#has-special').removeClass('valid').addClass('invalid');
  }

  // Verificar letra maiúscula
  if (/[A-Z]/.test(valorSenha)) {
    requisitosVerificados.maiuscula = true;
    $('#has-uppercase').removeClass('invalid').addClass('valid');
  } else {
    requisitosVerificados.maiuscula = false;
    $('#has-uppercase').removeClass('valid').addClass('invalid');
  }

  for (const key of Object.keys(requisitosVerificados)) {
    if (!requisitosVerificados[key]) {
      $('#senha-professor + div + div').html(
        "<div class='erro'>A senha não cumpre os requisitos!</div>"
      );
      return false;
    } else {
      $('#senha-professor + div + div').html('');
    }
  }

  return true;
}
