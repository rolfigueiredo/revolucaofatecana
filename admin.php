<?php
require_once(dirname(__FILE__).'/class/Login.php');
$objLogin = new Login();

$objLogin->verificarLogado();

include "inc/cabecalho.php"; ?>
<div class="page home-page">
    <!-- Main Navbar-->
    <?php include "inc/menu-top.php" ?>
    <div class="page-content d-flex align-items-stretch">
        <?php include "inc/menu.php" ?>
        <div class="content-inner">
            <header class="page-header">
                <div class="container-fluid">
                    <h2 class="no-margin-bottom">Dashboard</h2>
                </div>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
            </header>
            <?php include "inc/fim_pagina.php"; ?>
        </div>
    </div>
</div>
<?php include "inc/rodape.php"; ?>