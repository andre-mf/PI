<?php

include_once('../config.php');

class Estoque extends Produto
{

    private $cod_produto;
    private $qtde;
    private $data_alteracao;

    // Getters e setters

    public function getCodProduto()
    {
        return $this->cod_produto;
    }

    public function setCodProduto($cod_produto)
    {
        $this->cod_produto = $cod_produto;
    }

    public function getQtde()
    {
        return $this->qtde;
    }

    public function setQtde($qtde)
    {
        $this->qtde = $qtde;
    }

    public function getDataAlteracao()
    {
        return $this->data_alteracao;
    }

    public function setDataAlteracao($data_alteracao)
    {
        $this->data_alteracao = $data_alteracao;
    }

    // Demais métodos

    public function setData($data)
    {

        $this->setCodProduto($data['cod_produto']);

        if (isset($data['descr_produto'])) {

            $this->setDescrProduto($data['descr_produto']);

        }

        if (isset($data['qtde'])) {

            $this->setQtde($data['qtde']);

        }

    }

    public function loadByCod($cod_produto)
    {

        $sql = new Sql();

        $results = $sql->select("SELECT cod_produto, descr_produto FROM produto LEFT JOIN estoque USING (cod_produto) WHERE cod_produto = :COD_PRODUTO", array(
            ":COD_PRODUTO" => $cod_produto
        ));

        if (isset($results[0])) {

            $this->setData($results[0]);

        }

        return $results;

    }

    public function produtoList()
    {

        // Lista os produtos com suas quantidades em estoque
        $sql = new Sql();
        return $resultado = $sql->select("SELECT cod_produto, descr_produto, descr_categoria, descr_area, sum(qtde) as qtde FROM produto JOIN area USING (cod_area) JOIN categoria USING (cod_categoria) LEFT JOIN estoque USING (cod_produto) WHERE produto.status = :STATUS GROUP BY cod_produto", [
            ":STATUS" => 1
        ]);

    }

    public function controlEstoque()
    {

        $sql = new Sql();

        // Insere o produto com sua quantidade na tabela
        return $sql->query("INSERT INTO estoque VALUES (:COD_PRODUTO, :TIPO, :QTDE, DEFAULT )", [
            ':COD_PRODUTO' => $this->getCodProduto(),
            ':TIPO' => ($this->getQtde() > 0 ? 'E' : 'S'),
            ':QTDE' => $this->getQtde(),
        ]);

    }

    public function moveEstoque($cod_produto)
    {

        // Método para listagem da movimentação de estoque
        $sql = new Sql();
        return $resultado = $sql->select("SELECT data_alteracao, tipo, cod_produto, descr_produto, qtde FROM estoque LEFT JOIN produto USING (cod_produto) WHERE cod_produto = :COD_PRODUTO", [
            ':COD_PRODUTO' => $cod_produto
        ]);

    }

}