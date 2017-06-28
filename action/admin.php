<?php

class AdminAction {

    public function execute() {
        Controller::page('admin/execute.php');
    }

}

Path::map('/admin/', 'AdminAction');

class AdminProdutoAction {

    public function execute($arg=null) {
        if ($arg) {
            if ($arg != 'new') {
                $produto = Produto::buscarPorId($arg);
                Input::set('id', $produto->getId());
                Input::set('nome', $produto->getNome());
                if ($produto->getCategoria())
                    Input::set('categoria', $produto->getCategoria()->getId());
                Input::set('quantidade', $produto->getQuantidade());
                Input::set('preco', number_format($produto->getPreco(), 2, ',', '.'));
                Input::set('descricao', $produto->getDescricao());
            }
            Input::set('categorias', Categoria::listar());
            Controller::page('admin/produto/cadastro.php');
        }
        if (Input::get('pesquisa')) {
            $lista = Produto::procurarPorNome(Input::get('pesquisa'));
            Input::set('lista', $lista);
        }
        Controller::page('admin/produto/execute.php');
    }

    public function gravar() {
        $validar = new Validator($_POST);
        $validar->addRule(new RequiredRule('nome', 'Nome é um campo obrigatório.'));
        $validar->addRule(new RequiredRule('quantidade', 'Quantidade é um campo obrigatório.'));
        $validar->addRule(new RequiredRule('preco', 'Preço é um campo obrigatório'));
        $validar->addRule(new RequiredRule('descricao', 'Descrição é um campo obrigatório'));
        $validar->addRule(new NumberRule('quantidade', 'Quantidade é inválida.'));
        $validar->addRule(new MoneyRule('preco', 'Preço inválido.', ','));
        if (!$validar->validate()) {
            foreach ($validar->getErrors() as $error) {
                Template::message($error);
            }
            Controller::page('admin/produto/cadastro.php');
        }
        if (Input::get('id')) {
            $produto = Produto::buscarPorId(Input::get('id'));
        } else {
            $produto = new Produto();
        }
        $produto->setNome(Input::get('nome'));
        if (Input::get('categoria'))
            $produto->setCategoria(Categoria::buscarPorId(Input::get('categoria')));
        $produto->setQuantidade(Input::get('quantidade'));
        $produto->setPreco(Input::get('preco_number'));
        $produto->setDescricao(Input::get('descricao'));
        $produto->save();
        Template::message('Produto salvo com sucesso.');
        Controller::redirect(Path::getClassMap('AdminProdutoAction'));
    }

    public function deletar() {
        $produto = Produto::buscarPorId(Input::get('id'));
        try {
            $produto->delete();
        } catch (Exception $e) {
            Template::error($e->getMessage());
            $this->execute(Input::get('id'));
        }
        Template::message('Produto removido!');
        Controller::redirect(Path::getClassMap('AdminProdutoAction'));
    }

    public function filter() {
        if (Usuario::isLogged()) {
            Template::addMenu('Produto', Controller::url(Path::getClassMap('AdminProdutoAction')), 10);
        }
    }

}

Path::map('/admin/produto', 'AdminProdutoAction');
Path::filter('/admin/.*', 'AdminProdutoAction');

class AdminCategoriaAction {

    public function execute($arg=null) {
        if ($arg) {
            if ($arg != 'new') {
                $categoria = Categoria::buscarPorId($arg);
                Input::set('id', $categoria->getId());
                Input::set('nome', $categoria->getNome());
            }
            Controller::page('admin/categoria/cadastro.php');
        }
        Input::set('lista', Categoria::listar());
        Controller::page('admin/categoria/execute.php');
    }

    public function gravar() {
        $validar = array();
        $validar = new Validator($_POST);
        $validar->addRule(new RequiredRule('nome', 'Nome é um campo obrigatório.'));
        if (!$validar->validate()) {
            foreach ($validar->getErrors() as $error) {
                Template::message($error);
            }
            Controller::page('admin/categoria/cadastro.php');
        }
        if (Input::get('id')) {
            $categoria = Categoria::buscarPorId(Input::get('id'));
        } else {
            $categoria = new Categoria();
        }
        $categoria->setNome(input::get('nome'));
        $categoria->save();
        Template::message('Categoria salva com sucesso.');
        Controller::redirect(Path::getClassMap('AdminCategoriaAction'));
    }

    public function deletar() {
        $categoria = Categoria::buscarPorId(Input::get('id'));
        try {
            $categoria->delete();
        } catch (Exception $e) {
            Template::error($e->getMessage());
            $this->execute(Input::get('id'));
        }
        Template::message('Categoria removida!');
        Controller::redirect(Path::getClassMap('AdminCategoriaAction'));
    }

