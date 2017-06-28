<?php
Template::addScript('
    $().ready(function() {
        $("#usuario").focus();
    });
');
?>
<form action="<?= Controller::url(Path::getClassMap('LoginAction').'/open') ?>" method="post">
    <label for="usuario">Usuário:</label><input id="usuario" type="text" name="usuario" /><br />
    <label for="senha">Senha:</label><input id="senha" type="password" name="senha" /><br />
    <label>&nbsp;</label><button type="submit">Enviar</button>
</form>
