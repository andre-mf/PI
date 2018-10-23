<?php

include_once('../config.php');

class Fornecedor extends Endereco
{

    private $cod_fornecedor;
    private $descr_fornecedor;
    private $cod_endereco;
    private $email;
    private $telefone;
    private $status;

    // Getters e setters

    public function getCodFornecedor()
    {
        return $this->cod_fornecedor;
    }

    public function setCodFornecedor($cod_fornecedor)
    {
        $this->cod_fornecedor = $cod_fornecedor;
    }

    public function getDescrFornecedor()
    {
        return $this->descr_fornecedor;
    }

    public function setDescrFornecedor($descr_fornecedor)
    {
        $this->descr_fornecedor = $descr_fornecedor;
    }

    public function getCodEndereco()
    {
        return $this->cod_endereco;
    }

    public function setCodEndereco($cod_endereco)
    {
        $this->cod_endereco = $cod_endereco;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
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

        $this->setCodFornecedor($data['cod_fornecedor']);
        $this->setDescrFornecedor($data['descr_fornecedor']);
        $this->setEmail($data['email']);
        $this->setTelefone($data['telefone']);
        $this->setStatus($data['status']);

        $this->setCep($data['cep']);

        if (isset($data['numero'])) {

            $this->setLogradouro($data['logradouro'] . ', ' . $data['numero']);

        } else {

            $aLogradouro = explode(', ', $data['logradouro']);
            $this->setLogradouro($aLogradouro[0]);
            $this->setNumero($aLogradouro[1]);

        }

        $this->setBairro($data['bairro']);
        $this->setLocalidade($data['localidade']);
        $this->setUf($data['uf']);

    }

    public function loadByCod($cod_fornecedor)
    {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM fornecedor JOIN endereco USING (cod_endereco) WHERE cod_fornecedor = :COD_FORNECEDOR", array(
            ":COD_FORNECEDOR" => $cod_fornecedor
        ));

        if (isset($results[0]))
        {

            $this->setData($results[0]);

        }

        return $results;

    }

    public function fornecedorList()
    {

        $sql = new Sql();
        return $resultado = $sql->select("SELECT * FROM fornecedor WHERE status = :STATUS", [
            ":STATUS" => 1
        ]);

    }

    public function insert()
    {

        $sql = new Sql();

        //  Pesquisa o fornecedor antes de cadastrá-lo
        $row = $sql->select("SELECT cod_fornecedor FROM fornecedor WHERE descr_fornecedor = :DESCR_FORNECEDOR OR email = :EMAIL", [
            ':DESCR_FORNECEDOR' => $this->getDescrFornecedor(),
            ':EMAIL' => $this->getEmail()
        ]);

        if (isset($row[0]['cod_fornecedor']))
        {

            echo '<script>swal("Erro!", "Fornecedor já cadastrado (código ' . $row[0]['cod_fornecedor'] . ').", "error");</script>';
            header("Refresh: 2, ../Produto/produtos.php");

        } else {

            // Realiza o cadastro, caso não encontre registro no banco

            //  Insere o novo endereço na tabela endereco, caso não exista

            $this->insertEndereco();

            //  Pesquisa a chave do endereço cadastrado

            $this->setCodEndereco($this->searchCodEndereco());

            // Insere os demais dados na tabela fornecedor

            $sql->query("INSERT INTO fornecedor VALUES (DEFAULT, :DESCR_FORNECEDOR, :COD_ENDERECO, :EMAIL, :TELEFONE, DEFAULT)", [
                ':DESCR_FORNECEDOR' => $this->getDescrFornecedor(),
                ':COD_ENDERECO' => $this->getCodEndereco(),
                ':EMAIL' => $this->getEmail(),
                ':TELEFONE' => $this->getTelefone()
            ]);

            echo '<script>swal("Feito!", "Fornecedor cadastrado.", "success");</script>';
            header("Refresh: 2, ../Produto/produtos.php");

        }

    }

    public function update($data)
    {

        $this->setData($data);

        $sql = new Sql();

        //  Pesquisa o fornecedor antes de alterá-lo
        $row = $sql->select("SELECT cod_fornecedor FROM fornecedor WHERE (descr_fornecedor = :DESCR_FORNECEDOR OR email = :EMAIL) AND cod_fornecedor <> :COD_FORNECEDOR", [
            ':DESCR_FORNECEDOR' => $this->getDescrFornecedor(),
            ':EMAIL' => $this->getEmail(),
            ':COD_FORNECEDOR' => $this->getCodFornecedor()
        ]);

        if (isset($row[0]['cod_fornecedor'])) {

            echo '<script>swal("Erro!", "Fornecedor já cadastrado. (Código ' . $row[0]['cod_fornecedor'] . ')", "error");</script>';
            header("Refresh: 2, ../Produto/produtos.php");

        } else {

            //  Insere o endereço alterado na tabela endereco, caso não exista

            $this->insertEndereco();

            //  Pesquisa e realiza o set da chave do endereço cadastrado

            $this->setCodEndereco($this->searchCodEndereco());

            // Realiza a alteração do cadastro, caso não encontre registro no banco
            $sql->query("UPDATE fornecedor SET descr_fornecedor = :DESCR_FORNECEDOR, cod_endereco = :COD_ENDERECO, email = :EMAIL, telefone = :TELEFONE, status = :STATUS WHERE cod_fornecedor = :COD_FORNECEDOR", [
                ':DESCR_FORNECEDOR' => $this->getDescrFornecedor(),
                ':COD_ENDERECO' => $this->getCodEndereco(),
                ':EMAIL' => $this->getEmail(),
                ':TELEFONE' => $this->getTelefone(),
                ':STATUS' => $this->getStatus(),
                ':COD_FORNECEDOR' => $this->getCodFornecedor()
            ]);

            echo '<script>swal("Feito!", "Cadastro de fornecedor alterado.", "success");</script>';
            header("Refresh: 2, ../Produto/produtos.php");
        }

    }

    public function delete()
    {

        $sql = new Sql();

        $sql->query("UPDATE fornecedor SET status = :STATUS WHERE cod_fornecedor = :COD_FORNECEDOR", [
            ':STATUS' => 0,
            ':COD_FORNECEDOR' => $this->getCodFornecedor()
        ]);

        echo '<script>swal("Feito!", "Fornecedor excluído.", "success");</script>';
        header("Refresh: 2, ../Produto/produtos.php");

    }

}