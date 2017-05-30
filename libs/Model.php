<?php

class Model {

    private $db;
    private $result;
    private $conexao; // Será o array com as informações da conexão

    function __construct() {
        $funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS (classe "pai")
        $this->conexao = $funcoes->carregaBDS(); // Carrega o array com as informações dos bancos de dados
    }

    protected function Conecta($database = null) {
        if ($database == null ? $database = "vigo" : $database);
        
        $this->db = @mysql_connect($this->conexao[$database][0], $this->conexao[$database][2], $this->conexao[$database][3]) or die("Erro ao tentar conectar no banco de dados !");
        @mysql_select_db($this->conexao[$database][1], $this->db);
    }

    protected function executar($sql) {
        $result = @mysql_query($sql);
        return $result;
    }

    protected function MySQLFetchAll($resultado) {
        $buscarTudo = array();
        while ($buscarTudo[] = @mysql_fetch_array($resultado, MYSQL_ASSOC)) {
            
        }
        return $buscarTudo;
    }

    protected function read($query) {
        $resultado = $this->executar($query);
        $dados = $this->MySQLFetchAll($resultado);
        if (end($dados) == null)
            array_pop($dados);
        return $dados;
    }

    protected function Desconecta() {
        @mysql_free_result($this->result);
        @mysql_close($this->db);
    }

}

?>