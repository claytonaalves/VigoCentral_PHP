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
                <title><?php $fantasia = explode(' ', utf8_decode(utf8_encode($_SESSION['FANTASIA'])));
echo $fantasia[0]; ?> - Central do Cliente</title>
                <link rel="shortcut icon" href="<?php echo $funcoes->baseProjeto(); ?>/public/images/favicon.ico" type="image/x-icon">
                    <link rel="icon" href="<?php echo $funcoes->baseProjeto(); ?>/public/images/favicon_32.png" sizes="32x32">
                        <link rel="stylesheet" type="text/css" href="<?php echo $funcoes->baseProjeto(); ?>/public/css/default.css" />
                        <link rel="stylesheet" type="text/css" href="<?php echo $funcoes->baseProjeto(); ?>/public/css/style.css" />
                        <link rel="stylesheet" type="text/css" href="<?php echo $funcoes->baseProjeto(); ?>/public/css/style_<?php echo $_SESSION['CENTRAL_TEMA']; ?>.css" />
                        <link href="<?php echo $funcoes->baseProjeto(); ?>/public/css/fonts.css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
                            <script type="text/javascript" src="<?php echo $funcoes->baseProjeto(); ?>/public/js/jquery.js"></script>
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
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $(".close").click(function () {
                                        $(".boxExtrato").fadeOut(400);
                                    });

                                    $('.botao').click(function () {
                                        var id = $(this).attr('id');
                                        var styleToRemove = {display: "none"};
                                        var styleToAdd = {display: "block"};

                                        $('.boxExtrato').css(styleToRemove);

                                        $('#box' + id).animate({height: 'toggle'});
                                        $('#box' + id).fadeIn('slow').css(styleToAdd);

                                        $('#info' + id).animate({height: 'swing'});
                                        $('#info' + id).fadeIn('slow').css(styleToAdd);

                                        //var closeAuto = setInterval(".boxExtrato", 3000);
                                    });

                                    $('.botao2').click(function () {
                                        var id = $(this).attr('id');
                                        var styleToRemove = {display: "none"};
                                        var styleToAdd = {display: "block"};

                                        $('.boxExtrato').css(styleToRemove);

                                        $('#anexo' + id).animate({height: 'toggle'});
                                        $('#anexo' + id).fadeIn('slow').css(styleToAdd);

                                        $('#info2' + id).animate({height: 'swing'});
                                        $('#info2' + id).fadeIn('slow').css(styleToAdd);

                                        //var closeAuto = setInterval(".boxExtrato", 3000);
                                    });

                                    $('.btnTicket').click(function () {
                                        var id = $(this).attr('id');
                                        var styleToRemove = {display: "none"};
                                        var styleToAdd = {display: "block"};
                                        var styleToHeight = {height: "350px"};

                                        $('#abrirAtendimento').css(styleToRemove);

                                        $('#abrirAtendimento').animate({height: 'toggle'});
                                        $('#abrirAtendimento').animate({height: "450px"});

                                        $('#boxAtendimento').animate({height: 'swing'});
                                        $('#boxAtendimento').fadeIn('slow').css(styleToAdd);
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
                                function AlteraClasse() {
                                    $("#lblSenhaAtual").removeClass("disabled");
                                    $("#lblSenhaNova").removeClass("disabled");
                                    $("#lblSenhaConfirma").removeClass("disabled");
                                    document.formSenha.txtSenhaAtual.disabled = false;
                                    document.formSenha.txtSenhaNova.disabled = false;
                                    document.formSenha.txtSenhaConfirma.disabled = false;
                                }
                            </script>
                            </head>
                            <body>