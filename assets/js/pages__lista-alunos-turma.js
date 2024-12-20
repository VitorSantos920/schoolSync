$(document).ready(function () {
  carregaTabelaListaAlunos();
  $(':is(#notas, #avaliacoes, #gerenciamento-aulas').hide();
});

let secaoAtual = 'lista-alunos';
function trocarSecao(secaoId, botaoId) {
  if (secaoId == secaoAtual) return;

  secaoAtual = secaoId;

  $(':is(#lista-alunos, #notas, #avaliacoes, #gerenciamento-aulas').hide(500);
  $('.btn-secoes button').removeClass('secao-atual');
  $(`#${botaoId}`).addClass('secao-atual');

  $(`#${secaoId}`).show();

  switch (secaoId) {
    case 'lista-alunos':
      carregaTabelaListaAlunos();
      break;
    case 'notas':
      carregarSecaoNotasAvaliacoes();
      break;
    case 'avaliacoes':
      carregarTabelaAvaliacoes();
      break;
    case 'gerenciamento-aulas':
      carregarSecaoGerenciamentoAulas();
      break;
  }
}

function abrirModalEditarAluno(idAluno) {
  $.ajax({
    type: 'POST',
    url: '../backend/lista-alunos_preencher-modal-editar-aluno.php',
    data: {
      idAluno,
    },
    success: function (response) {
      response = JSON.parse(response);

      $('#edtAlunoModal .modal-body').html(response.modalBody);
    },
    error: (err) => console.log(err),
  });

  $('#edtAlunoModal').modal('show');
}

function abrirModalAdicionarAvaliacao() {
  limparInputs([
    'representacao-avaliacao',
    '#titulo-avaliacao',
    '#descricao-avaliacao',
    '#materia-avaliacao',
    '#data-prevista',
  ]);

  $('#addAvaliacaoModal').modal('show');
}

function adicionarAvaliacao() {
  let dadosAvaliacao = {
    classe: $('#classe-id').val(),
    representacaoAvaliacao: $('#representacao-avaliacao').val(),
    tituloAvaliacao: $('#titulo-avaliacao').val(),
    descricaoAvaliacao: $('#descricao-avaliacao').val(),
    materiaAvaliacao: $('#materia-avaliacao').val(),
    dataPrevista: $('#data-prevista').val(),
  };

  if (verificaInputsVazios(dadosAvaliacao)) {
    Swal.fire({
      icon: 'error',
      title: 'Opa, algo deu errado!',
      text: 'Para realizar o cadastro de uma avaliação, é necessário o preenchimento de todos os campos.',
    });

    return;
  }

  $.ajax({
    type: 'POST',
    url: '../backend/adicionar-avaliacao.php',
    data: dadosAvaliacao,
    success: function (response) {
      response = JSON.parse(response);

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
            title: 'Avaliação cadastrada!',
            text: response.swalMessage,
          });

          trocarSecao('avaliacoes', 'botao-avaliacoes');
          carregarTabelaAvaliacoes();

          break;
      }
      $('#addAvaliacaoModal').modal('hide');
    },
    error: (err) => console.log(err),
  });
}

function confirmarRealizacao(classeId, avaliacaoId) {
  swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success swal2-styled',
      cancelButton: 'btn  btn-secondary',
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: 'Tem certeza que deseja confirmar a realização desta avaliação?',
      text: 'Esta ação é irreversivel e, ao confirmar, você poderá adicionar as notas dos alunos para esta avaliação.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, confirmar!',
      cancelButtonText: 'Não, cancelar!',
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '../backend/confirmar-realizacao-avaliacao.php',
          data: {
            classeId,
            avaliacaoId,
          },
          success: function (response) {
            response = JSON.parse(response);

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
                  title: 'Avaliação realizada!',
                  text: response.swalMessage,
                });

                carregarTabelaAvaliacoes();
                carregarSecaoNotasAvaliacoes();
                trocarSecao('notas', 'botao-notas');
                break;
            }
          },
          error: (err) => console.log(err),
        });
      }
    });
}

