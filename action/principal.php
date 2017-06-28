<?php

class PrincipalAction {

    public function execute() {
        Controller::page('execute.php');
    }

    public function filter() {
        if (!Usuario::isLogged()) {
            foreach(Categoria::listar() as $categoria) {
                Template::addMenu($categoria->getNome(), Controller::url(Path::getClassMap('CategoriaAction').'/'.$categoria->getId()), 10);
            }
        }
    }

}

Path::map('/', 'PrincipalAction');
Path::filter('/', 'PrincipalAction');

class BuscaAction {

    public function execute() {
        $lista = Produto::procurarPorNome(Input::get('p'));
        input::set('lista', $lista);
        Controller::page('produtos.php');
    }

}

Path::map('/busca', 'BuscaAction');

class CategoriaAction {

    public function execute($id) {
        $categoria = Categoria::buscarPorId($id);
        $lista = Produto::procurarPorCategoria($categoria);
        input::set('lista', $lista);
        Controller::page('produtos.php');
    }

}

Path::map('/categoria', 'CategoriaAction');

class ProdutoAction {

    public function execute($id) {
        $produto = Produto::buscarPorId($id);
        input::set('produto', $produto);
        Controller::page('produto/exibir.php');
    }

}

Path::map('/produto', 'ProdutoAction');

class FotoAction {

    public function execute($id) {
        $foto = Foto::buscarPorId($id);
        header('Content-Type: '.$foto->getTipo());
        header('Content-Length: '.$foto->getTamanho());
        readfile(implode(DIRECTORY_SEPARATOR, ARRAY(Config::get('root-dir'), Config::get('imagem-dir'), $foto->getCaminho())));
    }

    public function mini($id) {
        $foto = Foto::buscarPorId($id);
        if ($foto == null) {
            $filename = implode(DIRECTORY_SEPARATOR, ARRAY(Config::get('root-dir'), Config::get('imagem-dir'), 'mini', 'sem_foto.png'));
            header('Content-Type: '.  filetype($filename));
            header('Content-Length: '.filesize($filename));
            readfile($filename);
            return;
        }
        header('Content-Type: image/jpeg');
        header('Content-Length: '.$foto->getTamanhoMini());
        readfile(implode(DIRECTORY_SEPARATOR, ARRAY(Config::get('root-dir'), Config::get('imagem-dir'), 'mini', $foto->getCaminho())));
    }

}

Path::map('/foto', 'FotoAction');
