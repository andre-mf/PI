<?php

include_once('../cabecalho.php');

$produto = new Produto();

$area = new Area();

$categoria = new Categoria();

$fornecedor = new Fornecedor();

$sql = new Sql();

if (isset($_GET['cod_produto'])) {

    $produto->loadByCod($_GET['cod_produto']);

    $area->loadByCod($produto->getCodArea());

    $categoria->loadByCod($area->getCodCategoria());

    $fornecedor->loadByCod($produto->getCodFornecedor());

}
?>
<div class="container">
    <h4 class="p-3"><?= (isset($_GET['cod_produto'])) ? 'Alterar cadastro de produtos' : 'Cadastrar produtos' ?></h4>
    <hr>
    <form method="post" action="processamento.php?acao=salvar" enctype="multipart/form-data"
          onsubmit="return valida_produto();">

        <input type="hidden" name="cod_produto" value="<?= $produto->getCodProduto() ?>">
        <input type='hidden' name='status' value='1'>


        <div class="form-group row">
            <label for="descr_produto" class="col-3 col-form-label"><strong>Descrição do Produto</strong></label>
            <div class="col-9">
                <input class="form-control" type="text" name="descr_produto" id="descr_produto" autocomplete="off"
                       value="<?= htmlentities($produto->getDescrProduto(),ENT_QUOTES) ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="cod_categoria" class="col-3 col-form-label"><strong>Categoria</strong></label>
            <div class="col-9">
                <select class="form-control" name="cod_categoria" id="cod_categoria" required>
                    <option value="">--</option>
                    <?php

                    $categorias = $sql->select("SELECT * FROM categoria WHERE status = :STATUS ORDER BY descr_categoria", [
                        ":STATUS" => 1
                    ]);

                    foreach ($categorias as $aCategoria) { ?>

                        <?php $selected = (($aCategoria['cod_categoria'] == $categoria->getCodCategoria()) ? 'selected' : '') ?>
                        <option value="<?= $aCategoria['cod_categoria'] ?>" <?= $selected ?>><?= $aCategoria['descr_categoria'] ?></option>

                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="cod_area" class="col-3 col-form-label"><strong>Área</strong></label>
            <div class="col-9">
                <select class="form-control" name="cod_area" id="cod_area" required>
                    <script type="text/javascript">
                        $(document).ready(function () {

                            $('#cod_categoria').change(function () {
                                $('#cod_area').load('../preenche_combos.php?selec_cod_categoria=' + $('#cod_categoria').val());
                            });

                        });
                    </script>
                    <option value="0">--</option>
                    <?php

                    $areas = $sql->select("SELECT * FROM area WHERE status = :STATUS ORDER BY descr_area", [
                        ":STATUS" => 1
                    ]);

                    foreach ($areas as $aArea) { ?>
                        <?php $selected = (($aArea['cod_area'] == $produto->getCodArea()) ? 'selected' : '') ?>
                        <option value="<?= $aArea['cod_area'] ?>" <?= $selected ?>><?= $aArea['descr_area'] ?></option>

                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="cod_fornecedor" class="col-3 col-form-label"><strong>Fornecedor</strong></label>
            <div class="col-9">
                <select class="form-control" name="cod_fornecedor" id="cod_fornecedor" required>
                    <option value="">--</option>
                    <?php

                    $fornecedores = $sql->select("SELECT * FROM fornecedor WHERE status = :STATUS ORDER BY descr_fornecedor", [
                        ":STATUS" => 1
                    ]);

                    foreach ($fornecedores as $aFornecedor) { ?>
                        <?php $selected = (($aFornecedor['cod_fornecedor'] == $produto->getCodFornecedor()) ? 'selected' : ''); ?>
                        <option value="<?= $aFornecedor['cod_fornecedor'] ?>" <?= $selected ?>><?= $aFornecedor['descr_fornecedor'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="preco_custo" class="col-3 col-form-label"><strong>Preço de Custo</strong></label>
            <div class="col-9">
                <input class="form-control" type="text" name="preco_custo" id="preco_custo" autocomplete="off"
                       value="<?= $produto->getPrecoCusto() ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="preco_venda" class="col-3 col-form-label"><strong>Preço de Venda</strong></label>
            <div class="col-9">
                <input class="form-control" type="text" name="preco_venda" id="preco_venda" autocomplete="off"
                       value="<?= $produto->getPrecoVenda() ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="arquivo_upload" class="col-3 col-form-label"><strong>Imagem do produto</strong></label>
            <div class="col-9">
                <input class="form-control form-control-file" type="file" name="arquivo_upload" id="arquivo_upload"
                       autocomplete="off" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="resumo" class="col-3 col-form-label"><strong>Resumo</strong></label>
            <div class="col-9">
                <textarea class="form-control" name="resumo" id="resumo"><?= $produto->getResumo() ?></textarea>
            </div>
        </div>

        <div class="btn-toolbar">
            <div class="btn-group">
                <button type="submit" class="btn <?= (isset($_GET['cod_produto']) ? 'btn-primary' : 'btn-success') ?>">
                    <span class="fa fa-edit"></span> <?= (isset($_GET['cod_produto']) ? 'Alterar' : 'Cadastrar') ?>
                </button>
                <?php if (isset($_GET['cod_produto'])) { ?>
                    <a class="btn btn-danger"
                       href="processamento.php?acao=excluir&cod_produto=<?= $_GET['cod_produto'] ?>"
                       onclick="return confirm('Deseja realmente excluir o produto <?= $produto->getCodProduto() . ' - ' . $produto->getDescrProduto() ?>?')"><span
                                class='fa fa-times'></span> Excluir</a>
                <?php } ?>
                <button type="reset" class="btn btn-info"><span class="fa fa-eraser"></span> Limpar</button>

                <a class="btn btn-warning" href="produtos.php"><span class='fa fa-arrow-left'></span> Voltar</a>
            </div>
        </div>
    </form>
</div>