function carregarSecaoNotasAvaliacoes() {
  let classeId = $('#classe-id').val();

  $.ajax({
    type: 'POST',
    url: '../backend/carregar-secao-notas-avaliacoes.php',
    data: {
      classeId,
    },
    success: function (response) {
      response = JSON.parse(response);
      switch (response.status) {
        case -1:
          console.log(response);
          break;
        case 1:
          $('section#notas').html(response.botoes);

          document
            .querySelectorAll('.salvar-notas')
            .forEach((botaoSalvarNota) => {
              botaoSalvarNota.addEventListener('click', function () {
                const alunoId = this.getAttribute('data-aluno-id');
                const materiaId = this.getAttribute('data-materia-id');

                const linhaAluno = document.querySelector(
                  `tr[data-aluno-id="${alunoId}"][data-materia-id="${materiaId}"]`
                );

                const inputsNotas =
                  linhaAluno.querySelectorAll('.nota-avaliacao');

                const dadosNota = [];

                inputsNotas.forEach((inputNota) => {
                  const avaliacaoId = inputNota.dataset.avaliacaoId;
                  dadosNota.push({
                    alunoId: alunoId,
                    avaliacaoId,
                    nota: inputNota.value,
                  });
                });

                $.ajax({
                  type: 'POST',
                  url: '../backend/aluno/salvar-notas-avaliacao.php',
                  data: {
                    dadosNota: JSON.stringify(dadosNota),
                  },
                  success: function (response) {
                    response = JSON.parse(response);

                    switch (response.status) {
                      case -1:
                        Swal.fire({
                          icon: 'error',
                          title: 'Erro Interno',
                          text: response.swalMessage,
                        });
                        break;
                      case 1:
                        const Toast = Swal.mixin({
                          toast: true,
                          position: 'bottom-end',
                          showConfirmButton: false,
                          timer: 3000,
                          timerProgressBar: true,
                          didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                          },
                        });
                        Toast.fire({
                          icon: 'success',
                          title: 'Notas salvas!',
                          text: 'As notas do aluno foram salvas.',
                        });

                        break;
                    }
                  },
                  error: (err) => console.log(err),
                });
              });
            });
          break;
        case 0:
          $('#notas').html(`<p>${response.message}</p>`);
      }
    },
  });
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
      $('#tbody-lista-alunos').html(response.tableBody);

      $('#quantidade').text(`${response.quantidadeAlunos}`);
    },
  });
}

function carregarTabelaAvaliacoes() {
  let classeId = $('#classe-id').val();

  $.ajax({
    type: 'POST',
    url: '../backend/carregar-tabela-avaliacoes.php',
    data: {
      classeId,
      liberado: 1,
    },
    success: function (response) {
      response = JSON.parse(response);
      $('#tbody-avaliacoes-turma').html(response.tableBody);
    },
  });
}

function deletarAluno(idAluno) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-danger swal2-styled',
      cancelButton: 'btn  btn-secondary',
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons
    .fire({
      title: 'Tem certeza que deseja excluir este aluno?',
      text: 'Esta ação não pode ser desfeita!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, deletar!',
      cancelButtonText: 'Não, cancelar!',
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '../backend/deletar-aluno.php',
          data: {
            idAluno,
          },
          success: function (response) {
            response = JSON.parse(response);
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
    });
}

function fecharBimestreAtual() {
  let classeId = $('#classe-id').val();
  let bimestreAtual = parseInt($('#bimestre-atual').val());

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-danger',
      cancelButton: 'btn btn-secondary',
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons
    .fire({
      title: 'Tem certeza que deseja fechar o bimestre atual?',
      html: `Note que esta ação é irreversível e, ao realizá-la, a classe (turma) atual passará do <b>bimestre ${bimestreAtual}</b> para o <b>bimestre ${
        bimestreAtual + 1
      }</b>, fazendo com que as notas e faltas sejam adicionadas ao próximo bimestre!<br><br>Digite "Eu confirmo" no campo abaixo para confirmar a ação.`,
      input: 'text', // Adiciona um campo de texto
      inputPlaceholder: 'Você confirma?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, fechar!',
      cancelButtonText: 'Não, cancelar',
      reverseButtons: true,

      didOpen: () => {
        const confirmButton = Swal.getConfirmButton();
        confirmButton.disabled = true;

        Swal.getInput().addEventListener('input', function () {
          const typedValue = Swal.getInput().value;
          confirmButton.disabled = typedValue !== 'Eu confirmo'; // Habilita o botão se a frase for exata
        });
      },
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '../backend/fechar-bimestre-atual-classe.php',
          data: {
            classeId,
          },
          success: function (response) {
            response = JSON.parse(response);

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
                  title: 'Bimestre fechado!',
                  text: response.swalMessage,
                });
                setTimeout(() => {
                  window.location.reload();
                }, 2000);
                break;
            }
          },
          error: (e) => console.log(e),
        });
      }
    });
}

