<?php
require_once "../db/config.php";

date_default_timezone_set("America/Sao_Paulo");

if (!isset($_POST['liberado'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

$alunosClasse = DB::query("SELECT *, al.id as 'aluno_id' FROM aluno al INNER JOIN usuario us ON al.usuario_id = us.id WHERE classe_id = %i AND al.status_aluno <> 0 ORDER BY us.nome", $_POST['classeId']);

$quantidadeAlunos = DB::count();

if ($alunosClasse != null) {
  foreach ($alunosClasse as $aluno) {
    $user = DB::queryFirstRow('SELECT * FROM usuario WHERE id=%i', $aluno['usuario_id']);
    $responsavel = DB::queryFirstField('SELECT usuario_id FROM responsavel WHERE id=%i', $aluno['responsavel_id']);
    $user_responsavel = DB::queryFirstRow('SELECT nome, email FROM usuario WHERE id=%i', $responsavel);

    $dataCriacao = date('d/m/Y H:m:i', strtotime($user['created_at']));

    $tableBody .= "
    <tr class='tabelaCorpo'>
        <td data-label='Nome Completo'><a id='nome_aluno_lista' href='./painelAlunoProfessor.php?aluno_id=$aluno[aluno_id]'>$user[nome] </a></td>
        <td data-label='Responsável'>$user_responsavel[nome] </td>
        <td data-label='Email do Responsável'>$user_responsavel[email] </td>
        <td data-label='Data de Criação'>$dataCriacao</td>
        <td data-label='status'>" . ($aluno['status_aluno'] == 1 ? '<i class="fa-solid fa-circle" style="color: #128308;"></i>' : '<i class="fa-solid fa-circle" style="color: #e81324"></i>') . "</td>
        <td data-label='Ações'>
            <div class='dropdown'>
                <button class='btn btn-secondary dropdown-toggle' id='btnPrincipal' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                    Lista de Ações
                </button>
                    <ul class='dropdown-menu'>
                        <li>
                            <a href='./painelAlunoProfessor.php?id_aluno={$aluno['aluno_id']}' class='btn'>
                                <i class='fa-solid fa-user icone'></i>
                                Acessar Perfil
                            </a>
                        </li>
  
                        <li>
                            <button class='btn'>
                                <i class='fa-solid fa-folder icone'></i>
                                Ver Detalhes
                            </button>
                        </li>
  
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
