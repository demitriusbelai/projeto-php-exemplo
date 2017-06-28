<?php
Template::addScript('
    $().ready(function() {
        $("#preco").maskMoney({symbol:"R$", decimal:",", thousands:"."});
        $("#excluir").click(function() {
            $("#dialog-confirm").dialog("open");
        });
        $("#foto").click(function() {window.location.href="'.Controller::url(Path::getClassMap('AdminFotoAction').'/'.Input::get('id')).'"});
        $("#dialog-confirm").dialog({
                autoOpen: false,
                resizable: false,
                /*height: 140,*/
                modal: true,
                buttons: {
                        "Deletar": function() {
                                $( this ).dialog( "close" );
                                document.form.action = "'.Controller::url(Path::getClassMap('AdminProdutoAction').'/deletar').'";
                                document.form.submit();
                        },
                        "Cancelar": function() {
                                $( this ).dialog( "close" );
                        }
                }
        });
    });
');
?>
<div id="dialog-confirm" title="Deletar produto?">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Confirma remoção deste produto?</p>
</div>
<h1 class="titulo">Produto</h1>
<form id="form" name="form" action="<?= Controller::url(Path::getClassMap('AdminProdutoAction').'/gravar') ?>" method="post">
    <input type="hidden" name="id" value="<?= Input::get('id') ?>" />
    <label for="nome">Nome:</label><input id="nome" type="text" name="nome" value="<?= Input::get('nome') ?>"/><br />
    <label for="categoria">Categoria:</label>
    <select id="categoria" name="categoria">
        <option value=""> - </option>
        <?php foreach(Input::get('categorias') as $categoria) { ?>
            <option <?= (Input::get('categoria') == $categoria->getId() ? 'selected="selected"' : '') ?>value="<?= $categoria->getId() ?>"><?= $categoria->getNome() ?></option>
        <?php } ?>
    </select><br />
    <label for="quantidade">Quantidade:</label><input id="quantidade" type="text" name="quantidade" style="text-align:right" value="<?= Input::get('quantidade') ?>" /><br />
    <label for="preco">Preço:</label><input id="preco" type="text" name="preco" style="text-align:right" value="<?= Input::get('preco') ?>" /><br />
    <label for="descricao">Descrição</label><div class="input"><textarea class="ckeditor" cols="80" id="descricao" name="descricao" rows="10"><?= htmlspecialchars(Input::get('descricao')) ?></textarea></div><br/>
    <label>&nbsp;</label><button type="submit"><span class="float-icon ui-icon ui-icon-check"></span>Salvar</button>
    <?php if (Input::get('id')) { ?>
        <button id="foto" type="button"><span class="float-icon ui-icon ui-icon-image"></span>Ir para fotos</button>
        <button id="excluir" type="button"><span class="float-icon ui-icon ui-icon-trash"></span>Excluir</button>
    <?php } ?>
</form>
