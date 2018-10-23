<?php

$fornecedor = new Fornecedor();

?>

<div class="tab-pane fade" id="fornecedores" role="tabpanel" aria-labelledby="fornecedores-tab">
    <br>
    <h4>Fornecedores</h4>
    <br>
    <a class="btn btn-success" href="../Fornecedor/formulario_fornecedores.php">Cadastrar <span class="fa fa-edit"></span></a>
    <br>
    <br>
    <table class="table table-striped table-hover" id="fornecedores_cadastrados" cellspacing="0" width="100%">
        <thead>
        <th>Cód. do fornecedor</th>
        <th>Descrição</th>
        <th>Ações</th>
        </thead>
        <?php
        $fornecedores = $fornecedor->fornecedorList();
        foreach ($fornecedores as $afornecedor) {
            ?>
            <tr>
                <td class="italico"><?= $afornecedor['cod_fornecedor'] ?></td>
                <td><?= $afornecedor['descr_fornecedor'] ?></td>
                <td>
                    <a class="btn btn-primary" href="../Fornecedor/formulario_fornecedores.php?cod_fornecedor=<?= $afornecedor['cod_fornecedor'] ?>">Editar <span class="fa fa-pencil-alt"></span></a>
                    <a class="btn btn-danger" href="../Fornecedor/formulario_fornecedores.php?cod_fornecedor=<?= $afornecedor['cod_fornecedor'] ?>">Excluir <span class="fa fa-times"></span></a>
                </td>
            </tr>
        <?php }
        ?>
    </table>
</div>