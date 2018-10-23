<?php
include_once('../config.php');

$formaPgto = new FormaPgto();

switch ($_GET['acao']) {
    case 'salvar':
        if (!empty($_POST['cod_fpg'])) {
            // Método para alterar dados no banco
            $formaPgto->updateFpg($_POST);
        } else {
            // Método para inserir dados no banco
            $formaPgto->setData($_POST);
            $formaPgto->insertFpg();
        }
        break;
    case 'excluir':
        // Método para deletar dados no banco
        $formaPgto->loadByCod($_GET['cod_fpg']);
        $formaPgto->deleteFpg();
        break;
}
?>