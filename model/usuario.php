<?php

class Usuario {

    private $id = null;
    private $nome;
    private $senha;
    private $ultimoLogin;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setPlainSenha($senha) {
        $this->$senha = crypt($senha, Util::random_salt());
    }

    public function getUltimoLogin() {
        return $this->ultimoLogin;
    }

    public function setUltimoLogin($ultimoLogin) {
        $this->ultimoLogin = $ultimoLogin;
    }

    public function verificaSenha($senha) {
        $alterar_senha = false;
        if ($this->senha == md5($senha)) {
            $alterar_senha = true;
        } else if (crypt($senha, $this->senha) != $this->senha) {
            return false;
        }
        if ($alterar_senha) {
            $this->setPlainSenha($senha);
        }
        return true;
    }

    public function save() {
        if ($this->id == null) {
            $stmt = Database::get()->prepare('INSERT INTO usuario (nome, senha) VALUES (:nome, :senha)');
            $stmt->execute(Array('nome' => $this->nome, 'senha' => $this->senha));
            $this->id = Database::get()->lastInsertId();
        } else {
            $stmt = Database::get()->prepare('UPDATE usuario SET nome = :nome, senha = :senha, ultimo_login = :ultimo_login WHERE id = :id');
            $stmt->execute(Array('id' => $this->id, 'nome' => $this->nome, 'senha' => $this->senha, 'ultimo_login' => $this->ultimoLogin->format('Y-m-d H:i:s')));
        }
    }

    public function login() {
        $ultimoLogin = $this->ultimoLogin;
        $this->ultimoLogin = new DateTime();
        $this->save();
        $this->ultimoLogin = $ultimoLogin;
        $_SESSION['usuario'] = $this;
    }

    public static function isLogged() {
        if (session_id() == '') {
            session_start();
        }
        return array_key_exists('usuario', $_SESSION) && $_SESSION['usuario'] instanceof Usuario;
    }

    public static function getLogged() {
        return Usuario::isLogged() ? $_SESSION['usuario'] : null;
    }

    public static function procurarPorNome($nome) {
        $stmt = Database::get()->prepare('SELECT * FROM usuario WHERE nome = :usuario');
        $stmt->execute(array('usuario' => $nome));
        if (!($row = $stmt->fetch())) {
            return null;
        }
        $usuario = new Usuario();
        $usuario->id = $row['id'];
        $usuario->nome = $row['nome'];
        $usuario->senha = $row['senha'];
        $usuario->ultimoLogin = new DateTime($row['ultimo_login']);
        return $usuario;
    }

}
