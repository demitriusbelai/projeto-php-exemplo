<?php

class Produto {

    private $id = null;
    private $nome;
    private $categoria;
    private $descricao;
    private $quantidade;
    private $preco;
    private $foto;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
    }

    public function getFoto() {
        return $this->foto;
    }

    /*public function setFoto($foto) {
        $this->foto = $foto;
    }*/

    public function save() {
        if ($this->id == null) {
            $stmt = Database::get()->prepare('INSERT INTO produto (nome, id_categoria, descricao, quantidade, preco) VALUES (:nome, :IdCategoria, :descricao, :quantidade, :preco)');
            $stmt->execute(Array('nome' => $this->nome, 'IdCategoria' => ($this->categoria ? $this->categoria->getId() : null), 'descricao' => $this->descricao, 'quantidade' => $this->quantidade, 'preco' => $this->preco));
            $this->id = Database::get()->lastInsertId();
        } else {
            $stmt = Database::get()->prepare('UPDATE produto SET nome = :nome, id_categoria = :IdCategoria, descricao = :descricao, quantidade = :quantidade, preco = :preco WHERE id = :id');
            $stmt->execute(Array('id' => $this->id, 'nome' => $this->nome, 'IdCategoria' => ($this->categoria ? $this->categoria->getId() : null), 'descricao' => $this->descricao,  'quantidade' => $this->quantidade, 'preco' => $this->preco));
        }
    }

    public function delete() {
        $stmt = Database::get()->prepare('DELETE FROM produto WHERE id = :id');
        $stmt->execute(Array('id' => $this->id));
    }

    private static function novo($row) {
        $produto = new Produto();
        $produto->id = $row['id'];
        ObjectPool::put('Produto', $produto->id, $produto);
        $produto->nome = $row['nome'];
        $produto->categoria = Categoria::buscarPorId($row['id_categoria']);
        $produto->descricao = $row['descricao'];
        $produto->quantidade = $row['quantidade'];
        $produto->preco = $row['preco'];
        $produto->foto = Foto::buscarPorId($row['id_foto']);
        return $produto;
    }

    public static function procurarPorNome($nome) {
        $stmt = Database::get()->prepare('SELECT * FROM produto WHERE nome LIKE :nome');
        $stmt->execute(array('nome' => '%'.$nome.'%'));
        $ret = Array();
        while ($row = $stmt->fetch()) {
            $produto = Produto::novo($row);
            $ret[] = $produto;
        }
        return $ret;
    }

    public static function procurarPorCategoria($categoria) {
        $stmt = Database::get()->prepare('SELECT * FROM produto WHERE id_categoria = :categoria');
        $stmt->execute(array('categoria' => $categoria->getId()));
        $ret = Array();
        while ($row = $stmt->fetch()) {
            $produto = Produto::novo($row);
            $ret[] = $produto;
        }
        return $ret;
    }

    public static function buscarPorId($id) {
        if (($produto = ObjectPool::get('Produto', $id))) {
            return $produto;
        }
        $stmt = Database::get()->prepare('SELECT * FROM produto WHERE id = :id');
        $stmt->execute(array('id' => $id));
        if (!($row = $stmt->fetch())) {
            return null;
        }
        $produto = Produto::novo($row);
        return $produto;
    }

    public function listarFotos() {
        return Foto::procurarPorProduto($this);
    }

}
