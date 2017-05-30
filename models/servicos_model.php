<?php

class Servicos_Model extends Model {

    public function Lista_Servicos($cliente) {

        $this->Conecta();

        // Faz a pesquisa
        $query = "SELECT * FROM financeiro_planos_clientes WHERE idcliente='" . $cliente . "'";
        return $this->read($query);

        $this->Desconecta();
    }

}

?>