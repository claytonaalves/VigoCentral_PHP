<?php

class Functions {

    // Define a pasta raiz do projeto
    public function baseProjeto() {

        return '/central';
    }

    // Verifica se existe sessão aberta
    public function verificaSessao() {

        @session_start();

        if (!isset($_SESSION['ID_CLIENTE']) || !isset($_SESSION['LOGIN'])) {
            header("Location: /central/login");
            exit;
        }
    }

    // Verifica se existe sessão wsconfig aberta
    public function verificaSessaoWSConfig() {

        @session_start();

        if (!isset($_SESSION['LOGIN'])) {
            header("Location: /central/login");
            exit;
        }
    }

    // Capturar dados da conexão para arquivo de configuração
    public function carregaBDS() {

        $inifile = parse_ini_file('libs/setup/bd.conf', true);

        $bd["vigo"] = array($inifile['vigo']['hostname'],
            $inifile['vigo']['database'],
            $inifile['vigo']['username'],
            $inifile['vigo']['password']);

        $bd["mikrotik"] = array($inifile['mikrotik']['hostname'],
            $inifile['mikrotik']['database'],
            $inifile['mikrotik']['username'],
            $inifile['mikrotik']['password']);

        $bd["mail"] = array($inifile['mail']['hostname'],
            $inifile['mail']['database'],
            $inifile['mail']['username'],
            $inifile['mail']['password']);

        return $bd;
    }

    // Remove aspas simples e aspas duplas
    public function removeAspas($texto) {

        $texto = str_replace("'", "", $texto);
        $texto = str_replace("\"", "", $texto);

        return $texto . rtrim(' ');
    }

    // Converte a data de formato AMERICANO para o formato BRASILEIRO
    public function dataToBR($data) {

        $transformado = substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4);
        $transformado = ($transformado == "//") ? "" : $transformado;

