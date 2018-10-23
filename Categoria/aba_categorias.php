<?php

$categoria = new Categoria();

?>

<div class="tab-pane fade" id="categorias" role="tabpanel" aria-labelledby="categorias-tab">
    <br>
    <h4>Categorias</h4>
    <br>
    <a class="btn btn-success" href="../Categoria/formulario_categorias.php">Cadastrar <span class="fa fa-edit"></span></a>
    <br>
    <br>
    <table class="table table-striped table-hover" id="categorias_cadastradas" cellspacing="0" width="100%">
        <thead>
        <th>Cód. da categoria</th>
        <th>Descrição</th>
        <th>Ações</th>
        </thead>
        <?php
        $categorias = $categoria->categoriaList();
        foreach ($categorias as $aCategoria) {
            ?>
            <tr>
                <td class="italico"><?= $aCategoria['cod_categoria'] ?></td>
                <td><?= $aCategoria['descr_categoria'] ?></td>
                <td>
                    <a class="btn btn-primary" href="../Categoria/formulario_categorias.php?cod_categoria=<?= $aCategoria['cod_categoria'] ?>">Editar <span class="fa fa-pencil-alt"></span></a>
                    <a class="btn btn-danger" href="../Categoria/formulario_categorias.php?cod_categoria=<?= $aCategoria['cod_categoria'] ?>">Excluir <span class="fa fa-times"></span></a>
                </td>
            </tr>
        <?php }
        ?>
    </table>
</div>