<?php
include_once ('../config.php');

$produto = new Produto();

switch ($_GET['acao']){
    case 'salvar':
        if (!empty($_POST['cod_produto'])){
            // Método para alterar dados no banco
            $produto->updateProduto($_POST, $_FILES['arquivo_upload']);
        } else {
            // Método para inserir dados no banco
            $produto->setData($_POST);
            $produto->insertProduto($_FILES['arquivo_upload']);
        }
        break;
    case 'excluir':
        // Método para deletar dados no banco
        $produto->loadByCod($_GET['cod_produto']);
        $produto->deleteProduto();
        break;
}
?>