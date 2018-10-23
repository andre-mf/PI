<?php

include_once('../config.php');

class Cliente extends Endereco
{

    private $cod_cliente;
    private $nome;
    private $data_nascimento;
    private $sexo;
    private $cpf;
    private $cod_endereco;
    private $email;
    private $telefone;
    private $data_cadastro;
    private $status;

    // Getters e setters

    public function getCodCliente()
    {
        return $this->cod_cliente;
    }

    public function setCodCliente($cod_cliente)
    {
        $this->cod_cliente = $cod_cliente;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getDataNascimento()
    {
        return $this->data_nascimento;
    }

    public function setDataNascimento($data_nascimento)
    {
        $this->data_nascimento = $data_nascimento;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param mixed $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
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

    public function getDataCadastro()
    {
        return $this->data_cadastro;
    }

    public function setDataCadastro($data_cadastro)
    {
        $this->data_cadastro = $data_cadastro;
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

        $this->setCodCliente($data['cod_cliente']);
        $this->setNome($data['nome']);
        $this->setDataNascimento($data['data_nascimento']);
        $this->setSexo($data['sexo']);
        $this->setCpf($data['cpf']);
        $this->setEmail($data['email']);
        $this->setTelefone($data['telefone']);
        $this->setDataCadastro($data['data_cadastro']);
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

    public function loadByCod($cod_cliente)
    {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM cliente JOIN endereco USING (cod_endereco) WHERE cod_cliente = :COD_CLIENTE", array(
            ":COD_CLIENTE" => $cod_cliente
        ));

        if (isset($results[0])) {

            $this->setData($results[0]);

        }

        return $results;

    }

    public function clienteList()
    {

        $sql = new Sql();
        return $resultado = $sql->select("SELECT * FROM cliente WHERE status = :STATUS", [
            ":STATUS" => 1
        ]);

    }

    public function insert()
    {

        $sql = new Sql();

        //  Pesquisa o cliente antes de cadastrá-lo

        $row = $sql->select("SELECT cod_cliente FROM cliente WHERE email = :EMAIL OR cpf = :CPF", [
            ':EMAIL' => $this->getEmail(),
            ':CPF' => $this->getCpf()
        ]);

        if (isset($row[0]['cod_cliente'])) {

            echo '<script>swal("Erro!", "Cliente já cadastrado (código ' . $row[0]['cod_cliente'] . ').", "error");</script>';
            header("Refresh: 2, ../Cliente/index.php");

        } else {

            // Realiza o cadastro, caso não encontre registro no banco

            //  Insere o novo endereço na tabela endereco, caso não exista

            $this->insertEndereco();

            //  Pesquisa a chave do endereço cadastrado

            $this->setCodEndereco($this->searchCodEndereco());

            // Insere os demais dados na tabela cliente

            $sql->query("INSERT INTO cliente VALUES (DEFAULT, :NOME, :DATA_NASCIMENTO, :SEXO, :CPF, :COD_ENDERECO, :EMAIL, :TELEFONE, DEFAULT, DEFAULT)", [
                ':NOME' => $this->getNome(),
                ':DATA_NASCIMENTO' => $this->getDataNascimento(),
                ':SEXO' => $this->getSexo(),
                ':CPF' => $this->getCpf(),
                ':COD_ENDERECO' => $this->getCodEndereco(),
                ':EMAIL' => $this->getEmail(),
                ':TELEFONE' => $this->getTelefone()
            ]);

            echo '<script>swal("Feito!", "Cliente cadastrado.", "success");</script>';
            header("Refresh: 2, ../Cliente/index.php");

        }
    }


    public function update($data)
    {

        $this->setData($data);

        $sql = new Sql();

        //  Pesquisa o cliente antes de alterá-lo
        $row = $sql->select("SELECT cod_cliente FROM cliente WHERE (email = :EMAIL OR cpf = :CPF) AND cod_cliente <> :COD_CLIENTE", [
            ':EMAIL' => $this->getEmail(),
            ':CPF' => $this->getCpf(),
            ':COD_CLIENTE' => $this->getCodCliente()
        ]);

        if (isset($row[0]['cod_cliente']))
        {

            echo '<script>swal("Erro!", "Cliente já cadastrado. (Código ' . $row[0]['cod_cliente'] . ')", "error");</script>';
            header("Refresh: 2, ../Cliente/index.php");

        } else {

            //  Insere o endereço alterado na tabela endereco, caso não exista

            $this->insertEndereco();

            //  Pesquisa e realiza o set da chave do endereço cadastrado

            $this->setCodEndereco($this->searchCodEndereco());

            // Realiza a alteração do cadastro, caso não encontre registro no banco
            $sql->query("UPDATE cliente SET nome = :NOME, data_nascimento = :DATA_NASCIMENTO, sexo = :SEXO, cpf = :CPF, cod_endereco = :COD_ENDERECO, email = :EMAIL, telefone = :TELEFONE, data_cadastro = :DATA_CADASTRO, status = :STATUS WHERE cod_cliente = :COD_CLIENTE", [
                ':COD_CLIENTE' => $this->getCodCliente(),
                ':NOME' => $this->getNome(),
                ':DATA_NASCIMENTO' => $this->getDataNascimento(),
                ':SEXO' => $this->getSexo(),
                ':CPF' => $this->getCpf(),
                ':COD_ENDERECO' => $this->getCodEndereco(),
                ':EMAIL' => $this->getEmail(),
                ':TELEFONE' => $this->getTelefone(),
                ':DATA_CADASTRO' => $this->getDataCadastro(),
                ':STATUS' => $this->getStatus()
            ]);

            echo '<script>swal("Feito!", "Cadastro de cliente alterado.", "success");</script>';
            header("Refresh: 2, ../Cliente/index.php");

        }
    }

    public function delete()
    {

        $sql = new Sql();

        $sql->query("UPDATE cliente SET status = :STATUS, data_cadastro = :DATA_CADASTRO WHERE cod_cliente = :COD_CLIENTE", [
            ':STATUS' => 0,
            ':DATA_CADASTRO' => $this->getDataCadastro(),
            ':COD_CLIENTE' => $this->getCodCliente()
        ]);

        echo '<script>swal("Feito!", "Cliente excluído.", "success");</script>';
        header("Refresh: 2, ../Cliente/index.php");

    }

}