<?php
include_once('../config.php');

$categoria = new Categoria();

switch ($_GET['acao']) {
    case 'salvar':
        if (!empty($_POST['cod_categoria'])) {
            // Método para alterar dados no banco
            $categoria->updateCategoria($_POST);
        } else {
            // Método para inserir dados no banco
            $categoria->setData($_POST);
            $categoria->insertCategoria();
        }
        break;
    case 'excluir':
        // Método para deletar dados no banco
        $categoria->loadByCod($_GET['cod_categoria']);
        $categoria->deleteCategoria();
        break;
}
?>