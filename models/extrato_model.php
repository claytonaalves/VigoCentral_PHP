<?php

class Extrato_Model extends Model {

    public function Lista_MkLogins($cliente) {

        $this->Conecta("mikrotik");

        // Faz a pesquisa
        $query = "SELECT DISTINCT UserName FROM radcheck WHERE id_cliente='" . $cliente . "' AND username NOT LIKE '%:%:%:%:%:%' ORDER BY username";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Lista_Acessos($login, $dtInicio, $dtFinal) {

        $this->Conecta("mikrotik");

        // Faz a pesquisa
        $query = "SELECT * FROM radacct WHERE (UserName='" . $login . "') AND (AcctStartTime BETWEEN '" . $dtInicio . "' AND '" . $dtFinal . "') AND ((AcctStopTime<>'0000-00-00 00:00:00') OR (AcctStopTime IS NOT NULL)) ORDER by AcctStartTime ASC";
        return $this->read($query);

        $this->Desconecta();
    }

    public function Exibir_Plano($login) {

        $this->Conecta("mikrotik");

        // Faz a pesquisa
        $query = "SELECT DISTINCT ug.username, ug.groupname, radgroupreply.attribute, radgroupreply.value FROM radcheck LEFT JOIN usergroup ug ON radcheck.username=ug.username LEFT JOIN radgroupreply using(groupname) WHERE radgroupreply.attribute='Mikrotik-Rate-Limit' AND ug.username='" . $login . "'";
        return $this->read($query);

        $this->Desconecta();
    }

}

?>