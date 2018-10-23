<?php

include_once('../config.php');

?>
<div class="container">
    <div class="col-lg-12">
        <div>
            <h1 class="p-2">Cadastro - Clientes</h1>
            <p class="lead">Área destinada a cadastro das tabelas de clientes</p>
        </div>

        <!-- Criação das abas -->
        <ul class="nav nav-tabs" id="abas-cadastro-clientes" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="clientes-tab" data-toggle="tab" href="#clientes" role="tab"
                   aria-controls="clientes"
                   aria-selected="true">Clientes</a>
            </li>
        </ul>

        <!-- Conteúdo das abas -->
        <div class="tab-content" id="myTabContent">

            <!-- Aba clientes -->
            <?php

            include_once ('aba_clientes.php');

            ?>
            <!-- Fim da Aba clientes -->


        </div>
    </div>
</div>

<?php

include_once('../rodape.php');

?>
