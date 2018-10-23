// Fornecedor
function valida_fornecedor() {
    if (document.getElementById('telefone').value.length < 14) {
        swal("Atenção!", "Informe um telefone válido.", "warning");
        document.getElementById('telefone').focus();
        return false;
    }
    if (document.getElementById('cep').value.length < 9) {
        swal("Atenção!", "Informe um CEP válido.", "warning");
        document.getElementById('cep').focus();
        return false;
    }
    return true;
}

// Produto
function valida_produto() {
    ext = (document.getElementById('arquivo_upload').value).split('.').pop();
    if (ext !== "png" && ext !== "PNG") {
        swal("Atenção!", "Selecione uma imagem em formato PNG.", "warning");
        document.getElementById('arquivo_upload').focus();
        return false;
    }
    return true;
}

// Cliente
function valida_cliente() {

    // Data de nascimento
    var strData = document.getElementById('data_nascimento').value;
    var partesData = strData.split("-");
    var data = new Date(partesData[0], partesData[1] - 1, partesData[2]);

    var hoje = new Date();
    var dia = hoje.getDate()-1;
    var mes = hoje.getMonth();
    var ano = hoje.getFullYear();
    var dia_atual = new Date(ano, mes, dia);

    if(data > dia_atual){
        swal("Atenção!", "Informe uma data válida.", "warning");
        document.getElementById('data_nascimento').focus();
        return false;
    }

    // CPF
    var cpf = document.getElementById('cpf').value;
    var cpf = cpf.replace(/[^\d]/g, "");

    //Testando quantidade de caracteres e sequencias unicas
    if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" ||
        cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" ||
        cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" ||
        cpf == "88888888888" || cpf == "99999999999") {
        swal("Atenção!", "Informe um CPF válido.", "warning");
        document.getElementById('cpf').focus();
        return false;
    }

    //Calculo validar CPF
    soma = 0;
    for (i = 0; i < 10; i++)
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    resto = 11 - (soma % 11);
    if (resto == 10 || resto == 11)
        resto = 0;
    if (resto != parseInt(cpf.charAt(10))) {
        swal("Atenção!", "Informe um CPF válido.", "warning");
        document.getElementById('cpf').focus();
        return false;
    }

    // Telefone
    if (document.getElementById('telefone').value.length < 14) {
        swal("Atenção!", "Informe um telefone válido.", "warning");
        document.getElementById('telefone').focus();
        return false;
    }

    // CEP
    if (document.getElementById('cep').value.length < 9) {
        swal("Atenção!", "Informe um CEP válido.", "warning");
        document.getElementById('cep').focus();
        return false;
    }
    return true;
}

// Entrada de mercadorias
function valida_estoque() {

    // Quantidade de entrada
    if (document.getElementById('qtde').value < 1) {
        swal("Atenção!", "Informe uma quantidade válida.", "warning");
        document.getElementById('qtde').focus();
        return false;
    }
    return true;
}

function valida_pesquisa_cliente() {

    // Quantidade de entrada
    if (document.getElementById('nome').value == "" && document.getElementById('email').value == "") {
        swal("Ops!", "Informe algum dado para realizar a pesquisa.", "warning");
        document.getElementById('nome').focus();
        return false;
    }
    return true;
}