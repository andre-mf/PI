<?php

class Endereco{

    private $cod_endereco;
    private $cep;
    private $numero;
    private $logradouro;
    private $bairro;
    private $localidade;
    private $uf;

    // Getters e setters

    public function getCodEndereco()
    {
        return $this->cod_endereco;
    }

    public function setCodEndereco($cod_endereco)
    {
        $this->cod_endereco = $cod_endereco;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getLogradouro()
    {
        return $this->logradouro;
    }

    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function getLocalidade()
    {
        return $this->localidade;
    }

    public function setLocalidade($localidade)
    {
        $this->localidade = $localidade;
    }

    public function getUf()
    {
        return $this->uf;
    }

    public function setUf($uf)
    {
        $this->uf = $uf;
    }

    // Demais métodos

    public function searchCodEndereco()
    {

        $sql = new Sql();

        $row = $sql->select("SELECT cod_endereco FROM endereco WHERE logradouro = :LOGRADOURO AND localidade = :LOCALIDADE", [
            ':LOGRADOURO' => $this->getLogradouro(),
            ':LOCALIDADE' => $this->getLocalidade()
        ]);

        return $row[0]['cod_endereco'];

    }

    public function insertEndereco()
    {

        $sql = new Sql();

        //  Insere o novo endereço na tabela endereco, caso não exista

        $row = $sql->select("SELECT cod_endereco FROM endereco WHERE logradouro = :LOGRADOURO AND localidade = :LOCALIDADE", [
            ':LOGRADOURO' => $this->getLogradouro(),
            ':LOCALIDADE' => $this->getLocalidade()
        ]);

        if (!isset($row[0]['cod_endereco']))
        {

            return $sql->query("INSERT INTO endereco VALUES (DEFAULT, :CEP, :LOGRADOURO, :BAIRRO, :LOCALIDADE, :UF)", [
                ':CEP' => $this->getCep(),
                ':LOGRADOURO' => $this->getLogradouro(),
                ':BAIRRO' => $this->getBairro(),
                ':LOCALIDADE' => $this->getLocalidade(),
                ':UF' => $this->getUf()
            ]);

        }
    }
}