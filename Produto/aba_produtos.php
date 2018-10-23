<?php

$produto = new Produto();

?>

<div class="tab-pane fade show active" id="produtos" role="tabpanel" aria-labelledby="produtos-tab">
    <br>
    <h4>Produtos</h4>
    <br>
    <a class="btn btn-success" href="../Produto/formulario_produtos.php">Cadastrar <span class="fa fa-edit"></span></a>
    <br>
    <br>
    <table class="table table-striped table-hover" id="produtos_cadastrados" cellspacing="0" width="100%">
        <thead>
            <th>Cód. do produto</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Área</th>
            <th>Fornecedor</th>
            <th>Preço de custo</th>
            <th>Preço de venda</th>
            <th>Ações</th>
        </thead>
        <?php
        $produtos = $produto->produtoList();
        foreach ($produtos as $aProduto) {
            ?>
            <tr>
                <td class="italico"><?= $aProduto['cod_produto'] ?></td>
                <td><?= $aProduto['descr_produto'] ?></td>
                <td><?= $aProduto['descr_categoria'] ?></td>
                <td><?= $aProduto['descr_area'] ?></td>
                <td><?= $aProduto['descr_fornecedor'] ?></td>
                <td><?= $aProduto['preco_custo'] ?></td>
                <td><?= $aProduto['preco_venda'] ?></td>
                <td>
                    <a class="btn btn-primary" href="formulario_produtos.php?cod_produto=<?= $aProduto['cod_produto'] ?>">Editar <span class="fa fa-pencil-alt"></span></a>
                    <a class="btn btn-danger" href="formulario_produtos.php?cod_produto=<?= $aProduto['cod_produto'] ?>">Excluir <span class="fa fa-times"></span></a>
                </td>
            </tr>
        <?php }
        ?>
    </table>
</div>