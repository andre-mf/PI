<?php

class Produto
{

    private $cod_produto;
    private $descr_produto;
    private $cod_area;
    private $cod_fornecedor;
    private $resumo;
    private $preco_custo;
    private $preco_venda;
    private $status;

    // Getters e setters

    public function getCodProduto()
    {
        return $this->cod_produto;
    }

    public function setCodProduto($cod_produto)
    {
        $this->cod_produto = $cod_produto;
    }

    public function getDescrProduto()
    {
        return $this->descr_produto;
    }

    public function setDescrProduto($descr_produto)
    {
        $this->descr_produto = $descr_produto;
    }

    public function getCodArea()
    {
        return $this->cod_area;
    }

    public function setCodArea($cod_area)
    {
        $this->cod_area = $cod_area;
    }

    public function getCodFornecedor()
    {
        return $this->cod_fornecedor;
    }

    public function setCodFornecedor($cod_fornecedor)
    {
        $this->cod_fornecedor = $cod_fornecedor;
    }

    public function getResumo()
    {
        return $this->resumo;
    }

    public function setResumo($resumo)
    {
        $this->resumo = $resumo;
    }

    public function getPrecoCusto()
    {
        return $this->preco_custo;
    }

    public function setPrecoCusto($preco_custo)
    {
        $this->preco_custo = $preco_custo;
    }

    public function getPrecoVenda()
    {
        return $this->preco_venda;
    }

    public function setPrecoVenda($preco_venda)
    {
        $this->preco_venda = $preco_venda;
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

        $this->setCodProduto($data['cod_produto']);
        $this->setDescrProduto($data['descr_produto']);
        $this->setCodArea($data['cod_area']);
        $this->setCodFornecedor($data['cod_fornecedor']);
        $this->setResumo($data['resumo']);
        $this->setPrecoCusto(str_replace(',', '.', str_replace('.', '', $data['preco_custo'])));
        $this->setPrecoVenda(str_replace(',', '.', str_replace('.', '', $data['preco_venda'])));
        $this->setStatus($data['status']);

    }

    public function loadByCod($cod_produto)
    {

        $sql = new Sql();

        $results = $sql->select("SELECT cod_produto, descr_produto, cod_area, cod_fornecedor, resumo, format(preco_custo,2,'de_DE') as preco_custo, format(preco_venda,2,'de_DE') as preco_venda, status FROM produto WHERE cod_produto = :COD_PRODUTO", array(
            ":COD_PRODUTO" => $cod_produto
        ));

        if (isset($results[0])) {

            $this->setData($results[0]);

        }

        return $results;

    }

    public function produtoList()
    {

        $sql = new Sql();
        return $resultado = $sql->select("SELECT cod_produto, descr_produto, descr_categoria, descr_area, descr_fornecedor, format(preco_custo,2,'de_DE') as preco_custo, format(preco_venda,2,'de_DE') as preco_venda FROM produto JOIN area a ON produto.cod_area = a.cod_area JOIN fornecedor f ON produto.cod_fornecedor = f.cod_fornecedor JOIN categoria c ON a.cod_categoria = c.cod_categoria WHERE produto.status = :STATUS", [
            ":STATUS" => 1
        ]);

    }

