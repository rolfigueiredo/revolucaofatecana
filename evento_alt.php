<?php
require_once(dirname(__FILE__).'/class/Login.php');
require_once(dirname(__FILE__).'/class/Evento.php');
$objLogin = new Login();
$objLogin->verificarLogado();

$id="";
$pesq="";
if (isset($_GET['id'])){
    $id=$_GET['id'];
    $objEvento = new Evento();
    $objEvento->getDados($id);
}
if (isset($_GET['pesq'])){
    $pesq=$_GET['pesq'];
}

if(isset($_POST["add"]) && $_POST["add"] == "Alterar"){
	$cad = $objEvento->AltEvento($_POST["id"],$_POST['evento'],$_POST['data'],$_POST['descricao']);
    if ($cad>0){
        if (!empty($_FILES['img'])){
            require_once(dirname(__FILE__).'/class/Upload.php');
            $nome_img="foto_".$cad;
            $pasta="arquivos/";
            $upload = new Upload($_FILES['img'], 500, 500, $nome_img, $pasta);
            if ($upload->salvar()=="Sucesso"){
                $nome_img.="." . $upload->getExtensao();
                $img = $objEvento->AtualizaImagem($cad,$nome_img);
                if ($img=="ok"){
                    header("Location:Eventos.php?cad=ok");
                    die();
                }
            }
        }
    }
    header("Location:Eventos.php?pesq=$pesq&cad=ok");
}
?>
<!DOCTYPE html>
<?php
include "inc/cabecalho.php"; ?>
<div class="page home-page">
    <!-- Main Navbar-->
    <?php include "inc/menu-top.php" ?>
    <div class="page-content d-flex align-items-stretch">
        <?php $menu="empserv";
              include "inc/menu.php" ?>
        <div class="content-inner">
            <!-- Page Header-->
            <header class="page-header">
                <div class="container-fluid">
                    <h2 class="no-margin-bottom">Alterar Evento</h2>
                </div>
            </header>
            <?if(isset($_GET["cad"])){?>
                <section class="projects padding-top no-padding-bottom">
                    <div class="container-fluid">
                        <div class="project">
                            <div class="row bg-yellow has-shadow">
                                <div class="left-col retirar_borda d-flex align-items-center justify-content-between">
                                    <div class="project-title d-flex align-items-center">
                                        <div class="text">
                                            <small>Mensagem</small>
                                            <h3 class="h4">Evento alterado com sucesso!</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } ?>
            <section class="tela">
                <div class="container-fluid">
                    <div class="row">
                        <div class="chart col-lg-12 col-12">
                            <div class="bg-white align-items-center justify-content-center has-shadow format-box-forms">
                                <form id="form-Evento" method="post" action="" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?=$id?>" />
                                    <input type="hidden" name="pesq" value="<?=$pesq?>" />
                                    <div class="row">
                                        <div class="col-sm-12">
                                            
                                            <div class="form-inline">
                                                <div class="col-sm-12 col-md-5 format-box-forms-ini">
                                                    <div class="form-group-material">
                                                        <input id="Evento" type="text" name="Evento" value="<?=$objEvento->getNomeEvento()?>" maxlength="50" class="input-material" required />
                                                        <label for="Evento" class="label-material">Nome Evento</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-7 format-box-forms-ini">
                                                    <div class="form-group-material">
                                                        <input id="valor" type="text" name="valor" value="<?=$objEvento->getDataEvento()?>" maxlength="10" class="input-material" required />
                                                        <label for="valor" class="label-material">Data Evento</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-inline">
                                                <div class="col-sm-12 format-box-forms-ini">
                                                    <div class="form-group-material">
                                                        <textarea id="descricao" name="descricao" cols="5" class="input-material" required /><?=$objEvento->getDescEvento()?></textarea>
                                                        <label for="descricao" class="label-material">Descrição</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 format-box-forms-ini">
                                                <div class="form-group-material">
                                                    <label>Imagem do Evento</label>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <span class="btn-default btn-file">
                                                                <span class="input-group-btn btn btn-primary btn-arquivo">Procurar</span>
                                                                <input type="file" id="imgInp" name="img" />
                                                            </span>
                                                        </span>
                                                        <input type="text" class="form-control" readonly />
                                                    </div>
                                                    <img id='img-upload' />
                                                </div>
                                            </div>
                                            <div class="line"></div>
                                            <div class="form-group row">
                                                <div class="col-sm-4 offset-sm-3 format-box-forms-ini">
                                                    <button type="submit" name="add" class="btn btn-primary" value="Alterar">Alterar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php include "inc/fim_pagina.php"; ?>
        </div>
    </div>
</div>
<?php include "inc/rodape.php"; ?>