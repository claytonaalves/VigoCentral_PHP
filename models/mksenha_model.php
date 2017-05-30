<?php

class MkSenha_Model extends Model {

    public function Lista_MkLogins($cliente) {

        $this->Conecta("mikrotik");

        $query = "SELECT UserName, value FROM radcheck WHERE id_cliente='" . $cliente . "' AND Attribute IN ('MD5-Password', 'User-Password') ORDER BY UserName";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Troca_MkSenha($id_cliente, $mk_login, $mk_senha) {

        $this->Conecta("mikrotik");

        $query = "UPDATE radcheck SET value='" . $mk_senha . "' WHERE id_cliente='" . $id_cliente . "' AND UserName='" . $mk_login . "' AND Attribute IN ('MD5-Password', 'User-Password')";
        return $this->read($query);

        $this->Desconecta();
    }

}

?>