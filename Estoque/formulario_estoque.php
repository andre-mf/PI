<?php
include_once('../cabecalho.php');

$estoque = new Estoque();

$sql = new Sql();

$estoque->loadByCod($_GET['cod_produto']);

?>
<div class="container">
    <h4 class="p-3">Entrada de mercadorias no estoque</h4>
    <hr>
    <form method="post" onsubmit="return valida_estoque()">

        <input type="hidden" name="cod_produto" value="<?= $estoque->getCodProduto() ?>">

        <div class="form-group row">
            <label for="qtde" class="col-12 col-form-label"><strong>Código <?= $estoque->getCodProduto() . " - " . $estoque->getDescrProduto() ?></strong></label>
        </div>

        <div class="form-group row">
            <div class="col-9">
                <input class="form-control" type="number" name="qtde" autocomplete="off" id="qtde" required>
            </div>
            <div class="col-3">
                <div class="btn-toolbar">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" name="incluir"><span class="fa fa-cubes"></span> Incluir</button>
                        <button type="reset" class="btn btn-info"><span class="fa fa-eraser"></span> Limpar</button>
                        <a class="btn btn-warning" href="index.php"><span class='fa fa-arrow-left'></span> Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php

    if (isset($_POST['incluir']))
    {
        $estoque->setData($_POST);
        $estoque->controlEstoque();

        echo '<script>swal("Feito!", "Quantidade incluída no estoque.", "success");</script>';

    }

    ?>

    <hr>
    <h4 class="p-3">Movimentação de estoque</h4>

    <table class="table table-striped table-hover" id="movimentacao_estoque" cellspacing="0" width="100%">
        <thead>
            <th>Data</th>
            <th>Código</th>
            <th>Descrição</th>
            <th>Tipo de movimentação (E/S)</th>
            <th>Qtde.</th>
        </thead>
        <?php
        $movimentacao = $estoque->moveEstoque($estoque->getCodProduto());
        foreach ($movimentacao as $aMovimentacao) {
            ?>
            <tr>
                <td><?= date('d/m/Y - H:i:s', strtotime($aMovimentacao['data_alteracao'])) ?></td>
                <td><?= $aMovimentacao['cod_produto'] ?></td>
                <td><?= $aMovimentacao['descr_produto'] ?></td>
                <td><?= $aMovimentacao['tipo'] ?></td>
                <td><?= $aMovimentacao['qtde'] ?></td>
            </tr>

        <?php
        }
        ?>
    </table>