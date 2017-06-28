<?php

class ItemBean {

    private $produto;
    private $quantidade;

    public function  __construct($produto, $quantidade=1) {
        $this->produto = $produto;
        $this->quantidade = $quantidade;
    }

    public function getProduto() {
        return $this->produto;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

}

class Carrinho {

    private $itens = array();
    private $total = '0';

    private static $carrinho = null;

    public static function restore() {
        if (Carrinho::$carrinho != null)
            return Carrinho::$carrinho;
        Carrinho::$carrinho = new Carrinho();
        if (!$_COOKIE['carrinho'])
            return Carrinho::$carrinho;
        $txt = $_COOKIE['carrinho'];
        $list = split(',', $txt);
        for($i = 0; $i < count($list); $i++) {
            $a = $list[$i];
            list ($id, $qtde) = split('-', $a);
            $produto = Produto::buscarPorId($id);
            Carrinho::$carrinho->itens[$id] = new ItemBean($produto, $qtde);
            //$carrinho->total += $produto->getPreco() * $qtde;
            Carrinho::$carrinho->total = bcadd(Carrinho::$carrinho->total, bcmul($produto->getPreco(), $qtde));
        }
        return Carrinho::$carrinho;
    }

    public static function hasCarrinho() {
        if (!isset($_COOKIE['carrinho']))
                return false;
        return strlen(trim($_COOKIE['carrinho'])) > 0;
    }

    public function save() {
        $txt = '';
        $step = '';
        foreach($this->itens as $item) {
            $txt .= $step.$item->getProduto()->getId().'-'.$item->getQuantidade();
            $step = ',';
        }
        setcookie('carrinho', $txt, time() + 30 * 24 * 60 * 60, Config::get('base-path').'/');
    }

    public function addProduto($produto) {
        $this->itens[$produto->getId()] = new ItemBean($produto);
    }

    public function hasProduto($produto) {
        if (!is_numeric($produto))
            $produto = $produto->getId();
        return array_key_exists($produto, $this->itens);
    }

    public function removeProduto($produto) {
        if (!is_numeric($produto))
            $produto = $this->hasProduto($produto);
        unset($this->itens[$produto]);
    }

    public function getItem($produto) {
        if (!is_numeric($produto))
            $produto = $this->hasProduto($produto);
        return $this->itens[$produto];
    }

    public function getItens() {
        return $this->itens;
    }

    public function getTotal() {
        return $this->total;
    }

}
