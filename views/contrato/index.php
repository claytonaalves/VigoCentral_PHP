<?php

require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();

// Cria a sessão
@session_start();

// Cria a variável PDF
$title = $_SESSION['DESCRICAO'] . ' - ' . strtoupper($_SESSION['LOGIN']);
$pdf = $_SESSION['CONTEUDO'];

// Destroi a sessão
$_SESSION['DESCRICAO'] = NULL;
$_SESSION['CONTEUDO'] = NULL;
unset($_SESSION['DESCRICAO']);
unset($_SESSION['CONTEUDO']);

// Cabeçalho identificador para o navegador

header('Pragma: public');
header('Expires: 1');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Type: application/pdf');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . strlen($pdf));
header('Content-Disposition: inline; filename=' . $title . '.pdf');

// Faz saída para o navegador
print $pdf;
?>