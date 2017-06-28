<?php foreach(Input::get('lista') as $produto) { ?>
<a class="produto" href="<?= Controller::url(Path::getClassMap('ProdutoAction').'/'.$produto->getId()) ?>">
<div class="produto">
    <div class="foto">
        <?php if ($produto->getFoto()) { ?>
        <img class="foto" src="<?= Controller::url(Path::getClassMap('FotoAction').'/mini/'.$produto->getFoto()->getId()) ?>" />
        <?php } else { ?>
        <img class="foto" src="<?= Controller::url(Path::getClassMap('FotoAction').'/mini/semfoto') ?>" />
        <?php } ?>
    </div>
    <strong><?= $produto->getNome() ?></strong><br/>
        <?= number_format($produto->getPreco(), 2, ',', '.') ?>
</div>
</a>
<?php } ?>
