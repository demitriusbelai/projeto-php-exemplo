<?php
Template::addScript('
    $().ready(function() {
        $("#telefone").mask("(99) 9999-9999");
        $("#cep").mask("99999-999");
        $("#cartao_numero").mask("9999 9999 9999 9999");
        $("#cartao_vencimento").mask("99/99");
        $("#cartao_seguranca").mask("999");
    });
');
Template::addCss('
form label {
    float: left;
    width: 180px;
    font-weight: normal;
}
form > input, form > textarea, form > select {
    width: 240px;
    margin-bottom: 5px;
}
');
?>
<h1 class="titulo">Finalização da Compra</h1>
<form id="form" name="form" action="<?= Controller::url(Path::getClassMap('CompraAction').'/gravar') ?>" method="post">
    <label for="nome">Nome:</label><input id="nome" type="text" name="nome" value="<?= Input::get('nome') ?>"/><br />
    <label for="email">Email:</label><input id="email" type="text" name="email" value="<?= Input::get('email') ?>"/><br />
    <label for="telefone">Telefone:</label><input id="telefone" type="text" name="telefone" value="<?= Input::get('telefone') ?>"/><br />
    <label for="endereco">Endereço:</label><input id="endereco" type="text" name="endereco" value="<?= Input::get('endereco') ?>"/><br />
    <label for="cep">CEP:</label><input id="cep" type="text" name="cep" value="<?= Input::get('cep') ?>"/><br />
    <label for="cartao_tipo">Cartão:</label>
    <select id="cartao_tipo" name="cartao_tipo">
        <option value=""> - </option>
        <option <?= (Input::get('cartao_tipo') == 'visa' ? 'selected="selected"' : '') ?>value="visa">Visa</option>
        <option <?= (Input::get('cartao_tipo') == 'master' ? 'selected="selected"' : '') ?>value="master">MasterCard</option>
    </select><br />
    <label for="cartao_numero">Número:</label><input id="cartao_numero" type="text" name="cartao_numero" value="<?= Input::get('cartao_numero') ?>"/><br />
    <label for="cartao_vencimento">Vencimento:</label><input id="cartao_vencimento" type="text" name="cartao_vencimento" value="<?= Input::get('cartao_vencimento') ?>"/> mm/aa<br />
    <label for="cartao_seguranca">Código de segurança:</label><input id="cartao_seguranca" type="text" name="cartao_seguranca" value="<?= Input::get('cartao_seguranca') ?>"/><br />
    <label>&nbsp;</label><button type="submit"><span class="float-icon ui-icon ui-icon-check"></span>Finalizar</button>
</form>
