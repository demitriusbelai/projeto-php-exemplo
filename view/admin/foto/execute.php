<?php
Template::addScript('
    $().ready(function() {
        $(".foto_dialog").dialog({
                autoOpen: false,
                resizable: true,
                height: 600,
                width: 600,
                modal: true,
                /*buttons: {
                        "Fechar": function() {
                                $( this ).dialog( "close" );
                        }
                }*/
        });
        add_input();
        $(".add_file").click(add_input);
    });
    function openFoto(id) {
        $("#dialog_" + id).dialog("open");
    }
    function add_input() {
        var form_input = \'<div><button class="remove_file" type="button"><span class="ui-icon ui-icon-minusthick"></span></button><input type="file" name="imagem[]" /></div>\';
        $("#form_container").append(form_input);
        $("button, input:submit, a.button").button();
        $(".remove_file").click(function () {
            $(this).parent("div").detach();
        });
    }
');
Template::addCss('
img.foto {
    cursor: pointer;
}
');
?>
<h1 class="titulo">Foto: <small><?= Input::get('produto')->getNome() ?></small></h1>
<table class="listagem">
    <tr>
        <th>Foto</th>
        <th>Tipo</th>
        <th>Tamanho</th>
        <th>Opções</th>
    </tr>
    <?php foreach(Input::get('lista') as $foto) { ?>
        <tr>
            <td>
                <img onclick="openFoto(<?=$foto->getId()?>)" class="foto" src="<?= Controller::url(Path::getClassMap('FotoAction').'/mini/'.$foto->getId()) ?>" />
                <div class="foto_dialog" id="dialog_<?=$foto->getId()?>">
                    <img class="foto" src="<?= Controller::url(Path::getClassMap('FotoAction').'/'.$foto->getId()) ?>" />
                </div>
            </td>
            <td><?= $foto->getTipo() ?></td>
            <td class="right"><?= number_format($foto->getTamanho() / 1024, 2, ',', '.') ?> KiB</td>
            <td>
                <a class="button" href="<?= Controller::url(Path::getClassMap('AdminFotoAction').'/capa/'.$foto->getId()) ?>"><span class="float-icon ui-icon ui-icon-star"></span>Padrão</a>
                <a class="button" href="<?= Controller::url(Path::getClassMap('AdminFotoAction').'/deletar/'.$foto->getId()) ?>"><span class="float-icon ui-icon ui-icon-trash"></span>Excluir</a>
            </td>
        </tr>
    <?php } ?>
</table>
<h2>Enviar</h2>
<form action="<?= Controller::url(Path::getClassMap('AdminFotoAction').'/enviar') ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="produto" value="<?= Input::get('produto')->getId() ?>" />
    <div id="form_container"></div>
    <button class="add_file" type="button"><span class="ui-icon ui-icon-plusthick"></span></button>
    <p><button type="submit"><span class="float-icon ui-icon ui-icon-check"></span>Enviar</button></p>
</form>
