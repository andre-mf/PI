<?php
include_once('../cabecalho.php');

$categoria = new Categoria();

$sql = new Sql();

if (isset($_GET['cod_categoria'])) {

    $categoria->loadByCod($_GET['cod_categoria']);

}
?>
<div class="container">
    <h4 class="p-3"><?= (isset($_GET['cod_categoria'])) ? 'Alterar cadastro de categorias' : 'Cadastrar categorias' ?></h4>
    <hr>
    <form method="post" action="processamento.php?acao=salvar">

        <input type="hidden" name="cod_categoria" value="<?= $categoria->getCodCategoria() ?>">
        <input type='hidden' name='status' value='1'>


        <div class="form-group row">
            <label for="descr_categoria" class="col-3 col-form-label"><strong>Descrição da Categoria</strong></label>
            <div class="col-9">
                <input class="form-control" type="text" name="descr_categoria" id="descr_categoria" autocomplete="off"
                       value="<?= htmlentities($categoria->getDescrCategoria(), ENT_QUOTES) ?>" required>
            </div>
        </div>

        <div class="btn-toolbar">
            <div class="btn-group">
                <button type="submit" class="btn <?= (isset($_GET['cod_categoria']) ? 'btn-primary' : 'btn-success') ?>"><span class="fa fa-edit"></span> <?= (isset($_GET['cod_categoria']) ? 'Alterar' : 'Cadastrar') ?></button>
            <?php if (isset($_GET['cod_categoria'])) { ?>
                <a class="btn btn-danger" href="processamento.php?acao=excluir&cod_categoria=<?=$_GET['cod_categoria']?>" onclick="return confirm('Deseja realmente excluir a categoria <?= $categoria->getCodCategoria().' - '.$categoria->getDescrCategoria() ?>?')"><span class='fa fa-times'></span> Excluir</a>
            <?php } ?>
                <button type="reset" class="btn btn-info"><span class="fa fa-eraser"></span> Limpar</button>

                <a class="btn btn-warning" href="../Produto/produtos.php"><span class='fa fa-arrow-left'></span> Voltar</a>
            </div>
        </div>
    </form>
</div>



