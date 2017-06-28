<?php

class Error404 {

    public function execute() {
        Controller::page('error/404.php');
    }

}

Path::map('ERROR_404', 'Error404');
