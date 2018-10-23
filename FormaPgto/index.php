<?php

include_once('../config.php');

?>
<div class="container">
    <div class="col-lg-12">
        <div>
            <h1 class="p-2">Cadastro - Formas de Pagamento</h1>
            <p class="lead">Área destinada a cadastro das tabelas de formas de pagamento</p>
        </div>

        <!-- Criação das abas -->
        <ul class="nav nav-tabs" id="abas-cadastro-formaspgto" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="formaspgto-tab" data-toggle="tab" href="#formaspgto" role="tab"
                   aria-controls="formaspgto"
                   aria-selected="true">Formas de pagamento</a>
            </li>
        </ul>

        <!-- Conteúdo das abas -->
        <div class="tab-content" id="myTabContent">

            <!-- Aba formas de pagamento -->
            <?php

            include_once ('aba_formaspgto.php');

            ?>
            <!-- Fim da Aba formas de pagamento -->


        </div>
    </div>
</div>

<?php

include_once('../rodape.php');

?>
