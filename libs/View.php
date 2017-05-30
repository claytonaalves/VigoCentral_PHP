<?php

class View {

    // Views sem o JQuery
    public function render($name) {
        require 'views/inc.head.php';
        require 'views/' . $name . '.php';
        require 'views/inc.footer.php';
    }

    // Views com o JQuery
    public function renderJQ($name) {
        require 'views/inc.head.jq.php';
        require 'views/inc.header.php';
        require 'views/' . $name . '.php';
        require 'views/inc.footer.php';
    }

    // Views sem cabeçalho e rodapé
    public function renderLIMPO($name) {
        require 'views/' . $name . '.php';
    }

    // View sem o JQuery para WSConfig
    public function renderConfig($name) {
        require 'views/inc.head.wsconfig.php';
        require 'views/inc.header.wsconfig.php';
        require 'views/' . $name . '.php';
        require 'views/inc.footer.php';
    }

}

?>