    public function insertProduto($arquivoUp)
    {

        $sql = new Sql();

        //  Pesquisa o produto antes de cadastrá-lo
        $row = $sql->select("SELECT cod_produto FROM produto WHERE descr_produto = :DESCR_PRODUTO AND cod_fornecedor = :COD_FORNECEDOR", [
            ':DESCR_PRODUTO' => $this->getDescrProduto(),
            ':COD_FORNECEDOR' => $this->getCodFornecedor()
        ]);

        if (isset($row[0]['cod_produto'])) {

            echo '<script>swal("Ops!", "Produto já cadastrado (código ' . $row[0]['cod_produto'] . ').", "error");</script>';
            header("Refresh: 2, produtos.php");

        } else {

            // Realiza o cadastro, caso não encontre registro no banco
            $sql->query("INSERT INTO produto VALUES (DEFAULT,:DESCR_PRODUTO, :COD_AREA, :COD_FORNECEDOR, :RESUMO, :PRECO_CUSTO, :PRECO_VENDA, DEFAULT)", [
                ':DESCR_PRODUTO' => $this->getDescrProduto(),
                ':COD_AREA' => $this->getCodArea(),
                ':COD_FORNECEDOR' => $this->getCodFornecedor(),
                ':RESUMO' => $this->getResumo(),
                ':PRECO_CUSTO' => $this->getPrecoCusto(),
                ':PRECO_VENDA' => $this->getPrecoVenda()
            ]);

            //Upload da imagem

            $arquivo = $arquivoUp;

            $row = $sql->select("SELECT cod_produto FROM produto WHERE descr_produto = :DESCR_PRODUTO AND cod_fornecedor = :COD_FORNECEDOR", [
                ':DESCR_PRODUTO' => $this->getDescrProduto(),
                ':COD_FORNECEDOR' => $this->getCodFornecedor()
            ]);

            $codProduto = $row[0]['cod_produto'];
            $pasta = "../imagens/produtos";
            $extensao = strtolower(pathinfo($pasta . basename($arquivoUp["name"]), PATHINFO_EXTENSION));
            $arquivoDestino = $pasta . DIRECTORY_SEPARATOR . $codProduto . '.' . $extensao;
            $uploadOk = 1;
            $tipoImagem = strtolower(pathinfo($arquivoDestino, PATHINFO_EXTENSION));
            // Verifica se o arquivo é uma imagem
            $check = getimagesize($arquivoUp["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
            // Verifica se o arquivo já existe
            if (file_exists($arquivoDestino)) {
                $uploadOk = 0;
            }
            // Verifica o tamanho do arquivo
            if ($arquivoUp["size"] > 5000000) {
                $uploadOk = 0;
            }
            // Verifica os formatos de imagem
            if ($tipoImagem != "jpg" && $tipoImagem != "png" && $tipoImagem != "jpeg"
                && $tipoImagem != "gif") {
                $uploadOk = 0;
            }
            // Verifica se $uploadOk está setado como 0 por motivo de erro
            if ($uploadOk == 1) {
                move_uploaded_file($arquivoUp["tmp_name"], $arquivoDestino);
            }

            echo '<script>swal("Feito!", "Produto cadastrado.", "success");</script>';
            header("Refresh: 2, produtos.php");

        }

    }

    public function updateProduto($data, $arquivoUp)
    {

        $this->setData($data);

        $sql = new Sql();

        //  Pesquisa o produto antes de alterá-lo
        $row = $sql->select("SELECT cod_produto FROM produto WHERE descr_produto = :DESCR_PRODUTO AND cod_produto <> :COD_PRODUTO", [
            ':COD_PRODUTO' => $this->getCodProduto(),
            ':DESCR_PRODUTO' => $this->getDescrProduto()
        ]);

        if (isset($row[0]['cod_produto'])) {

            echo '<script>swal("Ops!", "Produto já cadastrado (código ' . $row[0]['cod_produto'] . ').", "error");</script>';
            header("Refresh: 2, produtos.php");

        } else {

            // Realiza a alteração do cadastro, caso não encontre registro no banco
            $sql->query("UPDATE produto SET descr_produto = :DESCR_PRODUTO, cod_area = :COD_AREA, cod_fornecedor = :COD_FORNECEDOR, resumo = :RESUMO, preco_custo = :PRECO_CUSTO, preco_venda = :PRECO_VENDA, status = :STATUS WHERE cod_produto = :COD_PRODUTO", [
                ':COD_PRODUTO' => $this->getCodProduto(),
                ':DESCR_PRODUTO' => $this->getDescrProduto(),
                ':COD_FORNECEDOR' => $this->getCodFornecedor(),
                ':COD_AREA' => $this->getCodArea(),
                ':RESUMO' => $this->getResumo(),
                ':PRECO_CUSTO' => $this->getPrecoCusto(),
                ':PRECO_VENDA' => $this->getPrecoVenda(),
                ':STATUS' => $this->getStatus()
            ]);

            //Upload da imagem

            $arquivo = $arquivoUp;

            $row = $sql->select("SELECT cod_produto FROM produto WHERE descr_produto = :DESCR_PRODUTO AND cod_fornecedor = :COD_FORNECEDOR", [
                ':DESCR_PRODUTO' => $this->getDescrProduto(),
                ':COD_FORNECEDOR' => $this->getCodFornecedor()
            ]);

            $codProduto = $row[0]['cod_produto'];
            $pasta = "../imagens/produtos";
            $extensao = strtolower(pathinfo($pasta . basename($arquivoUp["name"]), PATHINFO_EXTENSION));
            $arquivoDestino = $pasta . DIRECTORY_SEPARATOR . $codProduto . '.' . $extensao;
            $uploadOk = 1;
            $tipoImagem = strtolower(pathinfo($arquivoDestino, PATHINFO_EXTENSION));
            // Verifica se o arquivo é uma imagem
            $check = getimagesize($arquivoUp["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
            // Verifica o tamanho do arquivo
            if ($arquivoUp["size"] > 5000000) {
                $uploadOk = 0;
            }
            // Verifica os formatos de imagem
            if ($tipoImagem != "jpg" && $tipoImagem != "png" && $tipoImagem != "jpeg"
                && $tipoImagem != "gif") {
                $uploadOk = 0;
            }
            // Verifica se $uploadOk está setado como 0 por motivo de erro
            if ($uploadOk == 1) {
                move_uploaded_file($arquivoUp["tmp_name"], $arquivoDestino);
            }

            echo '<script>swal("Feito!", "Cadastro de produto alterado.", "success");</script>';
            header("Refresh: 2, produtos.php");
        }

    }

    public function deleteProduto()
    {

        $sql = new Sql();

        $sql->query("UPDATE produto SET status = :STATUS WHERE cod_produto = :COD_PRODUTO", [
            ':STATUS' => 0,
            ':COD_PRODUTO' => $this->getCodProduto()
        ]);

        // Exclui a imagem do produto
        if (file_exists('../imagens/produtos/'.$this->getCodProduto().'.png'))
        {

            unlink('../imagens/produtos/'.$this->getCodProduto().'.png');

        }

        echo '<script>swal("Feito!", "Produto excluído.", "success");</script>';
        header("Refresh: 2, produtos.php");

    }

}