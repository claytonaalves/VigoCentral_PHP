<?php

class Config_Model extends Model {

    public function Sistema_Config($chave) {

        $this->Conecta();

        // Faz a pesquisa
        $query = "SELECT * FROM sistema_config WHERE chave = '" . $chave . "' LIMIT 1";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Chave_Add($chave, $valor, $descricao) {

        $this->Conecta();

        // Faz a pesquisa
        $query = "INSERT INTO sistema_config VALUES ('" . $chave . "', '" . $valor . "', '" . $descricao . "')";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Chave_Edit($chave, $valor) {

        $this->Conecta();

        // Faz a pesquisa
        $query = "UPDATE sistema_config SET valor='" . $valor . "' WHERE  chave='" . $chave . "' LIMIT 1";
        return $this->read($query);

        $this->Desconecta();
    }

}

?>