<?php
include_once('../cabecalho.php');

$fornecedor = new Fornecedor();

$sql = new Sql();

if (isset($_GET['cod_fornecedor'])) {

    $fornecedor->loadByCod($_GET['cod_fornecedor']);

}
?>
<div class="container">
    <h4 class="p-3"><?= (isset($_GET['cod_fornecedor'])) ? 'Alterar cadastro de fornecedores' : 'Cadastrar fornecedores' ?></h4>
    <hr>
    <form method="post" action="processamento.php?acao=salvar" onsubmit="return valida_fornecedor();">

        <input type="hidden" name="cod_fornecedor" value="<?= $fornecedor->getCodFornecedor() ?>">
        <input type='hidden' name='status' value='1'>

        <div class="form-group row">
            <label for="descr_fornecedor" class="col-3 col-form-label"><strong>Descrição do Fornecedor</strong></label>
            <div class="col-9">
                <input class="form-control" type="text" name="descr_fornecedor" autocomplete="off" id="descr_fornecedor" value="<?= htmlentities($fornecedor->getDescrFornecedor(),ENT_QUOTES) ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-3 col-form-label"><strong>Email</strong></label>
            <div class="col-9">
                <input class="form-control" type="email" name="email" id="email" autocomplete="off" value="<?= $fornecedor->getEmail() ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="telefone" class="col-3 col-form-label"><strong>Telefone</strong></label>
            <div class="col-9">
                <input class="form-control phone-ddd-mask" type="text" name="telefone" autocomplete="off" id="telefone" value="<?= $fornecedor->getTelefone() ?>"required>
            </div>
        </div>

        <div class="form-group row">
            <label for="cep" class="col-3 col-form-label"><strong>CEP</strong></label>
            <div class="col-9">
                <input class="form-control" type="text" name="cep" id="cep" autocomplete="off" value="<?= $fornecedor->getCep() ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="logradouro" class="col-3 col-form-label"><strong>Endereço</strong></label>
            <div class="col-9">
                <input class="form-control" type="text" name="logradouro" id="logradouro" autocomplete="off" value="<?= htmlentities($fornecedor->getLogradouro(),ENT_QUOTES) ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="numero" class="col-3 col-form-label"><strong>Número</strong></label>
            <div class="col-9">
                <input class="form-control" type="text" name="numero" id="numero" autocomplete="off" value="<?= $fornecedor->getNumero() ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="bairro" class="col-3 col-form-label"><strong>Bairro</strong></label>
            <div class="col-9">
                <input class="form-control fundo_branco_formulario_disable" type="text" name="bairro" id="bairro" autocomplete="off" value="<?= htmlentities($fornecedor->getBairro(),ENT_QUOTES) ?>" required readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="localidade" class="col-3 col-form-label"><strong>Cidade</strong></label>
            <div class="col-9">
                <input class="form-control fundo_branco_formulario_disable" type="text" name="localidade" id="localidade" autocomplete="off" value="<?= htmlentities($fornecedor->getLocalidade(),ENT_QUOTES) ?>" required readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="uf" class="col-3 col-form-label"><strong>Estado</strong></label>
            <div class="col-9">
                <input class="form-control fundo_branco_formulario_disable" type="text" name="uf" id="uf" autocomplete="off" value="<?= $fornecedor->getUf() ?>" required readonly>
            </div>
        </div>

        <div class="btn-toolbar">
            <div class="btn-group">
                <button type="submit" class="btn <?= (isset($_GET['cod_fornecedor']) ? 'btn-primary' : 'btn-success') ?>">
                    <span class="fa fa-edit"></span> <?= (isset($_GET['cod_fornecedor']) ? 'Alterar' : 'Cadastrar') ?>
                </button>
                <?php if (isset($_GET['cod_fornecedor'])) { ?>
                    <a class="btn btn-danger"
                       href="processamento.php?acao=excluir&cod_fornecedor=<?= $_GET['cod_fornecedor'] ?>"
                       onclick="return confirm('Deseja realmente excluir a área <?= $fornecedor->getCodFornecedor() . ' - ' . $fornecedor->getDescrFornecedor() ?>?')"><span
                                class='fa fa-times'></span> Excluir</a>
                <?php } ?>
                <button type="reset" class="btn btn-info"><span class="fa fa-eraser"></span> Limpar</button>

                <a class="btn btn-warning" href="../Produto/produtos.php"><span class='fa fa-arrow-left'></span> Voltar</a>
            </div>
        </div>
    </form>
</div>