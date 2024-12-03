<?php
require_once "./init-configs.php";

if (!isset($_POST['liberado'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

$alunosClasse = DB::query(
  "SELECT
    al.id as aluno_id,
    us.nome as aluno_nome,
    us.status as aluno_status,
    us.cadastrado_em as aluno_data_criacao,
    resp_us.nome as responsavel_nome,
    resp_us.email as responsavel_email
  FROM aluno al
  INNER JOIN usuario us ON al.usuario_id = us.id
  INNER JOIN responsavel resp ON al.responsavel_id = resp.id
  INNER JOIN usuario resp_us ON resp.usuario_id = resp_us.id
  WHERE al.classe_id = %i AND us.status <> 0
  ORDER BY us.nome",
  $_POST['classeId']
);

$quantidadeAlunos = DB::count();
$tableBody = "";

if ($alunosClasse != null) {
  foreach ($alunosClasse as $aluno) {
    $dataCriacao = date('d/m/Y H:m:i', strtotime($aluno['aluno_data_criacao']));

    $tableBody .= "
    <tr class='tabelaCorpo'>
        <td data-label='Nome Completo'><a href='./pagina-inicial-aluno-professor.php?id_aluno=$aluno[aluno_id]'>$aluno[aluno_nome] </a></td>
        <td data-label='Responsável'>$aluno[responsavel_nome] </td>
        <td data-label='Email do Responsável'>$aluno[responsavel_email] </td>
        <td data-label='Data de Criação'>$dataCriacao</td>
        <td data-label='status'>" . ($aluno['aluno_status'] == 1 ? '<i class="fa-solid fa-circle" style="color: #128308;"></i>' : '<i class="fa-solid fa-circle" style="color: #e81324"></i>') . "</td>
        <td data-label='Ações'>
            <div class='dropdown'>
                <button class='btn btn-secondary dropdown-toggle' id='btnPrincipal' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                    Lista de Ações
                </button>
                    <ul class='dropdown-menu'>
                        <li>
                            <a href='./pagina-inicial-aluno-professor.php?id_aluno={$aluno['aluno_id']}' class='btn'>
                                <i class='fa-solid fa-user icone'></i>
                                Acessar Perfil
                            </a>
                        </li>
  
                        <!--<li>
                            <button class='btn'>
                                <i class='fa-solid fa-folder icone'></i>
                                Ver Detalhes
                            </button>
                        </li>-->
  
                        <li>
                            <button type='button' class='btn' data-bs-toggle='modal' data-bs-target='#edtAlunoModal' onclick='abrirModalEditarAluno({$aluno['aluno_id']})'>
                                <i class='fa-solid fa-pen icone'></i>
                                Editar Aluno</button>
                        </li>
  
                        <li>
                            <button class='btn' id='deletarAluno' onclick='deletarAluno({$aluno['aluno_id']})'>
                                <i class='fa-solid fa-trash icone'></i>
                                Deletar Aluno
                            </button>
                        </li>
                    </ul>
            </div>
        </td>
    </tr>
    ";
  }
} else {
  $tableBody = "
    <tr>
      <td colspan='6' class='text-center'>Não há alunos nesta turma!</td>
    </tr>
  ";
}

echo json_encode(["quantidadeAlunos" => $quantidadeAlunos, "tableBody" => $tableBody]);