        return $transformado;
    }

    // Converte a data de formato BRASILEIRO para o formato AMERICANO
    public function dataToUS($data) {

        $transformado = substr($data, 6, 4) . "-" . substr($data, 3, 2) . "-" . substr($data, 0, 2);
        $transformado = ($transformado == "--") ? "" : $transformado;

        return $transformado;
    }

    // Converte a data de emissão da NOTA FISCAL para o formato BRASILEIRO
    public function dataToNF($data) {

        $transformado = substr($data, 6, 2) . "/" . substr($data, 4, 2) . "/" . substr($data, 0, 4);
        $transformado = ($transformado == "//") ? "" : $transformado;

        return $transformado;
    }

    // Converte o mês de referência da NOTA FISCAL - PADRÃO: MMM/AAAA
    public function refNF($referencia) {

        $transformado = $this->mesExtenso(substr($referencia, 2, 2)) . "/20" . substr($referencia, 0, 2);
        $transformado = ($transformado == "//") ? "" : $transformado;
        //utf8_encode($funcoes->
        return $transformado;
    }

    // Converte o mês de referência da NOTA FISCAL - PADRÃO: MM/AAAA
    public function referenciaNF($referencia) {

        $transformado = substr($referencia, 2, 2) . "/20" . substr($referencia, 0, 2);
        $transformado = ($transformado == "//") ? "" : $transformado;
        //utf8_encode($funcoes->
        return $transformado;
    }

    // Formatar valor com duas casas decimais
    public function valor($valor) {

        $formatado = number_format(($valor / 100), 2, ',', '.');
        return $formatado;
    }

    // Formatar valor com duas casas decimais padrão EN-US
    public function valorUS($valor) {

        $formatado = number_format(($valor / 100), 2, '.', ',');
        return $formatado;
    }

    // Formatar valor com duas casas decimais padrão PT-BR
    public function valorBR($valor) {

        $formatado = number_format(($valor / 100), 2, ',', '.');
        return $formatado;
    }

    // Formatar valor decimal padrão EN-US
    public function valorDecimalUS($valor) {

        $formatado = str_replace(",", ".", $valor) / 100;
        return $formatado;
    }

    // Formatar valor decimal padrão PT-BR
    public function valorDecimalBR($valor) {

        $formatado = str_replace(".", ",", $valor) / 100;
        return $formatado;
    }

    // Calcular valor aproximado de tributos
    public function calcIBPT($valor, $taxa) {

        $valor = number_format(($valor / 100), 2, '.', ',');
        $taxa = str_replace(",", ".", $taxa);
        $valorIBPT = number_format((($valor * $taxa) / 100), 2, ',', '.');
        return $valorIBPT;
    }

    // Formatar numero sem casa decimal
    public function numero($numero) {

        $formatado = $numero / 1000;
        if ($formatado < 10) {
            $formatado = '0' . $formatado;
        }
        return $formatado;
    }

    // Formata CPF
    public function cpf($cpf) {

        $prefixo = substr($cpf, 0, 3);

        if ($prefixo == 000):
            $documento = substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '.' . substr($cpf, 9, 3) . '-' . substr($cpf, 12, 2);
        endif;

        return $documento;
    }

    // Formata CNPJ
    public function cnpj($cnpj) {

        $documento = substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
        return $documento;
    }

    // Formatar chave de reservado ao fisco
    public function chave($chave) {

        $chave01 = substr($chave, 0, 4);
        $chave02 = substr($chave, 4, 4);
        $chave03 = substr($chave, 8, 4);
        $chave04 = substr($chave, 12, 4);
        $chave05 = substr($chave, 16, 4);
        $chave06 = substr($chave, 20, 4);
        $chave07 = substr($chave, 24, 4);
        $chave08 = substr($chave, 28, 4);

        //2baa.0fae.c57b.96d1.a4be.61be.46b0.15cd

        $chave = $chave01 . '.' . $chave02 . '.' . $chave03 . '.' . $chave04 . '.' . $chave05 . '.' . $chave06 . '.' . $chave07 . '.' . $chave08;

        return $chave;
    }

    // Mês por extenso
    public function mesExtenso($mes) {

        if ($mes == "01")
            $resultado = "JANEIRO";
        elseif ($mes == "02")
            $resultado = "FEVEREIRO";
        elseif ($mes == "03")
            $resultado = "MAR&Ccedil;O";
        elseif ($mes == "04")
            $resultado = "ABRIL";
        elseif ($mes == "05")
            $resultado = "MAIO";
        elseif ($mes == "06")
            $resultado = "JUNHO";
        elseif ($mes == "07")
            $resultado = "JULHO";
        elseif ($mes == "08")
            $resultado = "AGOSTO";
        elseif ($mes == "09")
            $resultado = "SETEMBRO";
        elseif ($mes == "10")
            $resultado = "OUTUBRO";
        elseif ($mes == "11")
            $resultado = "NOVEMBRO";
        elseif ($mes == "12")
            $resultado = "DEZEMBRO";
        else
            $resultado = "";

        return $resultado;
    }

    // Calcula o tempo de conexao no extrato de horas
    public function tempoConexao($dataInicial, $dataFinal) {

        $dataInicial = strtotime($dataInicial);
        $dataFinal = strtotime($dataFinal);

        $dias = ($dataFinal - $dataInicial) / 86400;

        $tempo = $dataFinal - $dataInicial;

        if ($tempo % 86400 <= 0) {
            $dias = $tempo / 86400;
        }

        if ($tempo % 86400 > 0) {

            $fatorResto = ($tempo % 86400);
            $dias = ($tempo - $fatorResto) / 86400;

            if ($fatorResto % 3600 > 0) {

                $fatorResto1 = ($fatorResto % 3600);
                $horas = ($fatorResto - $fatorResto1) / 3600;

                if ($fatorResto1 % 60 > 0) {

                    $fatorResto2 = ($fatorResto1 % 60);
                    $minutos = ($fatorResto1 - $fatorResto2) / 60;
                    $segundos = $fatorResto2;
                } else {

                    $minutos = $fatorResto1 / 60;
                }
            } else {

                $horas = $fatorResto / 3600;
            }
        }

        $segundos = (isset($segundos)) ? $segundos : '';

        $fatorPluralDias = ($dias > '1') ? 's' : '';
        $fatorPluralHoras = ($horas > '1') ? 's' : '';
        $fatorPluralMinutos = ($minutos > '1') ? 's' : '';
        $fatorPluralSegundos = ($segundos > '1') ? 's' : '';

        $resposta = "";

        if ($dias != "") {
            $resposta .= $dias . " dia" . $fatorPluralDias . " ";
        }

        if ($horas != "") {
            $resposta .= $horas . " hora" . $fatorPluralHoras . " ";
        }

        if ($minutos != "") {
            $resposta .= $minutos . " minuto" . $fatorPluralMinutos . " ";
        }

        if ($segundos != "") {
            $resposta .= $segundos . " segundo" . $fatorPluralSegundos . " ";
        }

        return($resposta);
    }

    // Tratamento para o tempo de conexao no extrato de horas
    public function bandaToMB($banda) {

        $banda = round(floatval($banda / 1024 / 1024), 2);

        $resultado = "{$banda} MB";
        return $resultado;
    }
    
	// Tratamento para o tempo de conexao no extrato de horas
    public function bandaToGB($banda) {

        $banda = round(floatval($banda / 1024 / 1024 / 1024), 2);

        $resultado = "{$banda} GB";
        return $resultado;
    }

    // Traducao para os motivos de desconexao
    public function motivoDesconexao($motivo) {
        $motivos = array(
            'NAS-Request' => 'Solicitada pelo NAS.',
            'User-Request' => 'Solicitada pelo usu&aacute;rio.',
            'Lost-Service' => 'Conex&atilde;o interrompida.',
            'Idle-Timeout' => 'Expirado por falta de atividade na rede.',
            'Admin-Reset' => 'Resetada pelo administrador.',
            'Session-Timeout' => 'Tempo de conex&atilde;o esgotado.',
            'Admin-Reboot' => 'Reboot do administrador.'
        );
        return $motivos[$motivo];
    }

}

?>