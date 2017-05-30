<?php

require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();

// Arquivo PDF
$pdf = 'public/contrato/ContratoDefault.pdf';

// Cabeçalho identificador para o navegador
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="ContratoDefault.pdf"');

// Faz a saída para o navegador
readfile($pdf);
?>