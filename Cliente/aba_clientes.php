<?php

$cliente = new Cliente();

$sql = new Sql();

?>

<div class="tab-pane fade show active" id="clientes" role="tabpanel" aria-labelledby="clientes-tab">
    <form method="post" onsubmit="return valida_pesquisa_cliente()">
        <br>
        <h4>Clientes</h4>
        <br>
        <a class="btn btn-success" href="../Cliente/formulario_clientes.php">Cadastrar <span class="fa fa-edit"></span></a>
        <br>
        <br>
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" aria-describedby="nome"
                   placeholder="Digite um nome" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   placeholder="Digite um email" autocomplete="off">
        </div>
        <div class="btn-toolbar">
            <div class="btn-group">
                <button type="submit" class="btn btn-info" name="submit_pesquisa_cliente">
                    Pesquisar <span class="fa fa-search"></span>
                </button>
                <button type="reset" class="btn btn-danger">
                    Limpar <span class="fa fa-times"></span>
                </button>
            </div>
        </div>
    </form>
</div>
<br>
<?php
// Após submissão do formulário, realiza o select apropriado
if (isset($_POST['submit_pesquisa_cliente'])){

    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Nome e email preenchidos
    if ($nome != '' && $email != '') {

        $pesquisaCliente = $sql->select("SELECT cod_cliente, nome, email, cpf FROM cliente WHERE nome like :NOME and email = :EMAIL and status = :STATUS",[
            ':NOME'=>'%'.$nome.'%',
            ':EMAIL'=>$email,
            ':STATUS' => 1
        ]);

    // Nome preenchido, email vazio
    } elseif ($nome != '' && $email == '') {

        $pesquisaCliente = $sql->select("SELECT cod_cliente, nome, email, cpf FROM cliente WHERE nome like :NOME and status = :STATUS",[
            ':NOME'=>'%'.$nome.'%',
            ':STATUS' => 1
        ]);

    // Nome vazio, email preenchido
    } elseif ($nome == '' && $email != '') {

        $pesquisaCliente = $sql->select("SELECT cod_cliente, nome, email, cpf FROM cliente WHERE email = :EMAIL and status = :STATUS",[
            ':EMAIL'=>$email,
            ':STATUS' => 1
        ]);

    } else {

        // Alert para submit com campos vazios
        echo '<script>swal("Ops!", "Informe algum dado para realizar a pesquisa.", "warning");</script>';

    }

    // Caso a pesquisa retorne resultado, monta a tabela com os dados
    if (isset($pesquisaCliente[0])) {

        echo '<div>
            <br>
            <h4>Resultado da pesquisa</h4>
            <br>
            <table class="table table-striped table-hover" id="clientes_cadastrados" cellspacing="0" width="100%">
                <thead>
                    <th>Código do cliente</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Ações</th>
                </thead>';

        foreach ($pesquisaCliente as $aCliente){

            echo "<tr>
                    <td class='italico'>{$aCliente['cod_cliente']}</td>
                    <td>{$aCliente['nome']}</td>
                    <td>{$aCliente['email']}</td>
                    <td>{$aCliente['cpf']}</td>
                    <td>
                        <a class=\"btn btn-primary\" href=\"formulario_clientes.php?cod_cliente={$aCliente['cod_cliente']}\">Editar <span class=\"fa fa-pencil-alt\"></span></a>
                        <a class=\"btn btn-danger\" href=\"formulario_clientes.php?cod_cliente={$aCliente['cod_cliente']}\">Excluir <span class=\"fa fa-times\"></span></a>
                    </td>
                </tr>";

        }

        echo '</table></div>';

    } else {

        // Alert para nenhum resultado da pesquisa
        echo '<script>swal("Nenhum registro localizado.", "", "info");</script>';

    }

}
?>
