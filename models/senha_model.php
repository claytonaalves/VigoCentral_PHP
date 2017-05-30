<?php

class Senha_Model extends Model {

    public function Pega_Senha($cliente) {

        $this->Conecta();

        $query = "SELECT senha FROM cadastro_clientes WHERE id='" . $cliente . "'";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Troca_Senha($cliente, $senha) {

        $this->Conecta();

        $query = "UPDATE cadastro_clientes SET senha='" . $senha . "' WHERE id='" . $cliente . "'";
        return $this->read($query);

        $this->Desconecta();
    }

}

?>