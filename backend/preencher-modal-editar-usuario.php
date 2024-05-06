<?php
require_once "../db/config.php";


if (!isset($_POST['idUsuario'])) {
  header('Location: ../pages/permissao.php');
  exit;
}

$idUsuario = $_POST['idUsuario'];

$dadosUsuario = DB::queryFirstRow("SELECT *, us.id as 'tblUsuario_id' FROM usuario us WHERE us.id = %i", $idUsuario);

$dadosCompletos = retornaDadosCompletosPorCategoria($dadosUsuario);

function retornaDadosCompletosPorCategoria($dadosUsuario)
{
  $categoria = $dadosUsuario['categoria'];
  $idUsuario = $dadosUsuario['tblUsuario_id'];

  switch ($categoria) {
    case 'Aluno':
      $dadosAluno = DB::queryFirstRow("SELECT data_nascimento, escola, escolaridade, genero FROM aluno al WHERE al.usuario_id = %i", $idUsuario);
      return array_merge($dadosUsuario, $dadosAluno);

      break;

    case 'Professor':
      $dadosProfessor = DB::queryFirstRow("SELECT pro.cpf FROM professor pro WHERE pro.usuario_id = %i", $idUsuario);
      return array_merge($dadosUsuario, $dadosProfessor);

      break;

    case 'Administrador':
      $dadosAdministrador = DB::queryFirstRow("SELECT adm.cargo FROM administrador adm WHERE adm.usuario_id = %i", $idUsuario);
      return array_merge($dadosUsuario, $dadosAdministrador);

      break;

    case 'Responsavel':
      $dadosResponsavel = DB::queryFirstRow("SELECT res.cpf, res.telefone, res.quantidade_filho FROM responsavel res WHERE res.usuario_id = %i", $idUsuario);
      return array_merge($dadosUsuario, $dadosResponsavel);

      break;

    default:
      echo json_encode(["status" => -1, "message" => "Categoria Inválida"]);
      break;
  }
}

montaEstruturaFormulario($dadosCompletos);

function montaEstruturaFormulario($dadosCompletos)
{

  $html = "<form method='POST'>
    <input type='number' id='id-usuario' class='form-control' disabled value='{$dadosCompletos['tblUsuario_id']}' required>
    <fieldset>
      <label for='ipt-nome' class='form-label'>Nome do {$dadosCompletos['categoria']}</label>
      <input type='text' name='ipt-nome' id='ipt-nome' class='form-control' value='{$dadosCompletos['nome']}' required>
    </fieldset>
    <fieldset>
      <label for='ipt-email' class='form-label'>Email do {$dadosCompletos['categoria']}</label>
      <input type='text' name='ipt-email' id='ipt-email' class='form-control' value='{$dadosCompletos['email']}' required>
    </fieldset>
  ";

  switch ($dadosCompletos['categoria']) {
    case 'Aluno':
      $html .= "
      <fieldset>
        <label for='ipt-escola-aluno' class='form-label'>Escola do Aluno</label>
        <input type='text' name='ipt-escola-aluno' id='ipt-escola-aluno' class='form-control' value='{$dadosCompletos['escola']}' required>
      </fieldset>
      <fieldset>
        <label for='ipt-dataNascimento-aluno' class='form-label'>Data de Nascimento</label>
        <input type='date' name='ipt-dataNascimento-aluno' id='ipt-dataNascimento-aluno' class='form-control' value='{$dadosCompletos['data_nascimento']}' required>
      </fieldset>
      <fieldset>
        <label for='select-categoria' class='form-label'>Categoria do Usuário</label>
        <select class='form-control form-select' name='select-categoria' id='select-categoria' required>
          <option value='0' selected disabled>Categoria</option>
          <option value='Aluno' selected>Aluno</option>
          <option value='Responsavel'>Responsável</option>
          <option value='Administrador'>Administrador</option>
          <option value='Professor'>Professor</option>
        </select>
      </fieldset>
      <fieldset>
        <label for='select-genero-aluno' class='form-label'>Gênero do Aluno</label>
        <select class='form-control form-select' name='select-genero-aluno' id='select-genero-aluno' required>
          <option value='0' selected disabled>Gênero</option>
          <option value='Masculino' selected>Masculino</option>
          <option value='Feminino'>Feminino</option>
        </select>
      </fieldset>
      <fieldset>
        <label for='select-escolaridade' class='form-label'>Escolaridade do Aluno</label>
        <select class='form-control form-select' name='select-escolaridade' id='select-escolaridade' required> 
          <option value='-1' selected disabled>Escolaridade</option>
          <option value='1'>1</option>
          <option value='2'>2</option>
          <option value='3'>3</option>
          <option value='4'>4</option>
          <option value='5'>5</option>
        </select>
      </fieldset>
    ";

      break;


    case 'Professor':
      $html .= "
      <fieldset>
        <label for='select-categoria' class='form-label'>Categoria do Usuário</label>
        <select class='form-control form-select' name='select-categoria' id='select-categoria' required>
          <option value='0' disabled>Categoria</option>
          <option value='Aluno'>Aluno</option>
          <option value='Responsavel'>Responsável</option>
          <option value='Administrador'>Administrador</option>
          <option value='Professor' selected>Professor</option>
        </select>
      </fieldset>
      <fieldset>
        <label for='ipt-cpf' class='form-label'>CPF do Professor</label>
        <input type='text' id='cpf-professor' class='form-control' value='{$dadosCompletos['cpf']}' required>
      </fieldset>
    ";

      break;

    case 'Administrador':
      $html .= "
      <fieldset>
        <label for='ipt-cargo-adm' class='form-label'>Cargo do Administrador</label>
        <input type='text' name='ipt-cargo-adm' id='ipt-cargo-adm' class='form-control' value='{$dadosCompletos['cargo']}' required>
      </fieldset>

      <fieldset>
        <label for='select-categoria' class='form-label'>Categoria do Usuário</label>
        <select class='form-control form-select' name='select-categoria' id='select-categoria' required>
          <option value='0' disabled>Categoria</option>
          <option value='Aluno'>Aluno</option>
          <option value='Responsavel'>Responsável</option>
          <option value='Administrador' selected>Administrador</option>
          <option value='Professor'>Professor</option>
        </select>
      </fieldset>";

      break;

    case 'Responsavel':
      $html .= "
      <fieldset>
        <label for='ipt-cpf-responsavel' class='form-label'>CPF do Responsável</label>
        <input type='text' name='ipt-cpf-responsavel' id='ipt-cpf-responsavel' class='form-control' value='{$dadosCompletos['cpf']}' required>
      </fieldset>

      <fieldset>
        <label for='ipt-telefone-responsavel' class='form-label'>Telefone do Responsável</label>
        <input type='number' id='ipt-telefone-responsavel' name='ipt-telefone-responsavel' class='form-control' value='{$dadosCompletos['telefone']}' required>
      </fieldset>

      <fieldset>
        <label for='select-categoria' class='form-label'>Categoria do Usuário</label>
        <select class='form-control form-select' name='select-categoria' id='select-categoria' required>
          <option value='0' disabled>Categoria</option>
          <option value='Aluno' >Aluno</option>
          <option value='Responsavel' selected>Responsável</option>
          <option value='Administrador'>Administrador</option>
          <option value='Professor'>Professor</option>
        </select>
      </fieldset>
    ";
      break;

    default:
      echo json_encode(["status" => -1, "message" => "Categoria Inválida"]);
      break;
  }

  $html .= "</form>";
  $retorno = ["dadosCompletos" => $dadosCompletos, "html" => $html];
  echo json_encode($retorno);
}
