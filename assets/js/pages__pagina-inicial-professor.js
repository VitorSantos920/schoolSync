function abrirModalDetalhes(
    id,
    titulo,
    descricao,
    url,
    escolaridade,
    tipoMaterial,
    criadoEm
) {
    $('#id-material').text(`#${id}`);
    $('#titulo-material').text(`${titulo}`);
    $('#descricao-material').text(`${descricao}`);
    $('#tipo-material').text(`${tipoMaterial}`);
    $('#escolaridade-material').text(`${escolaridade}`);
    $('#url-material').attr('href', url);
    $('#created-at').text(`Criado em: ${criadoEm}`);

    $('#modalMaterialApoio').modal('show');
}
