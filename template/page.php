<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title><?= Template::$title ?></title>
        <link rel="StyleSheet" href="<?= Config::get('base-path') ?>/css/base.css" type="text/css"/>
        <link rel="StyleSheet" href="<?= Config::get('base-path') ?>/css/jquery-ui-1.8.6.custom.css" type="text/css"/>
        <script type="text/javascript" src="<?= Config::get('base-path') ?>/js/jquery-1.4.3.min.js"></script>
        <script type="text/javascript" src="<?= Config::get('base-path') ?>/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="<?= Config::get('base-path') ?>/js/jquery.maskMoney.js"></script>
        <script type="text/javascript" src="<?= Config::get('base-path') ?>/js/jquery.maskedinput-1.2.2.min.js"></script>
        <script type="text/javascript" src="<?= Config::get('base-path') ?>/js/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="<?= Config::get('base-path') ?>/js/base.js"></script>
        <?php if (Template::$script) { ?>
        <script type="text/javascript">
            <?= Template::$script ?>
        </script>
        <?php } ?>
        <?php if (Template::$css) { ?>
        <style type="text/css">
            <?= Template::$css ?>
        </style>
        <?php } ?>
    </head>
    <body>
      <div id="menuback"></div>
      <div id="all">
        <div id="content">
<?php if (Template::$error) { ?>
        <div id="message" class="ui-state-error ui-corner-all">
            <span class="float-icon ui-icon ui-icon-alert"></span>
            <?= Template::$error ?>
        </div>
<?php } ?>
<?php if (Template::$message) { ?>
        <div id="message" class="ui-state-highlight ui-corner-all">
            <span class="float-icon ui-icon ui-icon-info"></span>
            <?= Template::$message ?>
        </div>
<?php } ?>
<?= Template::$body ?>
        </div>
        <div id="menu">
            <ul>
<?php foreach (Template::$menu as $menu) { ?>
                <li><?= $menu->toHtml() ?></li>
<?php } ?>
            </ul>
        </div>
      </div>
        <div id="header"><div class="title"><a href="<?= Controller::url('/') ?>"><?= Template::$title ?></a></div></div>
        <div id="busca"><form action="<?= Controller::url(Path::getClassMap('/').'/busca') ?>" method="post">Busca: <input name="p" size="15"/></form></div>
<?php if (Carrinho::hasCarrinho()) { ?>
        <div id="carrinho"><a class="carrinho" href="<?= Controller::url(Path::getClassMap('CarrinhoAction')) ?>"><?= count(Carrinho::restore()->getItens()) ?> Produtos</a></div>
<?php } ?>
    </body>
</html>
