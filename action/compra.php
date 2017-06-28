<?php

class CompraAction {

    public function execute() {
        Controller::page('compra/cadastro.php');
    }

    public function gravar() {
        $validar = new Validator($_POST);
        $validar->addRule(new RequiredRule('nome', 'Nome é um campo obrigatório.'));
        $validar->addRule(new RequiredRule('email', 'Email é um campo obrigatório.'));
        $validar->addRule(new RequiredRule('telefone', 'Telefone é um campo obrigatório'));
        $validar->addRule(new RequiredRule('endereco', 'Endereço é um campo obrigatório'));
        $validar->addRule(new RequiredRule('cep', 'CEP é um campo obrigatório.'));
        $validar->addRule(new RequiredRule('cartao_tipo', 'Tipo do cartão é um campo obrigatório.'));
        $validar->addRule(new RequiredRule('cartao_numero', 'Número do cartão é um campo obrigatório.'));
        $validar->addRule(new RequiredRule('cartao_vencimento', 'Vencimento do cartão é um campo obrigatório.'));
        $validar->addRule(new RequiredRule('cartao_seguranca', 'Código de Segurança é um campo obrigatório.'));
        if (!$validar->validate()) {
            foreach ($validar->getErrors() as $error) {
                Template::message($error);
            }
            $this->execute();
        }
        Template::message('Compra efetivada com sucesso.');
        $carrinho = new Carrinho();
        $carrinho->save();
        Controller::redirect();
    }

}

Path::map('/compra', 'CompraAction');
