function verificarNomeUsuario(nome, categoria) {
  const regexNome =
    /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]*[^\d\s][A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]*$/;

  if (!regexNome.test(nome)) {
    Swal.fire({
      icon: 'error',
      title: `Erro ao cadastrar o ${categoria}!`,
      text: `Não é possível cadastrar um ${categoria} com este nome. Verifique-o e tente novamente!`,
    });

    return false;
  }

  if (nome.length < 3) {
    Swal.fire({
      icon: 'error',
      title: `Erro ao cadastrar o ${categoria}!`,
      text: `O nome do ${categoria} é muito curto!`,
    });

    return false;
  }

  if (!nome.includes(' ')) {
    Swal.fire({
      icon: 'error',
      title: `Erro ao cadastrar o ${categoria}!`,
      text: `É necessário inserir, no mínimo, o nome e sobrenome do ${categoria}!`,
    });

    return false;
  }
  return true;
}

function verificarEmailUsuario(email, categoria) {
  const regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

  if (!regexEmail.test(email)) {
    Swal.fire({
      icon: 'error',
      title: `Erro ao cadastrar o ${categoria}`,
      text: `Não é possível cadastrar um ${categoria} com este email. Verifique-o e tente novamente!`,
    });

    return false;
  }

  return true;
}
