<?php

class Area
{

    private $cod_area;
    private $descr_area;
    private $cod_categoria;
    private $status;

    // Getters e setters

    public function getCodArea()
    {
        return $this->cod_area;
    }

    public function setCodArea($cod_area)
    {
        $this->cod_area = $cod_area;
    }

    public function getDescrArea()
    {
        return $this->descr_area;
    }

    public function setDescrArea($descr_area)
    {
        $this->descr_area = $descr_area;
    }

    public function getCodCategoria()
    {
        return $this->cod_categoria;
    }

    public function setCodCategoria($cod_categoria)
    {
        $this->cod_categoria = $cod_categoria;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    // Demais métodos

    public function setData($data)
    {

        $this->setCodArea($data['cod_area']);
        $this->setDescrArea($data['descr_area']);
        $this->setCodCategoria($data['cod_categoria']);
        $this->setStatus($data['status']);

    }

    public function loadByCod($cod_area)
    {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM area JOIN categoria USING (cod_categoria) WHERE cod_area = :COD_AREA", array(
            ":COD_AREA" => $cod_area
        ));

        if (isset($results[0])) {

            $this->setData($results[0]);

        }

        return $results;

    }

    public function areaList()
    {

        $sql = new Sql();
        return $resultado = $sql->select("SELECT descr_categoria, cod_area, descr_area FROM categoria JOIN area a ON categoria.cod_categoria = a.cod_categoria WHERE a.status = :STATUS and categoria.status = :STATUS ORDER BY descr_area", [
            ":STATUS" => 1
        ]);

    }

    public function insertArea()
    {

        $sql = new Sql();

        //  Pesquisa a área antes de cadastrá-la
        $row = $sql->select("SELECT cod_area FROM area WHERE descr_area = :DESCR_AREA AND cod_categoria = :COD_CATEGORIA",[
            ':DESCR_AREA' => $this->getDescrArea(),
            ':COD_CATEGORIA' => $this->getCodCategoria()
        ]);

        if (isset($row[0]['cod_area'])) {

            echo '<script>swal("Ops!", "Área já cadastrada (código ' . $row[0]['cod_area'] . ').", "error");</script>';
            header("Refresh: 2, ../Produto/produtos.php");

        } else {

            // Realiza o cadastro, caso não encontre registro no banco
            $sql->query("INSERT INTO area VALUES (DEFAULT, :DESCR_AREA, :COD_CATEGORIA, DEFAULT)", [
                ':DESCR_AREA' => $this->getDescrArea(),
                ':COD_CATEGORIA' => $this->getCodCategoria()
            ]);

            echo '<script>swal("Feito!", "Área cadastrada.", "success");</script>';
            header("Refresh: 2, ../Produto/produtos.php");
        }

    }

    public function updateArea($data)
    {

        $this->setData($data);

        $sql = new Sql();

        //  Pesquisa a área antes de alterá-la
        $row = $sql->select("SELECT cod_area FROM area WHERE descr_area = :DESCR_AREA AND cod_categoria = :COD_CATEGORIA", [
            ':DESCR_AREA' => $this->getDescrArea(),
            ':COD_CATEGORIA' => $this->getCodCategoria()
        ]);

        if (isset($row[0]['cod_area'])) {

            echo '<script>swal("Ops!", "Área já cadastrada (código ' . $row[0]['cod_area'] . ').", "error");</script>';
            header("Refresh: 2, ../Produto/produtos.php");

        } else {

            // Realiza a alteração do cadastro, caso não encontre registro no banco
            $sql->query("UPDATE area SET descr_area = :DESCR_AREA, cod_categoria = :COD_CATEGORIA WHERE cod_area = :COD_AREA", [
                ':DESCR_AREA' => $this->getDescrArea(),
                ':COD_CATEGORIA' => $this->getCodCategoria(),
                ':COD_AREA' => $this->getCodArea()
            ]);

            echo '<script>swal("Feito!", "Cadastro de área alterado.", "success");</script>';
            header("Refresh: 2, ../Produto/produtos.php");

        }

    }

    public function deleteArea()
    {

        $sql = new Sql();

        // Desativa a area no banco
        $sql->query("UPDATE area SET status = :STATUS WHERE cod_area = :COD_AREA", [
            ':STATUS' => 0,
            ':COD_AREA' => $this->getCodArea()
        ]);

        echo '<script>swal("Feito!", "Área excluída.", "success");</script>';
        header("Refresh: 2, ../Produto/produtos.php");

    }

}