<?php
include_once ('../config.php');

$area = new Area();

switch ($_GET['acao']){
    case 'salvar':
        if (!empty($_POST['cod_area'])){
            // Método para alterar dados no banco
            $area->updateArea($_POST);
        } else {
            // Método para inserir dados no banco
            $area->setData($_POST);
            $area->insertArea();
        }
        break;
    case 'excluir':
        // Método para deletar dados no banco
        $area->loadByCod($_GET['cod_area']);
        $area->deleteArea();
        break;
}
?>