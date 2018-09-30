<?php

class Sessao_Model extends Model {

    public function Pesquisa_Credenciais($login, $senha = null) {

        $this->Conecta();

        if ($senha != null) {
            $whereSenha = "AND senha='" . $senha . "'";
        } else {
            $whereSenha = "";
        }

        $query = "SELECT COUNT(*) AS total FROM cadastro_clientes WHERE login='" . $login . "' $whereSenha";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Usuario_Existe($login) {
        $this->Conecta();

        $query = "SELECT COUNT(*) AS total FROM cadastro_clientes WHERE login='" . $login . "'";
        $result_set = $this->read($query);
        $result = ($result_set[0][total] != 0);

        if (!$result) {
            $query = "SELECT COUNT(*) AS total FROM mikrotik_erp.radcheck WHERE username='$login' LIMIT 1";
            $result_set = $this->read($query);
            $result = ($result_set[0][total] != 0);
        }

        $this->Desconecta();

        return $result;
    }

    public function Valida_Credenciais(&$login, $senha) {
        $this->Conecta();

        $query = "SELECT COUNT(*) AS total FROM cadastro_clientes WHERE login='$login' AND senha='$senha'";
        $result_set = $this->read($query);
        $result = ($result_set[0][total] != 0);

        if (!$result) {
            $query = "
                SELECT rad.id_cliente, cli.login
                FROM mikrotik_erp.radcheck rad
                LEFT JOIN vigo_erp.cadastro_clientes cli ON (cli.id=rad.id_cliente)
                WHERE
                    username='$login'
                    AND (
                        ((attribute='MD5-Password') AND (value=MD5('$senha')))
                        OR
                        ((attribute='ClearText-Password') AND (value='$senha'))
                    )
                LIMIT 1
            ";
            $result_set = $this->read($query);
            $result = (count($result_set) > 0);
            if ($result) {
                $login = $result_set[0][login];
            }
        }

        $this->Desconecta();
        return $result;
    }

    public function Dados_Cliente($login) {

        $this->Conecta();

        $query = "SELECT cadastro_clientes.id, cadastro_clientes.idempresa, cadastro_clientes.nome, cadastro_clientes.sexo, cadastro_clientes.endereco, cadastro_clientes.bairro, cadastro_clientes.cep, cadastro_clientes.cpfcgc, cadastro_clientes.cidade, cadastro_clientes.uf, cadastro_clientes.telefone, cadastro_clientes.celular, cadastro_clientes.email, cadastro_clientes.dt_entrada, cadastro_clientes.login, cadastro_clientes.senha, sistema_empresas.fantasia, sistema_empresas.foto FROM cadastro_clientes, sistema_empresas WHERE cadastro_clientes.idempresa = sistema_empresas.id AND cadastro_clientes.login='" . $login . "' LIMIT 1";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Tipo_Pessoa($codigo) {

        $this->Conecta();

        $query = "SELECT tipo FROM cadastro_clientes WHERE id = '" . $codigo . "' LIMIT 1";
        return $this->read($query);

        $this->Desconecta();
    }

}

?>
