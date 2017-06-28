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
    });
    function openFoto(id) {
        $("#dialog_" + id).dialog("open");
    }
');
$produto = input::get('produto');
?>
<div class=".float_foto">
    <?php if ($produto->getFoto()) { ?>
    <img onclick="openFoto(<?=$produto->getFoto()->getId()?>)" class="foto" src="<?= Controller::url(Path::getClassMap('FotoAction').'/mini/'.$produto->getFoto()->getId()) ?>" />
    <div class="foto_dialog" id="dialog_<?=$produto->getFoto()->getId()?>">
        <img class="foto" src="<?= Controller::url(Path::getClassMap('FotoAction').'/'.$produto->getFoto()->getId()) ?>" />
    </div>
    <?php } ?>
    <?php foreach($produto->listarFotos() as $foto) {
        if ($produto->getFoto() != null && $produto->getFoto()->getId() == $foto->getId())
                continue
    ?>
    <img onclick="openFoto(<?=$foto->getId()?>)" class="foto" src="<?= Controller::url(Path::getClassMap('FotoAction').'/mini/'.$foto->getId()) ?>" />
    <div class="foto_dialog" id="dialog_<?=$foto->getId()?>">
        <img class="foto" src="<?= Controller::url(Path::getClassMap('FotoAction').'/'.$foto->getId()) ?>" />
    </div>
    <?php } ?>
</div>
<h1><?= $produto->getNome() ?></h1>
<h2>Preço: R$ <?= number_format($produto->getPreco(), 2, ',', '.') ?></h2>
<p><a href="<?= Controller::url(Path::getClassMap('CarrinhoAction').'/add/'.$produto->getId()) ?>">Comprar</a></p>
<h2 class="detalhes">Detalhes</h2>
<p>
    <?= $produto->getDescricao() ?>
</p>
<p>
<a href="<?= Controller::url(Path::getClassMap('CarrinhoAction').'/add/'.$produto->getId()) ?>">Comprar</a>
</p>
