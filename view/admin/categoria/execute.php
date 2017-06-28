<h1 class="titulo">Categoria</h1>
<table class="listagem pointer">
    <tr>
        <th>Nome</th>
    </tr>
    <?php foreach(Input::get('lista') as $categoria) { ?>
        <tr onclick="window.location.href='<?= Controller::url(Path::getClassMap('AdminCategoriaAction').'/'.$categoria->getId()) ?>'">
            <td><?= $categoria->getNome() ?></td>
        </tr>
    <?php } ?>
</table>
<p>
    <button onclick="window.location.href='<?= Controller::url(Path::getClassMap('AdminCategoriaAction').'/new') ?>'"><span class="float-icon ui-icon ui-icon-plusthick"></span>Incluir</button>
</p>
