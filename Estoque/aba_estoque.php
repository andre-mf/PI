<?php

$estoque = new Estoque();

?>

<div class="tab-pane fade show active" id="estoque" role="tabpanel" aria-labelledby="estoque-tab">
    <br>
    <h4>Produtos no estoque</h4>
    <br>
    <table class="table table-striped table-hover" id="produtos_estoque" cellspacing="0" width="100%">
        <thead>
            <th>Cód. do produto</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Área</th>
            <th>Qtde.</th>
            <th>Ações</th>
        </thead>
        <?php
        $produtos = $estoque->produtoList();
        foreach ($produtos as $aProduto) {
            ?>
            <tr>
                <td class="italico"><?= $aProduto['cod_produto'] ?></td>
                <td><?= $aProduto['descr_produto'] ?></td>
                <td><?= $aProduto['descr_categoria'] ?></td>
                <td><?= $aProduto['descr_area'] ?></td>
                <td><?= $aProduto['qtde'] ?></td>
                <td>
                    <a class="btn btn-primary" href="formulario_estoque.php?cod_produto=<?= $aProduto['cod_produto'] ?>">Incluir <span class="fa fa-cubes"></span></a>
                </td>
            </tr>
        <?php }
        ?>
    </table>
</div>