<?php
Template::addScript('
    $().ready(function() {
        $("#excluir").click(function() {
            $("#dialog-confirm").dialog("open");
        });
        $("#dialog-confirm").dialog({
                autoOpen: false,
                resizable: false,
                /*height: 140,*/
                modal: true,
                buttons: {
                        "Deletar": function() {
                                $( this ).dialog( "close" );
                                document.form.action = "'.Controller::url(Path::getClassMap('AdminCategoriaAction').'/deletar').'";
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
<div id="dialog-confirm" title="Deletar categoria?">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Confirma remoção desta categoria?</p>
</div>
<h1 class="titulo">Categoria</h1>
<form id="form" name="form" action="<?= Controller::url(Path::getClassMap('AdminCategoriaAction').'/gravar') ?>" method="post">
    <input type="hidden" name="id" value="<?= Input::get('id') ?>" />
    <label for="nome">Nome:</label><input id="nome" type="text" name="nome" value="<?= Input::get('nome') ?>"/><br />
    <label>&nbsp;</label><button type="submit"><span class="float-icon ui-icon ui-icon-check"></span>Salvar</button>
    <?php if (Input::get('id')) { ?>
        <button id="excluir" type="button"><span class="float-icon ui-icon ui-icon-trash"></span>Excluir</button>
    <?php } ?>
</form>
