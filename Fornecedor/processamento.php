<?php
include_once('../config.php');

$fornecedor = new Fornecedor();

switch ($_GET['acao']) {
    case 'salvar':
        if (!empty($_POST['cod_fornecedor'])) {
            // Método para alterar dados no banco
            $fornecedor->update($_POST);
        } else {
            // Método para inserir dados no banco
            $fornecedor->setData($_POST);
            $fornecedor->insert();
        }
        break;
    case 'excluir':
        // Método para deletar dados no banco
        $fornecedor->loadByCod($_GET['cod_fornecedor']);
        $fornecedor->delete();
        break;
}
?>