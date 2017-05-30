<?php

class Contratos_Model extends Model {

    public function Lista_Contratos($cliente) {

        $this->Conecta();

        // Faz a pesquisa
        $query = "SELECT * FROM cadastro_ged WHERE id_cliente='" . $cliente . "' AND descricao LIKE '%CONTRATO%'";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Exibir_Contrato($cliente, $contrato) {

        $this->Conecta();

        // Faz a pesquisa
        $query = "SELECT * FROM cadastro_ged WHERE id_cliente='" . $cliente . "' AND id='" . $contrato . "'";
        return $this->read($query);

        $this->Desconecta();
    }

}

?>