    public function filter() {
        if (Usuario::isLogged()) {
            Template::addMenu('Categoria', Controller::url(Path::getClassMap('AdminCategoriaAction')), 10);
        }
    }

}

Path::map('/admin/categoria', 'AdminCategoriaAction');
Path::filter('/admin/.*', 'AdminCategoriaAction');

class AdminFotoAction {

    public function execute($arg=null) {
        if ($arg) {
            $produto = Produto::buscarPorId($arg);
            Input::set('id', $produto->getId());
            Input::set('produto', $produto);
            Input::set('lista', $produto->listarFotos());
            Controller::page('admin/foto/execute.php');
        }
    }

    public function enviar() {
        $produto = Produto::buscarPorId(Input::get('produto'));
        foreach ($_FILES['imagem']['name'] as $key => $value) {
            $imagem = array();
            foreach ($_FILES['imagem'] as $a_key => $a_value) {
                $imagem[$a_key] = $a_value[$key];
            }
            $this->fotoHelper($produto, $imagem);
        }
        Controller::redirect(Path::getClassMap('AdminFotoAction').'/'.$produto->getId());
    }

    public function deletar($id) {
        $foto = Foto::buscarPorId($id);
        $produto = $foto->getProduto();
        $dir_imagem = Config::get('root-dir').DIRECTORY_SEPARATOR.Config::get('imagem-dir');
        unlink($dir_imagem.DIRECTORY_SEPARATOR.$foto->getCaminho());
        $dir_imagem = Config::get('root-dir').DIRECTORY_SEPARATOR.Config::get('imagem-dir').DIRECTORY_SEPARATOR.'mini';
        unlink($dir_imagem.DIRECTORY_SEPARATOR.$foto->getCaminho());
        $foto->delete();
        Controller::redirect(Path::getClassMap('AdminFotoAction').'/'.$foto->getProduto()->getId());
    }

    public function capa($id) {
        $foto = Foto::buscarPorId($id);
        $foto->markDefault();
        $this->execute($foto->getProduto()->getId());
        Controller::redirect(Path::getClassMap('AdminFotoAction').'/'.$foto->getProduto()->getId());
    }

    private function fotoHelper($produto, $imagem) {
        if ($imagem['error'] != UPLOAD_ERR_OK) {
            Template::message("Erro [".$imagem['error']."] no arquivo '".$imagem['name']."'");
        }
        $foto = new Foto();
        $foto->setTipo($imagem['type']);
        $foto->setTamanho($imagem['size']);
        $foto->setProduto($produto);
        $foto->save();
        $foto->setCaminho($produto->getId().DIRECTORY_SEPARATOR.$foto->getid());
        $dir_imagem = Config::get('root-dir').DIRECTORY_SEPARATOR.Config::get('imagem-dir');
        $dir = $dir_imagem.DIRECTORY_SEPARATOR.$produto->getId();
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        $ret = move_uploaded_file($imagem['tmp_name'], $dir_imagem.DIRECTORY_SEPARATOR.$foto->getCaminho());
        $this->salvarMini($foto);
        if ($ret) {
            $foto->save();
            Template::message("Foto '".$imagem['name']."' enviada.");
        } else {
            $foto->delete();
            Template::message("Erro ao copiar arquivo '".$imagem['name']."'.");
        }
    }

    private function salvarMini($foto) {
        $filename = Config::get('root-dir').DIRECTORY_SEPARATOR.Config::get('imagem-dir').DIRECTORY_SEPARATOR.$foto->getCaminho();
        $width = 128;
        $height = 128;

        list($width_orig, $height_orig) = getimagesize($filename);

        $ratio_orig = $width_orig / $height_orig;
        if ($width / $height > $ratio_orig) {
            $width = $height * $ratio_orig;
        } else {
            $height = $width / $ratio_orig;
        }

        $image_p = imagecreatetruecolor($width, $height);

	if ($foto->getTipo() == 'image/jpg' || $foto->getTipo() == 'image/jpeg') {
            $image = imagecreatefromjpeg($filename);
        } else {
            $image = imagecreatefrompng($filename);
        }
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        $dir_imagem = Config::get('root-dir').DIRECTORY_SEPARATOR.Config::get('imagem-dir').DIRECTORY_SEPARATOR.'mini';
        $dir = $dir_imagem.DIRECTORY_SEPARATOR.$foto->getProduto()->getId();
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        imagejpeg($image_p, $dir_imagem.DIRECTORY_SEPARATOR.$foto->getCaminho());
        imagedestroy($image_p);
        imagedestroy($image);
        $foto->setTamanhoMini(filesize($dir_imagem.DIRECTORY_SEPARATOR.$foto->getCaminho()));
    }

}

Path::map('/admin/foto', 'AdminFotoAction');
