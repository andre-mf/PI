<?php

$formaPgto = new FormaPgto();

$sql = new Sql();

?>

<div class="tab-pane fade show active" id="formaspgto" role="tabpanel" aria-labelledby="formaspgto-tab">
    <br>
    <h4>Fomas de pagamento</h4>
    <br>
    <a class="btn btn-success" href="../FormaPgto/formulario_formaspgto.php">Cadastrar <span class="fa fa-edit"></span></a>
    <br>
    <br>
    <table class="table table-striped table-hover" id="formaspgto_cadastradas" cellspacing="0" width="100%">
        <thead>
        <th>Cód. da forma de pagamento</th>
        <th>Descrição</th>
        <th>Ações</th>
        </thead>
        <?php
        $formasPgtos = $formaPgto->fpgList();
        foreach ($formasPgtos as $aFormasPgto) {
            ?>
            <tr>
                <td class="italico"><?= $aFormasPgto['cod_fpg'] ?></td>
                <td><?= $aFormasPgto['descr_fpg'] ?></td>
                <td>
                    <a class="btn btn-primary" href="../FormaPgto/formulario_formaspgto.php?cod_fpg=<?= $aFormasPgto['cod_fpg'] ?>">Editar <span class="fa fa-pencil-alt"></span></a>
                    <a class="btn btn-danger" href="../FormaPgto/formulario_formaspgto.php?cod_fpg=<?= $aFormasPgto['cod_fpg'] ?>">Excluir <span class="fa fa-times"></span></a>
                </td>
            </tr>
        <?php }
        ?>
    </table>
</div>