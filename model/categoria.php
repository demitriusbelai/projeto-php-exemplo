<?php

class Categoria {

    private $id = null;
    private $nome;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function save() {
        if ($this->id == null) {
            $stmt = Database::get()->prepare('INSERT INTO categoria (nome) VALUES (:nome)');
            $stmt->execute(Array('nome' => $this->nome));
            $this->id = Database::get()->lastInsertId();
        } else {
            $stmt = Database::get()->prepare('UPDATE categoria SET nome = :nome WHERE id = :id');
            $stmt->execute(Array('id' => $this->id, 'nome' => $this->nome));
        }
    }

    public function delete() {
        if (count($this->listarProdutos()) > 0)
            throw new Exception('Existe produtos cadastrados nesta categoria.');
        $stmt = Database::get()->prepare('DELETE FROM categoria WHERE id = :id');
        $stmt->execute(Array('id' => $this->id));
    }

    public function listarProdutos() {
        return Produto::procurarPorCategoria($this);
    }

    public static function listar() {
        $stmt = Database::get()->prepare('SELECT * FROM categoria ORDER BY nome');
        $stmt->execute();
        $ret = array();
        while ($row = $stmt->fetch()) {
            $categoria = Categoria::novo($row);
            $ret[] = $categoria;
        }
        return $ret;
    }

    private static function novo($row) {
        $categoria = new Categoria();
        $categoria->id = $row['id'];
        ObjectPool::put('Categoria', $categoria->id, $categoria);
        $categoria->nome = $row['nome'];
        return $categoria;
    }

    public static function buscarPorId($id) {
        if (($categoria = ObjectPool::get('Categoria', $id))) {
            return $categoria;
        }
        $stmt = Database::get()->prepare('SELECT * FROM categoria WHERE id = :id');
        $stmt->execute(array('id' => $id));
        if (!($row = $stmt->fetch())) {
            return null;
        }
        $categoria = Categoria::novo($row);
        return $categoria;
    }

}
