<?php

class Categoria
{

    private $cod_categoria;
    private $descr_categoria;
    private $status;

    public function getCodCategoria()
    {
        return $this->cod_categoria;
    }

    public function setCodCategoria($cod_categoria)
    {
        $this->cod_categoria = $cod_categoria;
    }

    public function getDescrCategoria()
    {
        return $this->descr_categoria;
    }

    public function setDescrCategoria($descr_categoria)
    {
        $this->descr_categoria = $descr_categoria;
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

        $this->setDescrCategoria($data['descr_categoria']);
        $this->setCodCategoria($data['cod_categoria']);
        $this->setStatus($data['status']);

    }

    public function loadByCod($cod_categoria)
    {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM categoria WHERE cod_categoria = :COD_CATEGORIA", array(
            ":COD_CATEGORIA" => $cod_categoria
        ));

        if (isset($results[0])) {

            $this->setData($results[0]);

        }

        return $results;

    }

    public function categoriaList()
    {

        $sql = new Sql();
        return $resultado = $sql->select("SELECT * FROM categoria WHERE status = :STATUS", [
            ":STATUS" => 1
        ]);

    }

    public function insertCategoria()
    {

        $sql = new Sql();

        //  Pesquisa a categoria antes de cadastrá-la
        $row = $sql->select("SELECT cod_categoria FROM categoria WHERE descr_categoria = :DESCR_CATEGORIA", [
            ':DESCR_CATEGORIA' => $this->getDescrCategoria()
        ]);

        if (isset($row[0]['cod_categoria'])) {

            echo '<script>swal("Ops!", "Categoria já cadastrada (código ' . $row[0]['cod_categoria'] . ').", "error");</script>';
            header("Refresh: 2, ../Produto/produtos.php");

        } else {

            // Realiza o cadastro, caso não encontre registro no banco
            $sql->query("INSERT INTO categoria VALUES (DEFAULT, :DESCR_CATEGORIA, DEFAULT)", [
                ':DESCR_CATEGORIA' => $this->getDescrCategoria()
            ]);

            echo '<script>swal("Feito!", "Categoria cadastrada.", "success");</script>';
            header("Refresh: 2, ../Produto/produtos.php");
        }
    }

    public function updateCategoria($data)
    {

        $this->setData($data);

        $sql = new Sql();

        //  Pesquisa a categoria antes de alterá-la
        $row = $sql->select("SELECT cod_categoria FROM categoria WHERE descr_categoria = :DESCR_CATEGORIA AND cod_categoria <> :COD_CATEGORIA", [
            ':DESCR_CATEGORIA' => $this->getDescrCategoria(),
            ':COD_CATEGORIA' => $this->getCodCategoria()
        ]);

        if (isset($row[0]['cod_categoria'])) {

            echo '<script>swal("Ops!", "Categoria já cadastrada (código ' . $row[0]['cod_categoria'] . ').", "error");</script>';
            header("Refresh: 2, ../Produto/produtos.php");

        } else {

            // Realiza a alteração do cadastro, caso não encontre registro no banco
            $sql->query("UPDATE categoria SET descr_categoria = :DESCR_CATEGORIA WHERE cod_categoria = :COD_CATEGORIA", [
                ':DESCR_CATEGORIA' => $this->getDescrCategoria(),
                ':COD_CATEGORIA' => $this->getCodCategoria()
            ]);

            echo '<script>swal("Feito!", "Cadastro de categoria alterado.", "success");</script>';
            header("Refresh: 2, ../Produto/produtos.php");

        }

    }

    public function deleteCategoria()
    {

        $sql = new Sql();

        $sql->query("UPDATE categoria SET status = :STATUS WHERE cod_categoria = :COD_CATEGORIA", [
            ':STATUS' => 0,
            ':COD_CATEGORIA' => $this->getCodCategoria()
        ]);

        echo '<script>swal("Feito!", "Categoria excluída.", "success");</script>';
        header("Refresh: 2, ../Produto/produtos.php");

    }

}