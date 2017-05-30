<?php

class Boletos_Model extends Model {

    public function Lista_Boletos($cliente) {

        $this->Conecta();

        $query = "SELECT id, id_cliente, nossonumero, referencia, vencimento, valor, pago_data, pago_valor FROM financeiro_boletos WHERE id_cliente = " . $cliente . " AND ativo = 'S' ORDER BY pago ASC, pago_data DESC, vencimento DESC";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Referencia_Boleto($id_banco, $nosso_numero) {

        $this->Conecta();

        $query = "SELECT referencia FROM financeiro_boletos WHERE id_banco = '" . $id_banco . "' AND nossonumero = '" . $nosso_numero . "' LIMIT 1";
        return $this->read($query);

        $this->Desconecta();
    }

}

?>