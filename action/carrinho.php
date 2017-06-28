<?php

class CarrinhoAction {

    public function execute() {
        Input::set('carrinho', Carrinho::restore());
        Controller::page('carrinho/exibir.php');
    }

    public function add($id) {
        $carrinho = Carrinho::restore();
        $carrinho->addProduto(Produto::buscarPorId($id));
        $carrinho->save();
        Controller::redirect(Path::getClassMap('CarrinhoAction'));
    }

    public function remove($id) {
        $carrinho = Carrinho::restore();
        $carrinho->removeProduto($id);
        $carrinho->save();
        Controller::redirect(Path::getClassMap('CarrinhoAction'));
    }

    public function atualizar() {
        $carrinho = Carrinho::restore();
        foreach($carrinho->getItens() as $item) {
            $qtde = Input::get('qtde_'.$item->getProduto()->getId());
            //echo $qtde.",";
            if (is_numeric($qtde) && $qtde > 0)
                $item->setQuantidade(Input::get('qtde_'.$item->getProduto()->getId()));
            else
                Template::message("Quantidade do produto '{$item->getProduto()->getName()}' inválida.");
        }
        $carrinho->save();
        Controller::redirect(Path::getClassMap('CarrinhoAction'));
    }

    public function limpar() {
        $carrinho = new Carrinho();
        $carrinho->save();
        Controller::redirect();
    }

}

Path::map('/carrinho', 'CarrinhoAction');
