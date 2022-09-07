<?php

use core\classes\Store;

?>
   
<!DOCTYPE html>
<html class="wide wow-animation" lang="pt-pt ">

<head>
    <title><?= APP_NAME .''?> </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../public/assets/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Montserrat:300,400,700%7CPoppins:300,400,500,700,900">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/fonts.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        .ie-panel {
            display: none;
            background: #09addf;
            padding: 10px 0;
            box-shadow: 3px 3px 5px 0 rgba(0, 140, 255, 0.938);
            clear: both;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        html.ie-10 .ie-panel,
        html.lt-ie-10 .ie-panel {
            display: block;
        }
    </style>
</head>



<div class="ie-panel">
    <a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="../public/assets/images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
</div>
<div class="preloader">
    <div class="preloader-body">
        <div class="cssload-container">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <p>A Carregar...</p>
    </div>
</div>
<div class="page">
    <header class="section page-header">
        <!--RD Navbar-->
        <div class="rd-navbar-wrap">
            <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
                <div class="rd-navbar-collapse-toggle rd-navbar-fixed-element-1" data-rd-navbar-toggle=".rd-navbar-collapse"><span></span></div>
                <div class="rd-navbar-aside-outer rd-navbar-collapse bg-gray-dark">
                    <div class="rd-navbar-aside">
                        <ul class="list-inline navbar-contact-list">
                            <li>
                                <div class="unit unit-spacing-xs align-items-center">
                                    <div class="unit-left"><span class="icon text-middle fa-phone"></span></div>
                                    <div class="unit-body"><a href="tel:#">+351 933 654 914</a></div>
                                </div>
                            </li>
                            <li>
                                <div class="unit unit-spacing-xs align-items-center">
                                    <div class="unit-left"><span class="icon text-middle fa-envelope"></span></div>
                                    <div class="unit-body"><a href="mailto:#">anderson.ap2001@gmail.com</a></div>
                                </div>
                            </li>
                            <li>
                                <div class="unit unit-spacing-xs align-items-center">
                                    <div class="unit-left"><span class="icon text-middle fa-map-marker"></span></div>
                                    <div class="unit-body"><a href="#">Avenida do Bessa 130C 5º G/DK</a></div>
                                </div>
                            </li>
                        </ul>
                        <ul class="social-links">
                            <li>
                                <a class="icon icon-sm icon-circle icon-circle-md icon-bg-white fa-facebook" href="#"></a>
                            </li>
                            <li>
                                <a class="icon icon-sm icon-circle icon-circle-md icon-bg-white fa-instagram" href="#"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="rd-navbar-main-outer">
                    <div class="rd-navbar-main">
                        <!--RD Navbar Panel-->
                        <div class="rd-navbar-panel">
                            <!--RD Navbar Toggle-->
                            <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                            <!--RD Navbar Brand-->
                            <div class="rd-navbar-brand">
                                <!--Brand-->
                                <a class="brand" href="?a=inicio"><img class="brand-logo-dark" src="../public/assets/images/logo-default-200x34.png" alt="" width="100" height="17" /><img class="brand-logo-light" src="images/logo-inverse-200x34.png" alt="" width="100" height="17" /></a>
                            </div>
                        </div>
                        <div class="rd-navbar-main-element">
                            <div class="rd-navbar-nav-wrap">
                                <ul class="rd-navbar-nav">
                                    <li>
                                    <li class="rd-nav-item active"><a class="rd-nav-link" href="?a=contacto">Contactos</a>
                                    </li>
                                    <li class="rd-nav-item"><a class="rd-nav-link" href="?a=sobre">Sobre Nós</a>
                                    </li>

                                    <!--  Verifica se existe cliente na sessão-->
                                    <?php if (Store::clienteLogado(true)) : ?>
                                        <li class="rd-nav-item"> <a  class="rd-nav-link" href="?a=minha_conta"></i> <?= $_SESSION['nome_cliente']?> </i></a>
                                        </li>
                                        <li class="rd-nav-item"> <a  class="rd-nav-link" href="?a=logout">Logout</a>
                                        </li>

                                    <?php else : ?>

                                        <li class="rd-nav-item"><a class="rd-nav-link" href="?a=login">LOGIN</a>
                                        </li>
                                        <li class="rd-nav-item"><a class="rd-nav-link" href="?a=novo_cliente">Criar Conta</a>
                                        </li>

                                    <?php endif; ?>

                                </ul>
                            </div>
                        </div>
                    </div>
            </nav>
        </div>
    </header>