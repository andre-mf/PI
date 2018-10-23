<?php

include_once('../config.php');

?>
    <div class="container">
        <div class="col-lg-12">
            <div>
                <h1 class="p-2">Estoque de produtos</h1>
                <p class="lead">Área destinada a atualização das tabelas de estoque</p>
            </div>

            <!-- Criação das abas -->
            <ul class="nav nav-tabs" id="abas-estoque" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="estoque-tab" data-toggle="tab" href="#estoque" role="tab"
                       aria-controls="estoque"
                       aria-selected="true">Produtos no estoque</a>
                </li>
            </ul>

            <!-- Conteúdo das abas -->
            <div class="tab-content" id="myTabContent">

                <!-- Aba formas de pagamento -->
                <?php

                include_once ('aba_estoque.php');

                ?>
                <!-- Fim da Aba formas de pagamento -->


            </div>
        </div>
    </div>

<?php

include_once('../rodape.php');

?>