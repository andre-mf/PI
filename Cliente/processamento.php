<?php
include_once('../config.php');

$cliente = new Cliente();

switch ($_GET['acao']) {
    case 'salvar':
        if (!empty($_POST['cod_cliente'])) {
            // Método para alterar dados no banco
            $cliente->update($_POST);
        } else {
            // Método para inserir dados no banco
            $cliente->setData($_POST);
            $cliente->insert();
        }
        break;
    case 'excluir':
        // Método para deletar dados no banco
        $cliente->loadByCod($_GET['cod_cliente']);
        $cliente->delete();
        break;
}
?>