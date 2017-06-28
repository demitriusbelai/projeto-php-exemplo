<?php

class LoginAction {
    public function __construct() {

    }
    public function execute() {
        Controller::Page('admin/'.get_class($this).'/execute.php');
    }
    public function open() {
        if (Usuario::isLogged()) {
            Controller::redirect(Path::getClassMap('AdminAction'));
        }
        if (($usuario = Usuario::procurarPorNome($_POST['usuario'])) == NULL) {
            Template::message("Usuário não encontrado.");
            $this->execute();
        }
        if (!$usuario->verificaSenha($_POST['senha'])) {
            Template::message("Senha inválida.");
            $this->execute();
        }
        $usuario->login();
        Controller::redirect(Path::getClassMap('AdminAction'));
    }

    public function logout() {
        unset($_SESSION['usuario']);
        session_destroy();
        Controller::redirect('/');
    }

    public function filter() {
        if (Controller::getAction() !== get_class($this) && !Usuario::isLogged()) {
            Controller::redirect(Path::getClassMap('LoginAction'));
            exit();
        }
        if (Usuario::isLogged()) {
            Template::addMenu('Logout', Controller::url(Path::getClassMap('LoginAction').'/logout'), 1000);
        }
    }
}

Path::map('/admin/login', 'LoginAction');
Path::filter('/admin/.*', 'LoginAction');
