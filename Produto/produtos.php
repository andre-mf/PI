<?php

include_once('../config.php');

?>
<div class="container">
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
            <?php

            include_once('../Produto/aba_produtos.php');

            ?>
            <!-- Fim da Aba produtos -->

            <!-- Aba categorias -->
            <?php

            include_once('../Categoria/aba_categorias.php');

            ?>
            <!-- Fim da Aba categorias -->

            <!-- Aba areas -->
            <?php

            include_once('../Area/aba_areas.php');

            ?>
            <!-- Fim da Aba areas -->

            <!-- Aba fornecedores -->
            <?php

            include_once('../Fornecedor/aba_fornecedores.php');

            ?>
            <!-- Fim da Aba areas -->


        </div>
    </div>
</div>

<?php

include_once('../rodape.php');

?>
