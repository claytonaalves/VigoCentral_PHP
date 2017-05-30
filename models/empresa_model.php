<?php

class Empresa_Model extends Model {

    public function Dados_Empresa($id_empresa) {

        $this->Conecta();

        // Faz a pesquisa
        $query = "SELECT * FROM sistema_empresas WHERE id='" . $id_empresa . "'";
        return $this->read($query);

        $this->Desconecta();
    }

}

?>