function abrirModalEditarTurma() {
  let idClasse = $('#classe-id').val();

  $.ajax({
    type: 'POST',
    url: '../backend/lista-alunos_preencher-modal-editar-turma.php',
    data: {
      idClasse,
    },
    success: function (response) {
      response = JSON.parse(response);

      $('#edtTurmaModal .modal-body').html(response.modalBody);
    },
    error: (err) => console.log(err),
  });

  $('#edtTurmaModal').modal('show');
}

function removerMateriaClasse(idClasse, idMateria) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-danger swal2-styled',
      cancelButton: 'btn  btn-secondary',
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons
    .fire({
      title: 'Remover esta matéria da turma?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, remover!',
      cancelButtonText: 'Não, cancelar!',
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '../backend/editar-classe.php',
          data: {
            idClasse,
            idMateria,
            acao: 'removerMateria',
          },
          success: function (response) {
            response = JSON.parse(response);
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
                  title: 'Matéria removida!',
                  text: response.swalMessage,
                });
                break;
            }

            abrirModalEditarTurma();
          },
          error: (e) => console.log(e),
        });
      }
    });
}

function adicionarMateriaClasse(idClasse, idMateria) {
  const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    },
  });

  $.ajax({
    type: 'POST',
    url: '../backend/editar-classe.php',
    data: {
      idClasse,
      idMateria,
      acao: 'adicionarMateria',
    },
    success: function (response) {
      response = JSON.parse(response);

      switch (response.status) {
        case -1:
          Swal.fire({
            icon: 'error',
            title: 'Erro Interno!',
            text: response.swalMessage,
          });
          break;
        case 1:
          Toast.fire({
            icon: 'success',
            title: 'Matéria adicionada!',
            text: response.swalMessage,
          });
          break;
      }

      abrirModalEditarTurma();
    },
    error: (e) => console.log(e),
  });
}

function editarTurma() {
  let nomeTurma = $('#novo-nome-turma').val();
  let escolaridadeTurma = $('#nova-escolaridade-turma').val();
  let idClasse = $('#id-classe').val();

  if (nomeTurma == '' || escolaridadeTurma == '') {
    Swal.fire({
      icon: 'error',
      title: 'Opa, algo deu errado!',
      text: 'Não foi possível realizar a edição da turma, pois o campo "Nome da Turma" e/ou "Escolaridade da Turma" está(ão) vazio(s).',
    });

    return;
  }

  $.ajax({
    type: 'POST',
    url: '../backend/editar-classe.php',
    data: {
      idClasse,
      acao: 'editarTurma',
      nomeTurma,
      escolaridadeTurma,
    },
    success: function (response) {
      response = JSON.parse(response);
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
            title: 'Classe editada!',
            text: response.swalMessage,
          });

          setTimeout(() => {
            window.location.reload();
          }, 2000);
          break;
      }
    },
    error: (e) => console.log(e),
  });
}

function abrirModalEditarAvaliacao(idAvaliacao) {
  $.ajax({
    type: 'POST',
    url: '../backend/preencher-modal-editar-avaliacao.php',
    data: {
      idAvaliacao,
    },
    success: function (response) {
      response = JSON.parse(response);

      switch (response.status) {
        case 1:
          $('#modalEditarAvaliacao').modal('show');
          $('#modalEditarAvaliacao .modal-body').html(response.modalBody);
          break;

        case -1:
          console.log(response);
          break;
      }
    },
    error: (err) => console.log(err),
  });
}

