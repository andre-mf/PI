<?php
include_once('../cabecalho.php');

$cliente = new Cliente();

$sql = new Sql();

if (isset($_GET['cod_cliente'])) {

    $cliente->loadByCod($_GET['cod_cliente']);

}
?>
<div class="container">
    <h4 class="p-3"><?= (isset($_GET['cod_cliente'])) ? 'Alterar cadastro de clientes' : 'Cadastrar clientes' ?></h4>
    <hr>
    <form method="post" action="processamento.php?acao=salvar" onsubmit="return valida_cliente();">

        <input type="hidden" name="cod_cliente" value="<?= $cliente->getCodCliente() ?>">
        <input type='hidden' name='status' value='1'>
        <input type='hidden' name='data_cadastro' value="<?= $cliente->getDataCadastro() ?>">

        <div class="form-group row">
            <label for="nome" class="col-4 col-form-label">Nome</label>
            <div class="col-8">
                <input class="form-control" type="text" name="nome" autocomplete="off" id="nome"
                       value="<?= htmlentities($cliente->getNome(), ENT_QUOTES) ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="data_nascimento" class="col-4 col-form-label">Data de nascimento</label>
            <div class="col-8">
                <input class="form-control" type="date" name="data_nascimento" id="data_nascimento"
                       value="<?= htmlentities($cliente->getDataNascimento(),ENT_QUOTES) ?>" required autocomplete="off">
            </div>
        </div>

        <div class="form-group row">
            <label for="sexo" class="col-4 col-form-label">Sexo</label>
            <div class="col-8">
                <input type="radio" name="sexo" value="F" <?= ($cliente->getSexo() == 'F') ? 'checked' : '' ?>> Feminino<br>
                <input type="radio" name="sexo" value="M" <?= ($cliente->getSexo() == 'M') ? 'checked' : '' ?>>
                Masculino
            </div>
        </div>

        <div class="form-group row">
            <label for="cpf" class="col-4 col-form-label">CPF</label>
            <div class="col-8">
                <input class="form-control" type="text" name="cpf" id="cpf" autocomplete="off"
                       value="<?= $cliente->getCpf() ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-4 col-form-label">Email</label>
            <div class="col-8">
                <input class="form-control" type="email" name="email" id="email" autocomplete="off"
                       value="<?= $cliente->getEmail() ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="telefone" class="col-4 col-form-label">Telefone</label>
            <div class="col-8">
                <input class="form-control phone-ddd-mask" type="text" name="telefone" autocomplete="off" id="telefone"
                       value="<?= $cliente->getTelefone() ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="cep" class="col-4 col-form-label">CEP</label>
            <div class="col-8">
                <input class="form-control" type="text" name="cep" id="cep" autocomplete="off"
                       value="<?= $cliente->getCep() ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="logradouro" class="col-4 col-form-label">Endereço</label>
            <div class="col-8">
                <input class="form-control" type="text" name="logradouro" id="logradouro" autocomplete="off"
                       value="<?= htmlentities($cliente->getLogradouro(),ENT_QUOTES) ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="numero" class="col-4 col-form-label">Número</label>
            <div class="col-8">
                <input class="form-control" type="text" name="numero" id="numero" autocomplete="off"
                       value="<?= $cliente->getNumero() ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="bairro" class="col-4 col-form-label">Bairro</label>
            <div class="col-8">
                <input class="form-control fundo_branco_formulario_disable" type="text" name="bairro" id="bairro"
                       autocomplete="off" value="<?= htmlentities($cliente->getBairro(),ENT_QUOTES) ?>" required readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="localidade" class="col-4 col-form-label">Cidade</label>
            <div class="col-8">
                <input class="form-control fundo_branco_formulario_disable" type="text" name="localidade"
                       id="localidade" autocomplete="off" value="<?= htmlentities($cliente->getLocalidade(),ENT_QUOTES) ?>" required readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="uf" class="col-4 col-form-label">Estado</label>
            <div class="col-8">
                <input class="form-control fundo_branco_formulario_disable" type="text" name="uf" id="uf"
                       autocomplete="off" value="<?= $cliente->getUf() ?>" required readonly>
            </div>
        </div>

        <div class="btn-toolbar">
            <div class="btn-group">
                <button type="submit" class="btn <?= (isset($_GET['cod_cliente']) ? 'btn-primary' : 'btn-success') ?>">
                    <span class="fa fa-edit"></span> <?= (isset($_GET['cod_cliente']) ? 'Alterar' : 'Cadastrar') ?>
                </button>
                <?php if (isset($_GET['cod_cliente'])) { ?>
                    <a class="btn btn-danger"
                       href="processamento.php?acao=excluir&cod_cliente=<?= $_GET['cod_cliente'] ?>"
                       onclick="return confirm('Deseja realmente excluir o cliente <?= $cliente->getCodCliente() . ' - ' . $cliente->getNome() ?>?')"><span
                                class='fa fa-times'></span> Excluir</a>
                <?php } ?>
                <button type="reset" class="btn btn-info"><span class="fa fa-eraser"></span> Limpar</button>

                <a class="btn btn-warning" href="index.php"><span class='fa fa-arrow-left'></span> Voltar</a>
            </div>
        </div>
    </form>
</div>