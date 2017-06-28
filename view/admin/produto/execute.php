<h1 class="titulo">Produto</h1>
<form action="<?= Controller::url(Path::getClassMap('AdminProdutoAction')) ?>" method="post">
    <label for="pesquisa">Pesquisar:</label><input id="pesquisa" type="text" name="pesquisa" />
    <button type="submit"><span class="float-icon ui-icon ui-icon-search"></span>Pesquisar</button>
</form>
<?php if (Input::get('lista')) { ?>
<table class="listagem pointer">
    <tr>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Preço</th>
    </tr>
    <?php foreach(Input::get('lista') as $produto) { ?>
        <tr onclick="window.location.href='<?= Controller::url(Path::getClassMap('AdminProdutoAction').'/'.$produto->getId()) ?>'">
            <td><?= $produto->getNome() ?></td>
            <td><?= $produto->getCategoria() ? $produto->getCategoria()->getNome() : '' ?></td>
            <td class="right"><?= number_format($produto->getPreco(), 2, ',', '.') ?></td>
        </tr>
    <?php } ?>
</table>
<?php } ?>
<p>
    <button onclick="window.location.href='<?= Controller::url(Path::getClassMap('AdminProdutoAction').'/new') ?>'"><span class="float-icon ui-icon ui-icon-plusthick"></span>Incluir</button>
</p>
