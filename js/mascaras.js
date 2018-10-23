$(document).ready(function () {
    // Preços
    $('#preco_custo').mask("#.##0,00", {reverse: true});
    $('#preco_venda').mask('000.000.000.000.000,00', {reverse: true});
    $('#altprod_preco_custo').mask("#.##0,00", {reverse: true});
    $('#altprod_preco_venda').mask('000.000.000.000.000,00', {reverse: true});

    // CEP
    $('#cep').mask('00000-000');

    // Telefone
    var maskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        options = {
            onKeyPress: function (val, e, field, options) {
                field.mask(maskBehavior.apply({}, arguments), options);
            }
        };
    $('#telefone').mask(maskBehavior, options);

    // CPF
    $('#cpf').mask('000.000.000-00', {reverse: true});

    // Data
    // $('#data_nascimento').mask('00/00/0000');

    // Número de endereço
    $('#numero').mask('000.000', {reverse: true});
});