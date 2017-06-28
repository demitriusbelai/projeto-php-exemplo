<?php

class Foto {

    private $id = null;
    private $caminho;
    private $tipo;
    private $tamanho;
    private $tamanhoMini;
    private $produto;

    public function getId() {
        return $this->id;
    }

    public function getCaminho() {
        return $this->caminho;
    }

    public function setCaminho($caminho) {
        $this->caminho = $caminho;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getTamanho() {
        return $this->tamanho;
    }

    public function setTamanho($tamanho) {
        $this->tamanho = $tamanho;
    }

    public function getTamanhoMini() {
        return $this->tamanhoMini;
    }

    public function setTamanhoMini($tamanhoMini) {
        $this->tamanhoMini = $tamanhoMini;
    }

    public function getProduto() {
        return $this->produto;
    }

    public function setProduto($produto) {
        $this->produto = $produto;
    }

    public function save() {
        if ($this->id == null) {
            $stmt = Database::get()->prepare('INSERT INTO foto (caminho, tipo, tamanho, tamanho_mini, id_produto) VALUES (:caminho, :tipo, :tamanho, :tamanhomini, :produto)');
            $stmt->execute(Array('caminho' => $this->caminho, 'tipo' => $this->tipo, 'tamanho' => $this->tamanho, 'tamanhomini' => $this->tamanhoMini, 'produto' => $this->produto->getId()));
            $this->id = Database::get()->lastInsertId();
        } else {
            $stmt = Database::get()->prepare('UPDATE foto SET caminho = :caminho, tipo = :tipo, tamanho = :tamanho, tamanho_mini = :tamanhomini WHERE id = :id');
            $stmt->execute(Array('id' => $this->id, 'caminho' => $this->caminho, 'tipo' => $this->tipo, 'tamanho' => $this->tamanho, 'tamanhomini' => $this->tamanhoMini));
        }
    }

    public function delete() {
        $stmt = Database::get()->prepare('DELETE FROM foto WHERE id = :id');
        $stmt->execute(Array('id' => $this->id));
    }

    public function markDefault() {
        $stmt = Database::get()->prepare('UPDATE produto SET id_foto = :foto WHERE id = :id');
        $stmt->execute(Array('id' => $this->produto->getId(), 'foto' => $this->id));
    }

    public static function buscarPorId($id) {
        if (($foto = ObjectPool::get('Foto', $id))) {
            return $foto;
        }
        $stmt = Database::get()->prepare('SELECT * FROM foto WHERE id = :id');
        $stmt->execute(array('id' => $id));
        if (!($row = $stmt->fetch())) {
            return null;
        }
        $foto = Foto::novo($row);
        return $foto;
    }

    public static function novo($row) {
        $foto = new Foto();
        $foto->id = $row['id'];
        ObjectPool::put('Foto', $foto->id, $foto);
        $foto->caminho = $row['caminho'];
        $foto->tipo = $row['tipo'];
        $foto->tamanho = $row['tamanho'];
        $foto->produto = Produto::buscarPorId($row['id_produto']);
        return $foto;
    }

    public static function procurarPorProduto($produto) {
        $stmt = Database::get()->prepare('SELECT * FROM foto WHERE id_produto = :produto');
        $stmt->execute(array('produto' => $produto->getId()));
        $ret = Array();
        while ($row = $stmt->fetch()) {
            $foto = Foto::novo($row);
            $ret[] = $foto;
        }
        return $ret;
    }

}
