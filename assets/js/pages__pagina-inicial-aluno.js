let idAluno = $('#id-aluno').val();

$(document).ready(function () {
  carregarGraficoNotasDisciplina();
  carregarGraficoFaltasDisciplina();
});

function carregarGraficoNotasDisciplina() {
  $.ajax({
    type: 'POST',
    url: '../backend/aluno/retorna-dados-notas-disciplina.php',
    data: {
      idAluno,
    },
    success: function (response) {
      response = JSON.parse(response);

      let bimestres = new Array(Object.keys(response).length);
      let labelsMaterias = [];

      Object.keys(response).forEach((bimestre, index) => {
        bimestres[index] = response[bimestre];
      });

      bimestres.forEach((bimestre) => {
        for (const key in bimestre) {
          if (!labelsMaterias.includes(bimestre[key].nome_materia)) {
            labelsMaterias.push(bimestre[key].nome_materia);
          }
        }
      });

      const data = {
        labels: labelsMaterias,
        datasets: retornaDatasets(bimestres),
      };

      const config = {
        type: 'bar',
        data: data,
        options: {
          scales: {
            y: {
              beginAtZero: true,
              min: 0,
              ticks: {
                stepSize: 2,
              },
              max: 10,
              grid: {
                display: false,
              },
            },
            x: {
              grid: {
                display: false,
              },
            },
          },
          plugins: {
            legend: {
              position: 'bottom',
              align: 'start',
              labels: {
                boxHeight: 10,
                boxWidth: 10,
                usePointStyle: true,
                padding: 20,
              },
            },
          },
        },
      };

      let myChart = new Chart(
        document
          .getElementById('grafico-medias-notas-disciplina')
          .getContext('2d'),
        config
      );
    },
    error: function (error) {
      console.log(error);
    },
  });
}

function retornaDatasets(bimestres) {
  const coresBimestres = ['#4A90E2', '#50E3C2', '#F8E71C', '#D0021B'];
  let datasets = [];

  bimestres.forEach((bimestre, index) => {
    let medias = [];

    for (const key in bimestre) {
      medias.push(bimestre[key].media);
    }

    datasets.push({
      label: `${index + 1}° Bimestre`,
      backgroundColor: coresBimestres[index],
      data: medias,
    });
  });

  return datasets;
}

function carregarGraficoFaltasDisciplina() {
  $.ajax({
    type: 'POST',
    url: '../backend/aluno/retorna-dados-faltas-disciplina.php',
    data: {
      idAluno,
    },
    success: function (response) {
      response = JSON.parse(response);
      console.log(response);
      var ctx = document
        .getElementById('grafico-medias-faltas-disciplina')
        .getContext('2d');

      const coresVivas = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 205, 86, 1)',
        'rgba(231, 76, 60, 1)',
        'rgba(46, 204, 113, 1)',
        'rgba(52, 152, 219, 1)',
        'rgba(241, 196, 15, 1)',
      ];

      var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: response.bimestres,
          datasets: Object.keys(response.faltasPorMateria).map(function (
            materia,
            index
          ) {
            return {
              label: materia,
              data: response.faltasPorMateria[materia],
              borderColor: coresVivas[index % coresVivas.length],
              backgroundColor: coresVivas[index % coresVivas.length],
              fill: false,
              tension: 0.1,
            };
          }),
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom',
              align: 'start',
              labels: {
                boxHeight: 10,
                boxWidth: 10,
                usePointStyle: true,
                padding: 20,
              },
            },
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 2,
              },
              grid: {
                display: false,
              },
            },
            x: {
              grid: {
                display: false,
              },
            },
          },
        },
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
}

function abrirModalDetalhesAvaliacao(idAvaliacao) {
  $.ajax({
    type: 'POST',
    url: '../backend/preencher-modal-detalhes-avaliacao.php',
    data: {
      idAvaliacao,
    },
    success: function (response) {
      response = JSON.parse(response);

      switch (response.status) {
        case 1:
          console.log(response);
          $('#modalDetalhesAvaliacao').modal('show');
          $('#modalDetalhesAvaliacao .modal-body').html(response.modalBody);
          $('#modalDetalhesAvaliacao #nome-avaliacao').text(
            `${response.nomeAvaliacao} (${response.representacaoAvaliacao})`
          );
          break;

        case -1:
          console.log(response);
          break;
      }
    },
    error: function (error) {
      console.log(error);
    },
  });
}
