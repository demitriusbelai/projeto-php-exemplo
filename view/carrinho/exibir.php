<?php
Template::addScript('
    $().ready(function() {
        $("#dialog-limpar").dialog({
                autoOpen: false,
                resizable: false,
                /*height: 140,*/
                modal: true,
                buttons: {
                        "Limpar": function() {
                                $( this ).dialog( "close" );
                                window.location.href = "'.Controller::url(Path::getClassMap('CarrinhoAction').'/limpar').'";
                                document.form.submit();
                        },
                        "Cancelar": function() {
                                $( this ).dialog( "close" );
                        }
                }
        });
    });
    function limpar() {
        $("#dialog-limpar").dialog("open");
    }
');
?>
<div id="dialog-limpar">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Deseja realmente limpar o carrinho?</p>
</div>
<form action="<?= Controller::url(Path::getClassMap('CarrinhoAction').'/atualizar/') ?>" method="post">
<table class="listagem">
    <tr>
        <th>Produto</th>
        <th>Qtde.</th>
        <th>Preço</th>
        <th>Sub-Total</th>
        <th></th>
    </tr>
<?php foreach(Input::get('carrinho')->getItens() as $item) { ?>
    <tr>
        <td><?= $item->getProduto()->getNome() ?></td>
        <td><input class="right" type="text" size="2" name="qtde_<?= $item->getProduto()->getId() ?>" value="<?= $item->getQuantidade() ?>" /></td>
        <td class="right"><?= number_format($item->getProduto()->getPreco(), 2, ',', '.') ?></td>
        <td class="right"><?= number_format(bcmul($item->getProduto()->getPreco(), $item->getQuantidade()), 2, ',', '.') ?></td>
        <td><a class="button" href="<?= Controller::url(Path::getClassMap('CarrinhoAction').'/remove/'.$item->getProduto()->getId()) ?>"><span class="ui-icon ui-icon-trash"></span></a></td>
    </tr>
<?php } ?>
    <tr>
        <td class="total" colspan="3">Total</td>
        <td class="right"><?= number_format(Input::get('carrinho')->getTotal(), 2, ',', '.') ?></td>
    </tr>
</table>
<p>
    <button type="submit" name="atualizar"><span class="float-icon ui-icon ui-icon-refresh"></span>Atualizar</button>
    <a class="button" href="javascript:limpar()"><span class="float-icon ui-icon ui-icon-cancel"></span>Limpar</a>
    <a class="button" href="<?= Controller::url(Path::getClassMap('CompraAction')) ?>"><span class="float-icon ui-icon ui-icon-check"></span>Finalizar</a>
</p>
</form>
