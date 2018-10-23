<?php

include_once('../cabecalho.php');

$area = new Area();

$categoria = new Categoria();

$sql = new Sql();

if (isset($_GET['cod_area'])) {

    $area->loadByCod($_GET['cod_area']);

    $categoria->loadByCod($area->getCodCategoria());

}
?>
<div class="container">
    <h4 class="p-3"><?= (isset($_GET['cod_area'])) ? 'Alterar cadastro de áreas' : 'Cadastrar áreas' ?></h4>
    <hr>
    <form method="post" action="processamento.php?acao=salvar">

        <input type="hidden" name="cod_area" value="<?= $area->getCodArea() ?>">
        <input type='hidden' name='status' value='1'>

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
            <label for="descr_area" class="col-3 col-form-label"><strong>Descrição da Área</strong></label>
            <div class="col-9">
                <input class="form-control" type="text" name="descr_area" id="descr_area" autocomplete="off"
                       value="<?= htmlentities($area->getDescrArea(), ENT_QUOTES) ?>" required>
            </div>
        </div>

        <div class="btn-toolbar">
            <div class="btn-group">
                <button type="submit" class="btn <?= (isset($_GET['cod_area']) ? 'btn-primary' : 'btn-success') ?>">
                    <span class="fa fa-edit"></span> <?= (isset($_GET['cod_area']) ? 'Alterar' : 'Cadastrar') ?>
                </button>
                <?php if (isset($_GET['cod_area'])) { ?>
                    <a class="btn btn-danger"
                       href="processamento.php?acao=excluir&cod_area=<?= $_GET['cod_area'] ?>"
                       onclick="return confirm('Deseja realmente excluir a área <?= $area->getCodArea() . ' - ' . $area->getDescrArea() ?>?')"><span
                                class='fa fa-times'></span> Excluir</a>
                <?php } ?>
                <button type="reset" class="btn btn-info"><span class="fa fa-eraser"></span> Limpar</button>

                <a class="btn btn-warning" href="../Produto/produtos.php"><span class='fa fa-arrow-left'></span> Voltar</a>
            </div>
        </div>
    </form>
</div>