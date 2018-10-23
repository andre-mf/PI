<?php
include_once('Sql/Sql.php');

$sql = new Sql();

// Combo de categorias
if (isset($_GET['selec_cod_categoria'])) {

    $cod_categoria = $_GET['selec_cod_categoria'];

    $selec_area = $sql->select("SELECT * FROM area WHERE cod_categoria = :COD_CATEGORIA AND status = :STATUS", [
        ":COD_CATEGORIA" => $cod_categoria,
        ":STATUS" => 1
    ]);

    foreach ($selec_area as $area) {

        echo "<option value='{$area['cod_area']}'>{$area['descr_area']}</option>";

    }

}

?>