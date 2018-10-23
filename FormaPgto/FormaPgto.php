<?php

class FormaPgto{

    private $cod_fpg;
    private $descr_fpg;
    private $status;

    // Getters e setters

    public function getCodFpg()
    {
        return $this->cod_fpg;
    }

    public function setCodFpg($cod_fpg)
    {
        $this->cod_fpg = $cod_fpg;
    }

    public function getDescrFpg()
    {
        return $this->descr_fpg;
    }

    public function setDescrFpg($descr_fpg)
    {
        $this->descr_fpg = $descr_fpg;
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

        $this->setCodFpg($data['cod_fpg']);
        $this->setDescrFpg($data['descr_fpg']);
        $this->setStatus($data['status']);

    }

    public function loadByCod($cod_fpg)
    {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM forma_pgto WHERE cod_fpg = :COD_FPG", array(
            ":COD_FPG" => $cod_fpg
        ));

        if (isset($results[0]))
        {

            $this->setData($results[0]);

        }

        return $results;

    }

    public function fpgList()
    {

        $sql = new Sql();
        return $resultado = $sql->select("SELECT * FROM forma_pgto WHERE status = :STATUS", [
            ":STATUS" => 1
        ]);

    }

    public function insertFpg()
    {

        $sql = new Sql();

        //  Pesquisa a forma de pagamento antes de cadastrá-la
        $row = $sql->select("SELECT cod_fpg FROM forma_pgto WHERE descr_fpg = :DESCR_FPG", [
            ':DESCR_FPG' => $this->getDescrFpg()
        ]);

        if (isset($row[0]['cod_fpg']))
        {

            echo '<script>swal("Erro!", "Forma de pagamento já cadastrada (código ' . $row[0]['cod_fpg'] . ').", "error");</script>';
            header("Refresh: 2, ../Produto/produtos.php");

        } else {

            // Realiza o cadastro, caso não encontre registro no banco

            // Insere os dados na tabela forma_pgto

            $sql->query("INSERT INTO forma_pgto VALUES (DEFAULT, :DESCR_FPG, DEFAULT)", [
                ':DESCR_FPG' => $this->getDescrFpg()
            ]);

            echo '<script>swal("Feito!", "Forma de pagamento cadastrada.", "success");</script>';
            header("Refresh: 2, ../FormaPgto/index.php");

        }

    }

    public function updateFpg($data)
    {

        $this->setData($data);

        $sql = new Sql();

        //  Pesquisa a forma de pagamento antes de cadastrá-la
        $row = $sql->select("SELECT cod_fpg FROM forma_pgto WHERE descr_fpg = :DESCR_FPG", [
            ':DESCR_FPG' => $this->getDescrFpg()
        ]);

        if (isset($row[0]['cod_fpg']))
        {

            echo '<script>swal("Erro!", "Forma de pagamento já cadastrada (código ' . $row[0]['cod_fpg'] . ').", "error");</script>';
            header("Refresh: 2, ../FormaPgto/index.php");

        } else {

            // Realiza a alteração do cadastro, caso não encontre registro no banco
            $sql->query("UPDATE forma_pgto SET descr_fpg = :DESCR_FPG WHERE cod_fpg = :COD_FPG", [
                ':DESCR_FPG' => $this->getDescrFpg(),
                ':COD_FPG' => $this->getCodFpg()
            ]);

            echo '<script>swal("Feito!", "Cadastro de forma de pagamento alterado.", "success");</script>';
            header("Refresh: 2, ../FormaPgto/index.php");
        }

    }

    public function deleteFpg()
    {

        $sql = new Sql();

        $sql->query("UPDATE forma_pgto SET status = :STATUS WHERE cod_fpg = :COD_FPG", [
            ':STATUS' => 0,
            ':COD_FPG' => $this->getCodFpg()
        ]);

        echo '<script>swal("Feito!", "Forma de pagamento excluída.", "success");</script>';
        header("Refresh: 2, ../FormaPgto/index.php");

    }


}