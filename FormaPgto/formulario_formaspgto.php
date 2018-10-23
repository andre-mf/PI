<?php
include_once('../cabecalho.php');

$formaPgto = new FormaPgto();

$sql = new Sql();

if (isset($_GET['cod_fpg'])) {

    $formaPgto->loadByCod($_GET['cod_fpg']);

}
?>
<div class="container">
    <h4 class="p-3"><?= (isset($_GET['cod_fpg'])) ? 'Alterar cadastro de formas de pagamento' : 'Cadastrar formas de pagamento' ?></h4>
    <hr>
    <form method="post" action="processamento.php?acao=salvar">

        <input type="hidden" name="cod_fpg" value="<?= $formaPgto->getCodFpg() ?>">
        <input type='hidden' name='status' value='1'>


        <div class="form-group row">
            <label for="descr_fpg" class="col-4 col-form-label"><strong>Descrição da Forma de pagamento</strong></label>
            <div class="col-8">
                <input class="form-control" type="text" name="descr_fpg" id="descr_fpg" autocomplete="off"
                       value="<?= htmlentities($formaPgto->getDescrFpg(),ENT_QUOTES) ?>" required>
            </div>
        </div>

        <div class="btn-toolbar">
            <div class="btn-group">
                <button type="submit" class="btn <?= (isset($_GET['cod_fpg']) ? 'btn-primary' : 'btn-success') ?>"><span class="fa fa-edit"></span> <?= (isset($_GET['cod_fpg']) ? 'Alterar' : 'Cadastrar') ?></button>
            <?php if (isset($_GET['cod_fpg'])) { ?>
                <a class="btn btn-danger" href="processamento.php?acao=excluir&cod_fpg=<?=$_GET['cod_fpg']?>" onclick="return confirm('Deseja realmente excluir a forma de pagamento <?= $formaPgto->getCodFpg().' - '.$formaPgto->getDescrFpg() ?>?')"><span class='fa fa-times'></span> Excluir</a>
            <?php } ?>
                <button type="reset" class="btn btn-info"><span class="fa fa-eraser"></span> Limpar</button>

                <a class="btn btn-warning" href="index.php"><span class='fa fa-arrow-left'></span> Voltar</a>
            </div>
        </div>
    </form>
</div>



