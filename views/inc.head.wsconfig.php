<!DOCTYPE html>
<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
@session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
    <head>
        <meta name="robots" content="noindex, nofollow">
            <meta http-equiv="Content-Language" content="pt-br" />
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no" />
                <meta content="Vigo Tecnologia" name="Title" />
                <meta content="Jorge Valdez" name="Author" />
                <title>Central do Cliente</title>
                <link rel="shortcut icon" href="<?php echo $funcoes->baseProjeto(); ?>/public/images/favicon.ico" type="image/x-icon">
                    <link rel="icon" href="<?php echo $funcoes->baseProjeto(); ?>/public/images/favicon_32.png" sizes="32x32">
                        <link rel="stylesheet" type="text/css" href="<?php echo $funcoes->baseProjeto(); ?>/public/css/default.css" />
                        <link rel="stylesheet" type="text/css" href="<?php echo $funcoes->baseProjeto(); ?>/public/css/style.css" />
                        <link rel="stylesheet" type="text/css" href="<?php echo $funcoes->baseProjeto(); ?>/public/css/style_<?php $_SESSION['CENTRAL_TEMA']; ?>.css" />
                        <link href="<?php echo $funcoes->baseProjeto(); ?>/public/css/fonts.css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
                            <script type="text/javascript" src="<?php echo $funcoes->baseProjeto(); ?>/public/js/jquery.js"></script>
                            <script type="text/javascript" src="<?php echo $funcoes->baseProjeto(); ?>/public/js/jquery.maskMoney.js"></script>
                            <script>document.addEventListener("touchstart", function () {
                    }, true);</script>
                            <script>
                                function fecha(id) {
                                    document.getElementById(id).style.display = 'none';
                                }
                                setTimeout(function () {
                                    fecha('messageBox');
                                }, 10000);
                                setTimeout(function () {
                                    ".boxExtrato"
                                }, 10000);
                            </script>
                            <script>
                                $(function () {
                                    $("#txtModTaxaMulta").maskMoney({allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
                                    $("#txtModTaxaJuros").maskMoney({allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
                                })
                            </script>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $(".close").click(function () {
                                        $(".boxWSConfig").fadeOut(400);
                                    });

                                    $('.botao').click(function () {
                                        var id = $(this).attr('id');
                                        var styleToRemove = {display: "none"};
                                        var styleToAdd = {display: "block"};

                                        $('.boxWSConfig').css(styleToRemove);
                                        $('#box' + id).animate({height: 'toggle'});
                                        $('#box' + id).fadeIn('slow').css(styleToAdd);
                                        $('#info' + id).animate({height: 'swing'});
                                        $('#info' + id).fadeIn('slow').css(styleToAdd);

                                        //var closeAuto = setInterval(".boxWSConfig", 3000);
                                    });

                                    $('#lnkSenha').click(function () {
                                        var styleToRemove = {display: "none"};
                                        var styleToAdd = {display: "block"};
                                        var position = {position: "absolute", display: "block"};

                                        $(".boxWSConfig").fadeOut('fast');
                                        $('#alterarSenha').css(styleToRemove);
                                        $('#alterarSenha').fadeIn('slow');
                                        $('#alterarSenha').css(position);
                                        $('#boxSenha').animate({height: 'swing'});
                                        $('#boxSenha').fadeIn('slow').css(styleToAdd);
                                    });

                                    $('#lnkMultaJuros').click(function () {
                                        var styleToRemove = {display: "none"};
                                        var styleToAdd = {display: "block"};
                                        var position = {position: "absolute", display: "block"};

                                        $(".boxWSConfig").fadeOut('fast');
                                        $('#alterarMultaJuros').css(styleToRemove);
                                        $('#alterarMultaJuros').fadeIn('slow');
                                        $('#alterarMultaJuros').css(position);
                                        $('#boxMultaJuros').animate({height: 'swing'});
                                        $('#boxMultaJuros').fadeIn('slow').css(styleToAdd);
                                    });

                                    $('#lnkTema').click(function () {
                                        var styleToRemove = {display: "none"};
                                        var styleToAdd = {display: "block"};
                                        var position = {position: "absolute", display: "block"};

                                        $(".boxWSConfig").fadeOut('fast');
                                        $('#alterarTema').css(styleToRemove);
                                        $('#alterarTema').fadeIn('slow');
                                        $('#alterarTema').css(position);
                                        $('#boxTema').animate({height: 'swing'});
                                        $('#boxTema').fadeIn('slow').css(styleToAdd);
                                    });

                                    $('#lnkGrafico').click(function () {
                                        var styleToRemove = {display: "none"};
                                        var styleToAdd = {display: "block"};
                                        var position = {position: "absolute", display: "block"};

                                        $(".boxWSConfig").fadeOut('fast');
                                        $('#alterarGrafico').css(styleToRemove);
                                        $('#alterarGrafico').fadeIn('slow');
                                        $('#alterarGrafico').css(position);
                                        $('#boxGrafico').animate({height: 'swing'});
                                        $('#boxGrafico').fadeIn('slow').css(styleToAdd);
                                    });

                                    $('#lnkPermissoes').click(function () {
                                        var styleToRemove = {display: "none"};
                                        var styleToAdd = {display: "block"};
                                        var position = {position: "absolute", display: "block"};

                                        $(".boxWSConfig").fadeOut('fast');
                                        $('#alterarPermissoes').css(styleToRemove);
                                        $('#alterarPermissoes').fadeIn('slow');
                                        $('#alterarPermissoes').css(position);
                                        $('#boxPermissoes').animate({height: 'swing'});
                                        $('#boxPermissoes').fadeIn('slow').css(styleToAdd);
                                    });

                                    $('#lnkContrato').click(function () {
                                        var styleToRemove = {display: "none"};
                                        var styleToAdd = {display: "block"};
                                        var position = {position: "absolute", display: "block"};

                                        $(".boxWSConfig").fadeOut('fast');
                                        $('#alterarContrato').css(styleToRemove);
                                        $('#alterarContrato').fadeIn('slow');
                                        $('#alterarContrato').css(position);
                                        $('#boxContrato').animate({height: 'swing'});
                                        $('#boxContrato').fadeIn('slow').css(styleToAdd);
                                    });

                                });
                            </script>
                            <script type="text/javascript">
                                function blocTexto(valor, id, limite, contador) {
                                    quant = limite;
                                    total = valor.length;
                                    if (total <= quant) {
                                        resto = quant - total;
                                        document.getElementById(contador).innerHTML = resto;
                                    } else {
                                        document.getElementById(id).value = valor.substr(0, quant);
                                    }
                                }
                            </script>
                            <script language="JavaScript">
                                function AtivarArquivo() {
                                    $("#lblArquivo").removeClass("disabled");
                                    document.formContrato.txtArquivo.disabled = false;
                                    document.formContrato.txtArquivo.focus();
                                    $("#lblArquivo").addClass("ativo");
                                }
                                function DesativarArquivo() {
                                    $("#lblArquivo").removeClass("ativo");
                                    document.formContrato.txtArquivo.disabled = true;
                                    $("#lblArquivo").addClass("disabled");
                                }
                            </script>
                            </head>
                            <body>