function editarAvaliacao() {
  let dadosAvaliacao = {
    idAvaliacao: $('#id-avaliacao').val(),
    representacaoAvaliacao: $('#ipt-edit-representacao-avaliacao').val(),
    tituloAvaliacao: $('#ipt-edit-nome-avaliacao').val(),
    descricaoAvaliacao: $('#ipt-edit-descricao-avaliacao').val(),
    materiaAvaliacao: $('#slct-edit-materia-avaliacao').val(),
    dataPrevista: $('#ipt-edit-data-prevista-avaliacao').val(),
  };

  if (verificaInputsVazios(dadosAvaliacao)) {
    Swal.fire({
      icon: 'error',
      title: 'Opa, algo deu errado!',
      text: 'Para realizar a edição de uma avaliação, é necessário o preenchimento de todos os campos.',
    });

    return;
  }

  $.ajax({
    type: 'POST',
    url: '../backend/editar-avaliacao.php',
    data: dadosAvaliacao,
    success: function (response) {
      response = JSON.parse(response);

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
            title: 'Avaliação editada!',
            text: response.swalMessage,
          });

          carregarTabelaAvaliacoes();
          break;
      }

      $('#modalEditarAvaliacao').modal('hide');
    },
    error: (err) => console.log(err),
  });
}

function excluirAvaliacao(idAvaliacao) {
  console.log(idAvaliacao);
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-danger swal2-styled',
      cancelButton: 'btn  btn-secondary',
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons
    .fire({
      title: 'Tem certeza que deseja excluir esta avaliação?',
      text: 'Esta ação não pode ser desfeita!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, deletar!',
      cancelButtonText: 'Não, cancelar!',
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '../backend/excluir-avaliacao.php',
          data: {
            idAvaliacao,
          },
          success: function (response) {
            response = JSON.parse(response);
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
                  title: 'Avaliação excluída!',
                  text: response.swalMessage,
                });
                carregarTabelaAvaliacoes();
                break;
            }
          },
          error: (e) => console.log(e),
        });
      }
    });
}

function carregarSecaoGerenciamentoAulas() {
  // let classeId = $('#classe-id').val();
  // $.ajax({
  //   type: 'POST',
  //   url: '../backend/carregar-secao-gerenciamento-aulas.php',
  //   data: {
  //     classeId,
  //   },
  //   success: function (response) {
  //     response = JSON.parse(response);
  //     switch (response.status) {
  //       case -1:
  //         console.log(response);
  //         break;
  //       case 1:
  //         $('section#gerenciamento-aulas').html(response.botoes);
  //         break;
  //       case 0:
  //         $('#gerenciamento-aulas').html(`<p>${response.message}</p>`);
  //     }
  //   },
  // });
}

function registrarPresenca() {
  let dadosFaltas = [];
  let dadosRegistrarPresenca = {
    disciplina: $('#gerenciamento-aula-disciplina').val(),
    dataFalta: $('#gerenciamento-aula-data').val(),
  };

  if (verificaInputsVazios(dadosRegistrarPresenca)) {
    Swal.fire({
      icon: 'error',
      title: 'Opa, algo deu errado!',
      text: 'Para realizar o registro de presença, é necessário fornecer a disciplina e a data.',
    });

    return;
  }

  $('.linha-aluno').each((index, linha) => {
    const alunoId = $(linha).data('aluno-id');
    const presente = $(linha).find('.presenca-aluno').is(':checked');
    const motivo = $(linha).find('.ipt-motivo').val();

    if (!presente) {
      dadosFaltas.push({
        alunoId,
        materiaId: dadosRegistrarPresenca.disciplina,
        dataFalta: dadosRegistrarPresenca.dataFalta,
        motivo,
      });
    }
  });

  $.ajax({
    type: 'POST',
    url: '../backend/aluno/salvar-faltas-aula.php',
    data: {
      faltas: JSON.stringify(dadosFaltas),
    },
    success: function (response) {
      response = JSON.parse(response);

      switch (response.status) {
        case 1:
          Swal.fire({
            icon: 'success',
            title: 'Faltas registradas!',
            text: response.swalMessage,
          });
          break;
        case -1:
          Swal.fire({
            icon: 'error',
            title: 'Erro Interno!',
            text: response.swalMessage,
          });
          break;
      }
    },
    error: (error) => console.log(error),
  });
}
