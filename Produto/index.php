<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "pi";

if (isset($_GET['cod_categoria'])){

    $cod_categoria = $_GET['cod_categoria'];

}

// Criar a conexão
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

// Codificação UTF8
mysqli_set_charset($conn,"utf8");

// Define o número de itens por página
$itens_por_pagina = 9;

// Pegar a página atual
if (isset($_GET['pagina']))
{

    $pagina = intval($_GET['pagina']) * $itens_por_pagina;

} else {

    $pagina = 0;

}

// Numero total de registros
if (isset($cod_categoria))
{
    $query_produtos_cadastrados = "SELECT cod_produto, descr_produto from produto JOIN area a ON produto.cod_area = a.cod_area JOIN categoria c ON a.cod_categoria = c.cod_categoria JOIN fornecedor f ON produto.cod_fornecedor = f.cod_fornecedor WHERE produto.status = 1 AND a.status = 1 AND c.status = 1 AND f.status = 1 and c.cod_categoria = $cod_categoria";

} else {

    $query_produtos_cadastrados = "SELECT cod_produto, descr_produto from produto JOIN area a ON produto.cod_area = a.cod_area JOIN categoria c ON a.cod_categoria = c.cod_categoria JOIN fornecedor f ON produto.cod_fornecedor = f.cod_fornecedor WHERE produto.status = 1 AND a.status = 1 AND c.status = 1 AND f.status = 1";

}

$result_produtos_cadastrados = mysqli_query($conn, $query_produtos_cadastrados);

$num_total = mysqli_num_rows($result_produtos_cadastrados);

// Seleciona os produtos do banco
if (isset($cod_categoria)) {

    $query_produtos_cadastrados = "SELECT cod_produto, descr_produto, resumo, preco_custo, format(preco_venda,2,'de_DE') as preco_venda, descr_area, descr_categoria, descr_fornecedor FROM produto
    JOIN area a ON produto.cod_area = a.cod_area JOIN categoria c ON a.cod_categoria = c.cod_categoria JOIN fornecedor f ON produto.cod_fornecedor = f.cod_fornecedor WHERE produto.status = 1 AND a.status = 1 AND c.status = 1 AND f.status = 1 and c.cod_categoria = $cod_categoria ORDER BY descr_categoria, descr_area, descr_produto LIMIT $pagina, $itens_por_pagina";

} else {

    $query_produtos_cadastrados = "SELECT cod_produto, descr_produto, resumo, preco_custo, format(preco_venda,2,'de_DE') as preco_venda, descr_area, descr_categoria, descr_fornecedor FROM produto
JOIN area a ON produto.cod_area = a.cod_area JOIN categoria c ON a.cod_categoria = c.cod_categoria JOIN fornecedor f ON produto.cod_fornecedor = f.cod_fornecedor WHERE produto.status = 1 AND a.status = 1 AND c.status = 1 AND f.status = 1 ORDER BY descr_categoria, descr_area, descr_produto LIMIT $pagina, $itens_por_pagina";

}

$result_produtos_cadastrados = mysqli_query($conn, $query_produtos_cadastrados);
$num = mysqli_num_rows($result_produtos_cadastrados);

// Número total de páginas
$num_paginas = ceil($num_total / $itens_por_pagina);

// Nome do arquivo php
$arquivo = $_SERVER['PHP_SELF'];
include_once('../cabecalho.php');
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-lg-3">

            <h1 class="my-4">Categorias</h1>
            <div class="list-group">
                <?php
                $query_selec_categoria = "SELECT cod_categoria, descr_categoria FROM categoria WHERE status = 1 ORDER BY descr_categoria";
                $result_selec_categoria = mysqli_query($conn, $query_selec_categoria);
                while ($row_selec_categoria = mysqli_fetch_assoc($result_selec_categoria)) {
                    ?>
                    <a href="<?= $arquivo ?>?cod_categoria=<?= $row_selec_categoria['cod_categoria']?>" class="list-group-item"><?= $row_selec_categoria['descr_categoria'] ?></a>
                <?php } ?>
            </div>

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9 p-1">

            <div class="row">

                <?php
                if ($num > 0) {
                    while ($row_produtos_cadastrados = mysqli_fetch_array($result_produtos_cadastrados)) {
                        extract($row_produtos_cadastrados);
                        $img = $row_produtos_cadastrados['cod_produto'] . ".png";
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
<!--                                <a href="#"><img class="card-img-top" src="../imagens/produtos/--><?//= $img ?><!--" alt=""></a>-->
                                <a href="#"><img class="card-img-top" src="<?= (file_exists('../imagens/produtos/'.$img)?'../imagens/produtos/'.$img:'http://placehold.it/700x400?text=Sem+Imagem') ?>" alt=""></a>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= $descr_produto ?>
                                    </h5>
                                    <h5>R$ <?= $preco_venda; ?></h5>
                                    <p class="card-text">
                                        <strong>Categoria: </strong><?= $descr_categoria; ?><br>
                                        <strong>Área: </strong><?= $descr_area; ?><br>
                                        <strong>Fornecedor: </strong><?= $descr_fornecedor; ?><br>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <small><a href="#" style="text-decoration: none; font-size: 2em; color: gray"
                                              class=""><span class="fas fa-cart-arrow-down"></span></small>
                                    <a href="#"> Adicionar ao carrinho</a>
                                </div>
                            </div>
                        </div>
                    <?php }
                }
                ?>
            </div>
            <!-- /.row -->

            <!-- Paginação -->
            <div class="row justify-content-center">
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="<?= $arquivo ?>?pagina=0" tabindex="-1"><<</a>
                        </li>
                        <?php for ($i = 0; $i < $num_paginas; $i++) {
                            $estilo = "";
                            if ($pagina == $i * $itens_por_pagina) {
                                $estilo = "class=\"page-item active\"";
                            }
                            ?>
                            <li <?= $estilo; ?>><a class="page-link"
                                                          href="<?= $arquivo . '?pagina=' . $i . (isset($cod_categoria)?"&cod_categoria=$cod_categoria":'') ?>"><?= $i + 1; ?></a>
                            </li>
                        <?php } ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= $arquivo; ?>?pagina=<?= $num_paginas - 1 ?>">>></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Paginação -->
        </div>
        <!-- /.col-lg-9 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->

<!-- Footer -->
<?php
include_once('../rodape.php');
?>