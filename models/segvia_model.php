<?php

class Segvia_Model extends Model {

    public function Pesquisa_Banco($id) {
        $this->Conecta();

        $query = "SELECT id, nomebanco, agencia, conta, convenio, complemento, codigoescritural, codigotransmissao, tipo, cedente, idempresa FROM financeiro_bancos WHERE id='" . $id . "' LIMIT 1";
        $this->result = mysql_query($query);
        $row = mysql_fetch_row($this->result);

        $this->Desconecta();

        return $row; // Array
    }

    public function Pesquisa_Boleto($id, $idcliente) {
        $this->Conecta();

        $query = "SELECT id, id_banco, id_cliente, id_empresa, nome, cpfcgc, endereco, cidade, bairro, uf, cep, referencia, numero, nossonumero, seunumero, emissao, vencimento, valor, obs, grupo_cliente, plano_conta, pago, pago_agencia, pago_data, pago_valor, pago_credito, pago_tarifa, pago_local, linhadigitavel, codigobarras, banco, agencia, conta, convenio, complemento, numerobanco, localpagamento, codigocedente, carteira, ativo, considerado, enviado, nf_arquivo, nf_numero, nf_situacao FROM financeiro_boletos WHERE id='" . $id . "' AND id_cliente='" . $idcliente . "' LIMIT 1";
        $this->result = mysql_query($query);
        $row = mysql_fetch_row($this->result);

        $this->Desconecta();

        return $row; // Array
    }

    public function Pesquisa_Cliente($id) {
        $this->Conecta();
        /*
          $query = "SELECT * FROM cadastro_clientes WHERE id='" . $id . "' LIMIT 1";
          $this->result = mysql_query($query);
          $row = mysql_fetch_row($this->result);
         */
        $query = "SELECT * FROM cadastro_clientes WHERE id='" . $id . "' LIMIT 1";

        return $this->read($query);

        $this->Desconecta();

        //return $row; // Array
    }

    public function Gera_Boleto($boleto) {
        $this->Conecta();

        $query = "INSERT INTO financeiro_boletos (id_banco, id_cliente, id_empresa, nome, cpfcgc, endereco, cidade, bairro, uf, cep, referencia, numero, nossonumero, "
                . "seunumero, emissao, vencimento, valor, obs, grupo_cliente, plano_conta, pago, pago_agencia, pago_data, pago_valor, pago_credito, pago_tarifa, "
                . "pago_local, linhadigitavel, codigobarras, banco, agencia, conta, convenio, complemento, numerobanco, localpagamento, codigocedente, carteira, "
                . "ativo, considerado, enviado, nf_arquivo, nf_numero, nf_situacao) VALUES ('$boleto->id_banco', '$boleto->id_cliente', '$boleto->id_empresa', '$boleto->nome', '$boleto->cpfcgc', '$boleto->endereco', '$boleto->cidade', '$boleto->bairro', '$boleto->uf', '$boleto->cep', '$boleto->referencia', '$boleto->numero', '$boleto->nossonumero', "
                . "'$boleto->seunumero', '$boleto->emissao', '$boleto->vencimento', '$boleto->valor', '$boleto->obs', '$boleto->grupo_cliente', '$boleto->plano_conta', '$boleto->pago', '$boleto->pago_agencia', '$boleto->pago_data', '$boleto->pago_valor', '$boleto->pago_credito', '$boleto->pago_tarifa', "
                . "'$boleto->pago_local', '$boleto->linhadigitavel', '$boleto->codigobarras', '$boleto->banco', '$boleto->agencia', '$boleto->conta', '$boleto->convenio', '$boleto->complemento', '$boleto->numerobanco', '$boleto->localpagamento', '$boleto->codigocedente', '$boleto->carteira', "
                . "'$boleto->ativo', '$boleto->considerado', '$boleto->enviado', '$boleto->nf_arquivo', '$boleto->nf_numero', '$boleto->nf_situacao')";

        $this->result = mysql_query($query);

        $this->Desconecta();
    }

    public function Pesquisa_ProximoBoleto($idbanco) {
        $this->Conecta();

        $query = "SELECT MAX(numero)+1 FROM financeiro_boletos WHERE id_banco='" . $idbanco . "'";
        $this->result = mysql_query($query);
        $row = mysql_fetch_row($this->result);

        $this->Desconecta();

        return $row; // Array
    }

}

?>