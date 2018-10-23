<?php

$area = new Area();

?>

<div class="tab-pane fade" id="areas" role="tabpanel" aria-labelledby="areas-tab">
    <br>
    <h4>Áreas</h4>
    <br>
    <a class="btn btn-success" href="../Area/formulario_areas.php">Cadastrar <span class="fa fa-edit"></span></a>
    <br>
    <br>
    <table class="table table-striped table-hover" id="areas_cadastradas" cellspacing="0" width="100%">
        <thead>
            <th>Categoria</th>
            <th>Cód. da area</th>
            <th>Área</th>
            <th>Ações</th>
        </thead>
        <?php
        $areas = $area->areaList();
        foreach ($areas as $aArea) {
            ?>
            <tr>
                <td class="italico"><?= $aArea['descr_categoria'] ?></td>
                <td><?= $aArea['cod_area'] ?></td>
                <td><?= $aArea['descr_area'] ?></td>
                <td>
                    <a class="btn btn-primary" href="../Area/formulario_areas.php?cod_area=<?= $aArea['cod_area'] ?>">Editar <span class="fa fa-pencil-alt"></span></a>
                    <a class="btn btn-danger" href="../Area/formulario_areas.php?cod_area=<?= $aArea['cod_area'] ?>">Excluir <span class="fa fa-times"></span></a>
                </td>
            </tr>
        <?php }
        ?>
    </table>
</div>