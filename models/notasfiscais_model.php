<?php

class NotasFiscais_Model extends Model {

    public function Lista_Notas($cliente, $cnpjcpf) {

        // Remove pontos, traços e adiciona '000' caso for CPF
        $cnpjcpf = str_replace("/", "", $cnpjcpf);
        $cnpjcpf = str_replace("-", "", $cnpjcpf);
        $cnpjcpf = str_replace(".", "", $cnpjcpf);

        if (strlen($cnpjcpf) < 14)
            $cnpjcpf = "000" . $cnpjcpf;

        $this->Conecta();

        // Faz a pesquisa
        $query = "SELECT * FROM financeiro_nf_arquivo_mestre WHERE codigo='" . $cliente . "' AND cnpjcpf='" . $cnpjcpf . "' AND situacao='N' ORDER BY ano_mes DESC LIMIT 12";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Nota_Fiscal_Mestre($arquivo, $cnpjcpf, $numero) {

        $this->Conecta();

        // Faz a pesquisa
        $query = "SELECT * FROM financeiro_nf_arquivo_mestre WHERE nome_arquivo='" . $arquivo . "' AND cnpjcpf='" . $cnpjcpf . "' AND numero='" . $numero . "' AND situacao='N' LIMIT 1";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Nota_Fiscal_Dados($arquivo, $cnpjcpf, $numero) {

        $this->Conecta();

        // Faz a pesquisa
        $query = "SELECT * FROM financeiro_nf_arquivo_dados WHERE nome_arquivo='" . $arquivo . "' AND cnpjcpf='" . $cnpjcpf . "' AND sequencial='" . $numero . "' LIMIT 1";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Nota_Fiscal_Item($arquivo, $cnpjcpf, $numero) {

        $this->Conecta();

        // Faz a pesquisa
        $query = "SELECT * FROM financeiro_nf_arquivo_item WHERE nome_arquivo='" . $arquivo . "' AND cnpjcpf='" . $cnpjcpf . "' AND numero='" . $numero . "' AND situacao='N'";
        return $this->read($query);

        $this->Desconecta();
    }

}

?>