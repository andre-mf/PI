<?php
require_once('cabecalho.php');
?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-lg-12">
            <div>
                <h1 class="p-2">Cadastro - Produtos</h1>
                <p class="lead">Área destinada a cadastro das tabelas de produtos</p>
            </div>

            <!-- Criação das abas -->
            <ul class="nav nav-tabs" id="abas-cadastro-produtos" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="produtos-tab" data-toggle="tab" href="#produtos" role="tab"
                       aria-controls="produtos"
                       aria-selected="true">Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="categorias-tab" data-toggle="tab" href="#categorias" role="tab"
                       aria-controls="produtos" aria-selected="false">Categorias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="areas-tab" data-toggle="tab" href="#areas" role="tab"
                       aria-controls="produtos"
                       aria-selected="false">Áreas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="fornecedores-tab" data-toggle="tab" href="#fornecedores" role="tab"
                       aria-controls="produtos" aria-selected="false">Fornecedores</a>
                </li>
            </ul>

            <!-- Conteúdo das abas -->
            <div class="tab-content" id="myTabContent">

                <!-- Aba produtos -->
                <div class="tab-pane fade show active" id="produtos" role="tabpanel" aria-labelledby="produtos-tab">
                    <br>
                    <h4>Produtos</h4>
                    <br>
                    <table class="table table-striped table-hover" id="produtos_cadastrados" cellspacing="0"
                           width="100%">
                        <thead>
                        <th>Cód. do produto</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Área</th>
                        <th>Fornecedor</th>
                        <th>Preço de custo</th>
                        <th>Preço de venda</th>
                        <th>Ações</th>
                        </thead>
                        <?php
                        $query_produtos_cadastrados = "SELECT cod_produto, descr_produto, descr_categoria, descr_area, descr_fornecedor, format(preco_custo,2,'de_DE') as preco_custo, format(preco_venda,2,'de_DE') as preco_venda FROM produto JOIN area a ON produto.cod_area = a.cod_area JOIN fornecedor f ON produto.cod_fornecedor = f.cod_fornecedor JOIN categoria c ON a.cod_categoria = c.cod_categoria WHERE produto.status = 1";
                        $result_produtos_cadastrados = mysqli_query($conn, $query_produtos_cadastrados);
                        while ($row_produtos_cadastrados = mysqli_fetch_array($result_produtos_cadastrados)) { ?>
                            <tr>
                                <td><?php echo $row_produtos_cadastrados['cod_produto'] ?></td>
                                <td><?php echo $row_produtos_cadastrados['descr_produto'] ?></td>
                                <td><?php echo $row_produtos_cadastrados['descr_categoria'] ?></td>
                                <td><?php echo $row_produtos_cadastrados['descr_area'] ?></td>
                                <td><?php echo $row_produtos_cadastrados['descr_fornecedor'] ?></td>
                                <td><?php echo $row_produtos_cadastrados['preco_custo'] ?></td>
                                <td><?php echo $row_produtos_cadastrados['preco_venda'] ?></td>
                                <td>
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                        <div class="btn-toolbar">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#alterar_produto"
                                                        data-cod_produto="<?php echo $row_produtos_cadastrados['cod_produto'] ?>"
                                                        data-descr_produto='<?php echo $row_produtos_cadastrados['descr_produto'] ?>'
                                                        data-descr_categoria="<?php echo $row_produtos_cadastrados['descr_categoria'] ?>"
                                                        data-descr_area="<?php echo $row_produtos_cadastrados['descr_area'] ?>"
                                                        data-descr_fornecedor="<?php echo $row_produtos_cadastrados['descr_fornecedor'] ?>"
                                                        data-preco_custo="<?php echo $row_produtos_cadastrados['preco_custo'] ?>"
                                                        data-preco_venda="<?php echo $row_produtos_cadastrados['preco_venda'] ?>">
                                                    Editar <span class="fas fa-pencil-alt"></span>
                                                </button>
                                                <button class="btn btn-danger" name="desativa_produto"
                                                        value="<?php echo $row_produtos_cadastrados['cod_produto'] ?>">
                                                    Excluir <span class="fas fa-trash-alt"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                        // Desativa o produto no banco
                        if (isset($_POST['desativa_produto'])) {
                            $cod_produto_desativar = $_POST['desativa_produto'];
                            $query_desativar_produtos = "UPDATE produto SET status = 0 WHERE cod_produto = $cod_produto_desativar";
                            $result_desativar_produtos = mysqli_query($conn, $query_desativar_produtos);
                            echo '<script>swal("Feito!", "Produto excluído.", "success");</script>';
                            echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                        }
                        ?>
                    </table>
                    <br>
                    <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#cadastrar_produto">
                        Cadastrar <span class="fa fa-edit""></span>
                    </button>

                    <!--  modal para cadastrar produtos  -->
                    <!--  Janela  -->
                    <div class="modal fade" id="cadastrar_produto">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <!-- cabeçalho -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Cadastrar produtos</h4>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <!-- corpo -->
                                <div class="modal-body">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"
                                          enctype="multipart/form-data" onsubmit="return valida_produto();">
                                        <div class="form-group row">
                                            <label for="descr_produto" class="col-3 col-form-label">Descrição do
                                                Produto</label>
                                            <div class="col-9">
                                                <input class="form-control" type="text" name="descr_produto"
                                                       id="descr_produto" autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="selec_cod_categoria"
                                                   class="col-3 col-form-label">Categoria</label>
                                            <div class="col-9">
                                                <select class="form-control" name="selec_cod_categoria"
                                                        id="selec_cod_categoria" required>
                                                    <option value="">--</option>
                                                    <?php
                                                    $query_selec_categoria = "SELECT * FROM categoria WHERE status = 1 ORDER BY descr_categoria";
                                                    $result_selec_categoria = mysqli_query($conn, $query_selec_categoria);
                                                    while ($row_selec_categoria = mysqli_fetch_array($result_selec_categoria)) {
                                                        echo '<option value="' . $row_selec_categoria['cod_categoria'] . '">' . $row_selec_categoria['descr_categoria'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cod_area" class="col-3 col-form-label">Área</label>
                                            <div class="col-9">
                                                <script type="text/javascript">
                                                    $(document).ready(function () {
                                                        $('#selec_cod_categoria').change(function () {
                                                            $('#cod_area').load('preenche_combos.php?selec_cod_categoria=' + $('#selec_cod_categoria').val());
                                                        });
                                                    });
                                                </script>
                                                <select class="form-control" name="cod_area" id="cod_area" required>
                                                    <option value="0">Escolha uma categoria</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="selec_cod_fornecedor"
                                                   class="col-3 col-form-label">Fornecedor</label>
                                            <div class="col-9">
                                                <select class="form-control" name="selec_cod_fornecedor"
                                                        id="selec_cod_fornecedor" required>
                                                    <option value="">--</option>
                                                    <?php
                                                    $query_selec_fornecedor = "SELECT * FROM fornecedor WHERE status = 1 ORDER BY descr_fornecedor";
                                                    $result_selec_fornecedor = mysqli_query($conn, $query_selec_fornecedor);
                                                    while ($row_selec_fornecedor = mysqli_fetch_array($result_selec_fornecedor)) {
                                                        echo '<option value="' . $row_selec_fornecedor['cod_fornecedor'] . '">' . $row_selec_fornecedor['descr_fornecedor'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="preco_custo" class="col-3 col-form-label">Preço de Custo</label>
                                            <div class="col-9">
                                                <input class="form-control" type="text" name="preco_custo"
                                                       id="preco_custo" autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="preco_venda" class="col-3 col-form-label">Preço de Venda</label>
                                            <div class="col-9">
                                                <input class="form-control" type="text" name="preco_venda"
                                                       id="preco_venda" autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="arquivo_upload" class="col-3 col-form-label">Imagem do
                                                produto</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-file" type="file"
                                                       name="arquivo_upload"
                                                       id="arquivo_upload" autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="resumo" class="col-3 col-form-label">Resumo</label>
                                            <div class="col-9">
                                                <textarea class="form-control" name="resumo" id="resumo"></textarea>
                                            </div>
                                        </div>
                                        <div class="btn-toolbar">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-success" name="submit_produto">
                                                    Cadastrar <span class="fa fa-edit"></span>
                                                </button>

                                                <button type="reset" class="btn btn-danger">
                                                    Limpar <span class="fa fa-eraser"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_POST['submit_produto'])) {
                                            $descr_produto = $_POST['descr_produto'];
                                            $cod_area = $_POST['cod_area'];
                                            $cod_fornecedor = $_POST['selec_cod_fornecedor'];
                                            $preco_custo = str_replace(',', '.', str_replace('.', '', $_POST['preco_custo']));
                                            $preco_venda = str_replace(',', '.', str_replace('.', '', $_POST['preco_venda']));
                                            $resumo = $_POST['resumo'];

                                            //  Pesquisa o produto antes de cadastrá-lo
                                            $query_cod_produto = "SELECT cod_produto FROM produto WHERE descr_produto = '$descr_produto' AND cod_fornecedor = '$cod_fornecedor'";
                                            $result_cod_produto = mysqli_query($conn, $query_cod_produto);
                                            $row_cod_produto = mysqli_fetch_array($result_cod_produto);
                                            if ($row_cod_produto['cod_produto'] == '') {
                                                // Realiza o cadastro, caso não encontre registro no banco
                                                $query_produto = "INSERT INTO produto VALUES (DEFAULT ,'$descr_produto','$cod_area','$cod_fornecedor','$resumo','$preco_custo','$preco_venda',1)";
                                                $result_produto = mysqli_query($conn, $query_produto);
                                                //Upload da imagem
                                                $query_cod_produto = "SELECT cod_produto FROM produto WHERE descr_produto = '$descr_produto' AND cod_fornecedor = '$cod_fornecedor'";
                                                $result_cod_produto = mysqli_query($conn, $query_cod_produto);
                                                $row_cod_produto = mysqli_fetch_array($result_cod_produto);
                                                $pasta = "imagens/produtos/";
                                                $extensao = strtolower(end(explode('.', $_FILES['arquivo_upload']['name'])));
                                                $arquivo_destino = $pasta . $row_cod_produto['cod_produto'] . "." . $extensao;
                                                $uploadOk = 1;
                                                $tipo_imagem = strtolower(pathinfo($arquivo_destino, PATHINFO_EXTENSION));
                                                // Verifica se o arquivo é uma imagem
                                                if (isset($_POST["submit_produto"])) {
                                                    $check = getimagesize($_FILES["arquivo_upload"]["tmp_name"]);
                                                    if ($check !== false) {
                                                        $uploadOk = 1;
                                                    } else {
                                                        $uploadOk = 0;
                                                    }
                                                }
                                                // Verifica se o arquivo já existe
                                                if (file_exists($arquivo_destino)) {
                                                    $uploadOk = 0;
                                                }
                                                // Verifica o tamanho do arquivo
                                                if ($_FILES["arquivo_upload"]["size"] > 5000000) {
                                                    $uploadOk = 0;
                                                }
                                                // Verifica os formatos de imagem
                                                if ($tipo_imagem != "jpg" && $tipo_imagem != "png" && $tipo_imagem != "jpeg"
                                                    && $tipo_imagem != "gif") {
                                                    $uploadOk = 0;
                                                }
                                                // Verifica se $uploadOk está setado como 0 por motivo de erro
                                                if ($uploadOk == 1) {
                                                    move_uploaded_file($_FILES["arquivo_upload"]["tmp_name"], $arquivo_destino);
                                                }
                                                echo '<script>swal("Feito!", "Produto cadastrado.", "success");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            } else {
                                                // Emite mensagem de erro caso o produto já esteja cadastrado
                                                echo '<script>swal("Erro!", "Produto já cadastrado (código ' . $row_cod_produto['cod_produto'] . ').", "error");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            }
                                        }
                                        ?>
                                    </form>
                                </div>

                                <!-- rodapé -->
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- fim da modal para cadastrar produtos -->

                    <!--  modal para alterar o cadastro de produtos  -->

                    <!--  Janela  -->
                    <div class="modal fade" id="alterar_produto" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <!-- cabeçalho -->
                                <div class="modal-header">
                                    <h4 class="modal-title" id="titulo_modal"></h4>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <!-- corpo -->
                                <div class="modal-body">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"
                                          enctype="multipart/form-data">
                                        <input type="hidden" name="altprod_cod_produto" id="altprod_cod_produto">
                                        <div class="form-group row">
                                            <label for="altprod_descr_produto" class="col-4 col-form-label">Descrição do
                                                Produto</label>
                                            <div class="col-8">
                                                <input class="form-control" type="text" name="altprod_descr_produto"
                                                       id="altprod_descr_produto" autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label" for="altprod_selec_cod_categoria"
                                                   id="altprod_categoria_atual"></label>
                                            <div class="col-8">
                                                <select class="form-control" name="altprod_selec_cod_categoria"
                                                        id="altprod_selec_cod_categoria" required>
                                                    <option value="">--</option>
                                                    <?php
                                                    $query_selec_categoria = "SELECT * FROM categoria WHERE status = 1 ORDER BY descr_categoria";
                                                    $result_selec_categoria = mysqli_query($conn, $query_selec_categoria);
                                                    while ($row_selec_categoria = mysqli_fetch_array($result_selec_categoria)) {
                                                        echo '<option value="' . $row_selec_categoria['cod_categoria'] . '">' . $row_selec_categoria['descr_categoria'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label" for="altprod_selec_cod_area"
                                                   id="altprod_area_atual"></label>
                                            <div class="col-8">
                                                <script type="text/javascript">
                                                    $(document).ready(function () {
                                                        $('#altprod_selec_cod_categoria').change(function () {
                                                            $('#altprod_cod_area').load('preenche_combos.php?selec_cod_categoria=' + $('#altprod_selec_cod_categoria').val());
                                                        });
                                                    });
                                                </script>
                                                <select class="form-control" name="altprod_cod_area"
                                                        id="altprod_cod_area" required>
                                                    <option value="0">Escolha uma categoria</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label" for="altprod_selec_cod_fornecedor"
                                                   id="altprod_fornecedor_atual"></label>
                                            <div class="col-8">
                                                <select class="form-control" name="altprod_selec_cod_fornecedor"
                                                        id="altprod_selec_cod_fornecedor" required>
                                                    <option value="">--</option>
                                                    <?php
                                                    $query_selec_fornecedor = "SELECT * FROM fornecedor WHERE status = 1 ORDER BY descr_fornecedor";
                                                    $result_selec_fornecedor = mysqli_query($conn, $query_selec_fornecedor);
                                                    while ($row_selec_fornecedor = mysqli_fetch_array($result_selec_fornecedor)) {
                                                        echo '<option value="' . $row_selec_fornecedor['cod_fornecedor'] . '">' . $row_selec_fornecedor['descr_fornecedor'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="altprod_preco_custo" class="col-4 col-form-label">Preço de
                                                Custo</label>
                                            <div class="col-8">
                                                <input class="form-control" type="text" name="altprod_preco_custo"
                                                       id="altprod_preco_custo" autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="altprod_preco_venda" class="col-4 col-form-label">Preço de
                                                Venda</label>
                                            <div class="col-8">
                                                <input class="form-control" type="text" name="altprod_preco_venda"
                                                       id="altprod_preco_venda" autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="altprod_arquivo_upload" class="col-4 col-form-label">Imagem do
                                                produto</label>
                                            <div class="col-8">
                                                <input class="form-control form-control-file" type="file"
                                                       name="altprod_arquivo_upload"
                                                       id="altprod_arquivo_upload" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="altprod_resumo" class="col-4 col-form-label">Resumo</label>
                                            <div class="col-8">
                                                <textarea class="form-control" name="altprod_resumo"
                                                          id="altprod_resumo"></textarea>
                                            </div>
                                        </div>
                                        <div class="btn-toolbar">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-primary"
                                                        name="altprod_submit_produto">
                                                    Alterar <span class="fas fa-pencil-alt"></span>
                                                </button>

                                                <button type="reset" class="btn btn-danger">
                                                    Limpar <span class="fa fa-eraser"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_POST['altprod_submit_produto'])) {
                                            $cod_produto = $_POST['altprod_cod_produto'];
                                            $descr_produto = $_POST['altprod_descr_produto'];
                                            $cod_area = $_POST['altprod_cod_area'];
                                            $cod_fornecedor = $_POST['altprod_selec_cod_fornecedor'];
                                            $preco_custo = str_replace(',', '.', str_replace('.', '', $_POST['altprod_preco_custo']));
                                            $preco_venda = str_replace(',', '.', str_replace('.', '', $_POST['altprod_preco_venda']));
                                            $resumo = $_POST['altprod_resumo'];

                                            //  Pesquisa o produto antes de alterá-lo
                                            $query_produto = "SELECT cod_produto FROM produto WHERE descr_produto = '$descr_produto' AND cod_produto <> '$cod_produto'";
                                            $result_produto = mysqli_query($conn, $query_produto);
                                            $numrow_produto = mysqli_num_rows($result_produto);
                                            if ($numrow_produto == 0) {
                                                // Realiza a alteração do cadastro, caso não encontre registro no banco
                                                $query_alt_produto = "UPDATE produto SET descr_produto = '$descr_produto', cod_area = '$cod_area', cod_fornecedor = '$cod_fornecedor', resumo = '$resumo', preco_custo = '$preco_custo', preco_venda = '$preco_venda' WHERE cod_produto = '$cod_produto'";
                                                $result_alt_produto = mysqli_query($conn, $query_alt_produto);
                                                //Upload da imagem
                                                $pasta = "imagens/produtos/";
                                                $extensao = strtolower(end(explode('.', $_FILES['altprod_arquivo_upload']['name'])));
                                                $arquivo_destino = $pasta . $cod_produto . "." . $extensao;
                                                $uploadOk = 1;
                                                $tipo_imagem = strtolower(pathinfo($arquivo_destino, PATHINFO_EXTENSION));
                                                // Verifica se o arquivo é uma imagem
                                                if (isset($_POST["altprod_submit_produto"])) {
                                                    if ($_FILES['altprod_arquivo_upload']['name'] != '') {
                                                        $check = getimagesize($_FILES["altprod_arquivo_upload"]["tmp_name"]);
                                                        if ($check !== false) {
                                                            $uploadOk = 1;
                                                        } else {
                                                            $uploadOk = 0;
                                                        }
                                                        // Verifica o tamanho do arquivo
                                                        if ($_FILES["arquivo_upload"]["size"] > 5000000) {
                                                            $uploadOk = 0;
                                                        }
                                                        // Verifica os formatos de imagem
                                                        if ($tipo_imagem != "jpg" && $tipo_imagem != "png" && $tipo_imagem != "jpeg"
                                                            && $tipo_imagem != "gif") {
                                                            $uploadOk = 0;
                                                        }
                                                        // Verifica se $uploadOk está setado como 0 por motivo de erro
                                                        if ($uploadOk == 1) {
                                                            move_uploaded_file($_FILES["altprod_arquivo_upload"]["tmp_name"], $arquivo_destino);
                                                        }
                                                    }
                                                }

                                                echo '<script>swal("Feito!", "Cadastro de produto alterado.", "success");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            } else {
                                                // Emite mensagem de erro caso o produto já esteja cadastrado
                                                echo '<script>swal("Erro!", "Produto já cadastrado.(numrow = ' . $numrow_produto . '", "error");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            }
                                        }
                                        ?>
                                    </form>
                                </div>

                                <!-- rodapé -->
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fim da modal para alterar cadastro produtos -->

                <!-- Aba categorias -->
                <div class="tab-pane fade" id="categorias" role="tabpanel" aria-labelledby="categorias-tab">
                    <br>
                    <h4>Categorias</h4>
                    <br>
                    <table class="table table-striped table-hover" id="categorias_cadastradas" cellspacing="0"
                           width="100%">
                        <thead>
                        <th>Cód. da categoria</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                        </thead>
                        <?php
                        $query_categorias_cadastradas = "SELECT cod_categoria, descr_categoria FROM categoria WHERE status = 1 ORDER BY descr_categoria";
                        $result_categorias_cadastradas = mysqli_query($conn, $query_categorias_cadastradas);
                        while ($row_categorias_cadastradas = mysqli_fetch_array($result_categorias_cadastradas)) { ?>
                            <tr>
                                <td class="italico"><?php echo $row_categorias_cadastradas['cod_categoria'] ?></td>
                                <td><?php echo $row_categorias_cadastradas['descr_categoria'] ?></td>
                                <td>
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                        <div class="btn-toolbar">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#alterar_categoria"
                                                        data-cod_categoria="<?php echo $row_categorias_cadastradas['cod_categoria'] ?>"
                                                        data-descr_categoria="<?php echo $row_categorias_cadastradas['descr_categoria'] ?>">
                                                    Editar <span class="fas fa-pencil-alt"></span>
                                                </button>
<!--                                                <button class="btn btn-danger" name="desativa_categoria" value="--><?php //echo $row_categorias_cadastradas['cod_categoria'] ?><!--" onclick="return confirm('Deseja realmente excluir este item?')">-->
                                                <button class="btn btn-danger" name="desativa_categoria" value="<?php echo $row_categorias_cadastradas['cod_categoria'] ?>" onclick="swal({ title: 'Are you sure?', text: 'You wont be able to revert this!', type: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!'}).then((result) => {
                                                if (result.value) {
                                                swal(
                                                'Deleted!',
                                                'Your file has been deleted.',
                                                'success'
                                                )
                                                }
                                                })">
                                                    Excluir <span class="fas fa-trash-alt"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                        // Desativa o produto no banco
                        if (isset($_POST['desativa_categoria'])) {
                            $cod_categoria_desativar = $_POST['desativa_categoria'];
                            $query_desativar_categorias = "UPDATE categoria SET status = 0 WHERE cod_categoria = $cod_categoria_desativar";
                            $result_desativar_categorias = mysqli_query($conn, $query_desativar_categorias);
                            echo '<script>swal("Feito!", "Categoria excluída.", "success");</script>';
                            echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                        }
                        ?>
                    </table>
                    <br>
                    <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#cadastrar_categorias">
                        Cadastrar <span class="fa fa-edit"></span>
                    </button>

                    <!-- modal para cadastrar categorias -->
                    <!-- Janela -->
                    <div class="modal fade" id="cadastrar_categorias">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <!-- cabeçalho -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Cadastrar categorias</h4>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <!-- corpo -->
                                <div class="modal-body">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                        <div class="form-group row">
                                            <label for="descr_categoria" class="col-3 col-form-label">Descrição da
                                                Categoria</label>
                                            <div class="col-9">
                                                <input class="form-control" type="text" name="descr_categoria"
                                                       autocomplete="off"
                                                       id="descr_categoria" required>
                                            </div>
                                        </div>
                                        <div class="btn-toolbar">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-success" name="submit_categoria">
                                                    Cadastrar <span class="fa fa-edit"></span>
                                                </button>

                                                <button type="reset" class="btn btn-danger">
                                                    Limpar <span class="fa fa-eraser"></span>
                                                </button>
                                            </div>
                                            <?php
                                            if (isset($_POST['submit_categoria'])) {
                                                $descr_categoria = $_POST['descr_categoria'];

                                                //  Pesquisa a categoria antes de cadastrá-la
                                                $query_cod_categoria = "SELECT cod_categoria FROM categoria WHERE descr_categoria = '$descr_categoria'";
                                                $result_cod_categoria = mysqli_query($conn, $query_cod_categoria);
                                                $row_cod_categoria = mysqli_fetch_array($result_cod_categoria);

                                                if ($row_cod_categoria['cod_categoria'] == '') {
                                                    // Realiza o cadastro, caso não encontre registro no banco
                                                    $query_categoria = "INSERT INTO categoria VALUES (DEFAULT, '$descr_categoria', 1)";
                                                    $result_categorias = mysqli_query($conn, $query_categoria);
                                                    echo '<script>swal("Feito!", "Categoria cadastrada.", "success");</script>';
                                                    echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                                } else {
                                                    // Emite mensagem de erro caso a categoria já esteja cadastrada
                                                    echo '<script>swal("Ops!", "Categoria já cadastrada (código ' . $row_cod_categoria['cod_categoria'] . ').", "error");</script>';
                                                    echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </form>
                                </div>

                                <!-- rodapé -->
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- fim da modal para cadastrar categorias -->

                    <!--  modal para alterar o cadastro de categorias  -->

                    <!--  Janela  -->
                    <div class="modal fade" id="alterar_categoria" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <!-- cabeçalho -->
                                <div class="modal-header">
                                    <h4 class="modal-title" id="titulo_modal"></h4>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <!-- corpo -->
                                <div class="modal-body">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"
                                          enctype="multipart/form-data">
                                        <input type="hidden" name="altcat_cod_categoria" id="altcat_cod_categoria">
                                        <div class="form-group row">
                                            <label for="altcat_descr_categoria" class="col-4 col-form-label">Descrição
                                                da
                                                Categoria</label>
                                            <div class="col-8">
                                                <input class="form-control" type="text" name="altcat_descr_categoria"
                                                       id="altcat_descr_categoria" autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="btn-toolbar">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-primary"
                                                        name="altcat_submit_categoria">
                                                    Alterar <span class="fas fa-pencil-alt"></span>
                                                </button>

                                                <button type="reset" class="btn btn-danger">
                                                    Limpar <span class="fa fa-eraser"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_POST['altcat_submit_categoria'])) {
                                            $descr_categoria = $_POST['altcat_descr_categoria'];
                                            $cod_categoria = $_POST['altcat_cod_categoria'];

                                            //  Pesquisa a categoria antes de alterá-la
                                            $query_categoria = "SELECT cod_categoria FROM categoria WHERE descr_categoria = '$descr_categoria' AND cod_categoria <> '$cod_categoria'";
                                            $result_categoria = mysqli_query($conn, $query_categoria);
                                            $numrow_categoria = mysqli_num_rows($result_categoria);
                                            if ($numrow_categoria == 0) {
                                                // Realiza a alteração do cadastro, caso não encontre registro no banco
                                                $query_alt_categoria = "UPDATE categoria SET descr_categoria = '$descr_categoria' WHERE cod_categoria = $cod_categoria";
                                                $result_alt_categoria = mysqli_query($conn, $query_alt_categoria);
                                                echo '<script>swal("Feito!", "Cadastro de categoria alterado.", "success");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            } else {
                                                // Emite mensagem de erro caso a categoria já esteja cadastrada
                                                echo '<script>swal("Erro!", "Categoria já cadastrada.", "error");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            }
                                        }
                                        ?>
                                    </form>
                                </div>

                                <!-- rodapé -->
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- fim da modal para alterar o cadastro de categorias -->
                </div>

                <!-- Aba áreas -->
                <div class="tab-pane fade" id="areas" role="tabpanel" aria-labelledby="areas-tab">
                    <br>
                    <h4>Áreas</h4>
                    <br>
                    <table class="table table-striped table-hover" id="areas_cadastradas" cellspacing="0" width="100%">
                        <thead>
                        <th>Categoria</th>
                        <th>Área</th>
                        <th>Ações</th>
                        </thead>
                        <?php
                        $query_areas_cadastradas = "SELECT descr_categoria, cod_area, descr_area FROM categoria JOIN area a ON categoria.cod_categoria = a.cod_categoria WHERE a.status = 1 and categoria.status = 1 ORDER BY descr_area";
                        $result_areas_cadastradas = mysqli_query($conn, $query_areas_cadastradas);
                        while ($row_areas_cadastradas = mysqli_fetch_array($result_areas_cadastradas)) { ?>
                            <tr>
                                <td class="italico"><?php echo $row_areas_cadastradas['descr_categoria'] ?></td>
                                <td class="italico"><?php echo $row_areas_cadastradas['descr_area'] ?></td>
                                <td>
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                        <div class="btn-toolbar">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#alterar_area"
                                                        data-descr_categoria="<?php echo $row_areas_cadastradas['descr_categoria'] ?>"
                                                        data-cod_area="<?php echo $row_areas_cadastradas['cod_area'] ?>"
                                                        data-descr_area="<?php echo $row_areas_cadastradas['descr_area'] ?>">
                                                    Editar <span class="fas fa-pencil-alt"></span>
                                                </button>
                                                <button class="btn btn-danger" name="desativa_area"
                                                        value="<?php echo $row_areas_cadastradas['cod_area'] ?>">
                                                    Excluir <span class="fas fa-trash-alt"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                        // Desativa a area no banco
                        if (isset($_POST['desativa_area'])) {
                            $cod_area_desativar = $_POST['desativa_area'];
                            $query_desativar_areas = "UPDATE area SET status = 0 WHERE cod_area = $cod_area_desativar";
                            $result_desativar_areas = mysqli_query($conn, $query_desativar_areas);
                            echo '<script>swal("Feito!", "Área excluída.", "success");</script>';
                            echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                        }
                        ?>
                    </table>
                    <br>
                    <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#cadastrar_area">
                        Cadastrar <span class="fa fa-edit"></span>
                    </button>

                    <!-- modal para cadastrar áreas -->
                    <!-- Janela -->
                    <div class="modal fade" id="cadastrar_area">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <!-- cabeçalho -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Cadastrar áreas</h4>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <!-- corpo -->
                                <div class="modal-body">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                        <div class="form-group row">
                                            <label for="cod_categoria" class="col-3 col-form-label">Selecione a
                                                Categoria</label>
                                            <div class="col-9">
                                                <select class="form-control" name="cod_categoria" id="cod_categoria"
                                                        required>
                                                    <option value="">--</option>
                                                    <?php
                                                    $query_categoria = "SELECT * FROM categoria WHERE status = 1 ORDER BY descr_categoria";
                                                    $result_categorias = mysqli_query($conn, $query_categoria);
                                                    while ($row_categoria = mysqli_fetch_array($result_categorias)) {
                                                        echo '<option value="' . $row_categoria['cod_categoria'] . '">' . $row_categoria['descr_categoria'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="descr_area" class="col-3 col-form-label">Descrição da
                                                Área</label>
                                            <div class="col-9">
                                                <input class="form-control" type="text" name="descr_area"
                                                       id="descr_area" autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="btn-toolbar">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-success" name="submit_area">
                                                    Cadastrar <span class="fa fa-edit"></span>
                                                </button>

                                                <button type="reset" class="btn btn-danger">
                                                    Limpar <span class="fa fa-eraser"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_POST['submit_area'])) {
                                            $descr_area = $_POST['descr_area'];
                                            $cod_categoria = $_POST['cod_categoria'];

                                            //  Pesquisa a área antes de cadastrá-la
                                            $query_cod_area = "SELECT cod_area FROM area WHERE descr_area = '$descr_area' AND cod_categoria = '$cod_categoria'";
                                            $result_cod_area = mysqli_query($conn, $query_cod_area);
                                            $row_cod_area = mysqli_fetch_array($result_cod_area);
                                            if ($row_cod_area['cod_area'] == '') {
                                                // Realiza o cadastro, caso não encontre registro no banco
                                                $query_area = "INSERT INTO area VALUES (DEFAULT,'$descr_area','$cod_categoria', 1)";
                                                $result_area = mysqli_query($conn, $query_area);
                                                echo '<script>swal("Feito!", "Área cadastrada.", "success");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            } else {
                                                // Emite mensagem de erro caso o produto já esteja cadastrado
                                                echo '<script>swal("Ops!", "Área já cadastrada (código ' . $row_cod_area['cod_area'] . ').", "error");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            }
                                        }
                                        ?>
                                    </form>
                                </div>

                                <!-- rodapé -->
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- fim da modal para cadastrar áreas -->

                    <!--  modal para alterar o cadastro de áreas  -->

                    <!--  Janela  -->
                    <div class="modal fade" id="alterar_area" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <!-- cabeçalho -->
                                <div class="modal-header">
                                    <h4 class="modal-title" id="titulo_modal"></h4>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <!-- corpo -->
                                <div class="modal-body">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"
                                          enctype="multipart/form-data">
                                        <input type="hidden" name="altarea_cod_area" id="altarea_cod_area">
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label" for="altarea_selec_cod_categoria"
                                                   id="altarea_categoria_atual"></label>
                                            <div class="col-8">
                                                <select class="form-control" name="altarea_selec_cod_categoria"
                                                        id="altarea_selec_cod_categoria" required>
                                                    <option value="">--</option>
                                                    <?php
                                                    $query_selec_categoria = "SELECT * FROM categoria WHERE status = 1 ORDER BY descr_categoria";
                                                    $result_selec_categoria = mysqli_query($conn, $query_selec_categoria);
                                                    while ($row_selec_categoria = mysqli_fetch_array($result_selec_categoria)) {
                                                        echo '<option value="' . $row_selec_categoria['cod_categoria'] . '">' . $row_selec_categoria['descr_categoria'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="altarea_descr_area" class="col-4 col-form-label">Descrição da
                                                Área</label>
                                            <div class="col-8">
                                                <input class="form-control" type="text" name="altarea_descr_area"
                                                       id="altarea_descr_area" autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="btn-toolbar">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-primary"
                                                        name="altarea_submit_area">
                                                    Alterar <span class="fas fa-pencil-alt"></span>
                                                </button>

                                                <button type="reset" class="btn btn-danger">
                                                    Limpar <span class="fa fa-eraser"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_POST['altarea_submit_area'])) {
                                            $descr_area = $_POST['altarea_descr_area'];
                                            $cod_area = $_POST['altarea_cod_area'];
                                            $cod_categoria = $_POST['altarea_selec_cod_categoria'];

                                            //  Pesquisa a categoria antes de alterá-la
                                            $query_area = "SELECT cod_area FROM area WHERE descr_area = '$descr_area' AND cod_area <> $cod_area";
                                            $result_area = mysqli_query($conn, $query_area);
                                            $numrow_area = mysqli_num_rows($result_area);
                                            if ($numrow_area == 0) {
                                                // Realiza a alteração do cadastro, caso não encontre registro no banco
                                                $query_alt_area = "UPDATE area SET descr_area = '$descr_area', cod_categoria = $cod_categoria WHERE cod_area = $cod_area";
                                                $result_alt_area = mysqli_query($conn, $query_alt_area);
                                                echo '<script>swal("Feito!", "Cadastro de área alterado.", "success");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            } else {
                                                // Emite mensagem de erro caso a área já esteja cadastrada
                                                echo '<script>swal("Erro!", "Área já cadastrada.", "error");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            }
                                        }
                                        ?>
                                    </form>
                                </div>

                                <!-- rodapé -->
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- fim da modal para alterar o cadastro de áreas -->
                </div>

                <!-- Aba fornecedores -->
                <div class="tab-pane fade" id="fornecedores" role="tabpanel" aria-labelledby="fornecedores-tab">

                    <br>
                    <h4>Fornecedores</h4>
                    <br>
                    <table class="table table-striped table-hover" id="fornecedores_cadastrados" cellspacing="0"
                           width="100%">
                        <thead>
                        <th>Cód. do fornecedor</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                        </thead>
                        <?php
                        $query_fornecedores_cadastrados = "SELECT cod_fornecedor, descr_fornecedor FROM fornecedor WHERE status = 1 ORDER BY descr_fornecedor";
                        $result_fornecedores_cadastrados = mysqli_query($conn, $query_fornecedores_cadastrados);
                        while ($row_fornecedores_cadastrados = mysqli_fetch_array($result_fornecedores_cadastrados)) { ?>
                            <tr>
                                <td class="italico"><?php echo $row_fornecedores_cadastrados['cod_fornecedor'] ?></td>
                                <td><?php echo $row_fornecedores_cadastrados['descr_fornecedor'] ?></td>
                                <td>
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                        <div class="btn-toolbar">
                                            <div class="btn-group">
                                                <button class="btn btn-primary" name="altera_fornecedor"
                                                        value="<?php echo $row_fornecedores_cadastrados['cod_fornecedor'] ?>">
                                                    Editar <span class="fas fa-pencil-alt"></span>
                                                </button>
                                                <button class="btn btn-danger" name="desativa_fornecedor"
                                                        value="<?php echo $row_fornecedores_cadastrados['cod_fornecedor'] ?>">
                                                    Excluir <span class="fas fa-trash-alt"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                        // Desativa o fornecedor no banco
                        if (isset($_POST['desativa_fornecedor'])) {
                            $cod_fornecedor_desativar = $_POST['desativa_fornecedor'];
                            $query_desativar_fornecedor = "UPDATE fornecedor SET status = 0 WHERE cod_fornecedor = $cod_fornecedor_desativar";
                            $result_desativar_fornecedor = mysqli_query($conn, $query_desativar_fornecedor);
                            echo '<script>swal("Feito!", "Fornecedor excluído.", "success");</script>';
                            echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                        }
                        ?>
                    </table>
                    <br>
                    <button type="submit" class="btn btn-success" data-toggle="modal"
                            data-target="#cadastrar_fornecedor">
                        Cadastrar <span class="fa fa-edit"></span>
                    </button>

                    <!-- modal para cadastrar fornecedores -->
                    <!-- Janela -->
                    <div class="modal fade" id="cadastrar_fornecedor">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <!-- cabeçalho -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Cadastrar fornecedores</h4>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <!-- corpo -->
                                <div class="modal-body">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"
                                          onsubmit="return valida_fornecedor();">
                                        <div class="form-group row">
                                            <label for="descr_fornecedor" class="col-4 col-form-label">Descrição do
                                                Fornecedor</label>
                                            <div class="col-8">
                                                <input class="form-control" type="text" name="descr_fornecedor"
                                                       autocomplete="off"
                                                       id="descr_fornecedor" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-4 col-form-label">Email</label>
                                            <div class="col-8">
                                                <input class="form-control" type="text" name="email" id="email"
                                                       autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="telefone" class="col-4 col-form-label">Telefone</label>
                                            <div class="col-8">
                                                <input class="form-control phone-ddd-mask" type="text" name="telefone"
                                                       autocomplete="off"
                                                       id="telefone" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cep" class="col-4 col-form-label">CEP</label>
                                            <div class="col-8">
                                                <input class="form-control" type="text" name="cep" id="cep"
                                                       autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="logradouro" class="col-4 col-form-label">Endereço</label>
                                            <div class="col-8">
                                                <input class="form-control" type="text" name="logradouro"
                                                       id="logradouro" autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="numero" class="col-4 col-form-label">Número</label>
                                            <div class="col-8">
                                                <input class="form-control" type="text" name="numero" id="numero"
                                                       autocomplete="off"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="bairro" class="col-4 col-form-label">Bairro</label>
                                            <div class="col-8">
                                                <input class="form-control fundo_branco_formulario_disable" type="text"
                                                       name="bairro" id="bairro" autocomplete="off" required readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="localidade" class="col-4 col-form-label">Cidade</label>
                                            <div class="col-8">
                                                <input class="form-control fundo_branco_formulario_disable" type="text"
                                                       name="localidade" id="localidade" autocomplete="off" required
                                                       readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="uf" class="col-4 col-form-label">Estado</label>
                                            <div class="col-8">
                                                <input class="form-control fundo_branco_formulario_disable" type="text"
                                                       name="uf" id="uf" autocomplete="off" required readonly>
                                            </div>
                                        </div>
                                        <div class="btn-toolbar">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-success" name="submit_fornecedor">
                                                    Cadastrar <span class="fa fa-edit"></span>
                                                </button>

                                                <button type="reset" class="btn btn-danger">
                                                    Limpar <span class="fa fa-eraser"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_POST['submit_fornecedor'])) {
                                            $descr_fornecedor = $_POST['descr_fornecedor'];
                                            $email = $_POST['email'];
                                            $telefone = $_POST['telefone'];
                                            $cep = $_POST['cep'];
                                            $logradouro = $_POST['logradouro'];
                                            $numero = $_POST['numero'];
                                            $bairro = $_POST['bairro'];
                                            $localidade = $_POST['localidade'];
                                            $uf = $_POST['uf'];

                                            //  Pesquisa o fornecedor antes de cadastrá-lo
                                            $query_cod_fornecedor = "SELECT cod_fornecedor FROM fornecedor JOIN endereco ON fornecedor.cod_endereco = endereco.cod_endereco WHERE descr_fornecedor = '$descr_fornecedor' AND localidade = '$localidade'";
                                            $result_cod_fornecedor = mysqli_query($conn, $query_cod_fornecedor);
                                            $row_cod_fornecedor = mysqli_fetch_array($result_cod_fornecedor);
                                            if ($row_cod_fornecedor['cod_fornecedor'] == '') {

                                                // Realiza o cadastro, caso não encontre registro no banco

                                                //  Insere o novo endereço na tabela endereco, caso não exista
                                                $query_pesquisa_endereco = "SELECT cod_endereco FROM endereco WHERE logradouro = '$logradouro, $numero' AND localidade = '$localidade'";
                                                $result_pesquisa_endereco = mysqli_query($conn, $query_pesquisa_endereco);
                                                if (mysqli_num_rows($result_pesquisa_endereco) == 0) {
                                                    $query_endereco = "INSERT INTO endereco VALUES (DEFAULT, '$cep', '$logradouro, $numero', '$bairro', '$localidade', '$uf')";
                                                    $result_endereco = mysqli_query($conn, $query_endereco);
                                                }

                                                //  Pesquisa a chave do endereço cadastrado
                                                $query_chave_endereco = "SELECT cod_endereco FROM endereco WHERE logradouro = '$logradouro, $numero' AND localidade = '$localidade'";
                                                $result_chave_endereco = mysqli_query($conn, $query_chave_endereco);
                                                $row_cod_endereco = mysqli_fetch_array($result_chave_endereco);
                                                $cod_endereco = $row_cod_endereco['cod_endereco'];

                                                // Insere os demais dados na tabela fornecedor
                                                $query_fornecedor = "INSERT INTO fornecedor VALUE (DEFAULT, '$descr_fornecedor', '$cod_endereco', '$email', '$telefone', 1)";
                                                $result_fornecedor = mysqli_query($conn, $query_fornecedor);
                                                echo '<script>swal("Feito!", "Fornecedor cadastrado.", "success");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            } else {
                                                // Emite mensagem de erro caso o fornecedor já esteja cadastrado
                                                echo '<script>swal("Erro!", "Fornecedor já cadastrado (código ' . $row_cod_fornecedor['cod_fornecedor'] . ').", "error");</script>';
                                                echo '<meta HTTP-EQUIV="refresh" CONTENT="3;URL=' . $_SERVER['PHP_SELF'] . '">';
                                            }
                                            // Fecha a conexão com o banco
                                            mysqli_close($conn);
                                        }
                                        ?>
                                    </form>
                                </div>

                                <!-- rodapé -->
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- fim da modal para cadastrar fornecedores -->
                </div>

            </div>
            <!-- fim do conteúdo das abas -->
        </div>
    </div>
    <!-- /.col-lg-12 -->

</div>
<!-- /.row -->
<?php
require_once('rodape.php');
?>