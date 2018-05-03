<?php
require_once(dirname(__FILE__).'/class/Login.php');
require_once(dirname(__FILE__).'/class/Usuario.php');
$objLogin = new Login();
$objLogin->verificarLogado();

$id="";
$pesq="";
if (isset($_GET['id'])){
    $id=$_GET['id'];
    $objUsuario = new Usuario();
    $objUsuario->getDados($id);
}
if (isset($_GET['pesq'])){
    $pesq=$_GET['pesq'];
}

if(isset($_POST["add"]) && $_POST["add"] == "Alterar"){
	$cad = $objUsuario->AltUsuario($_POST["id"],$_POST["tipo"],$_POST['ra'],$_POST['curso'],$_POST['nome'],$_POST['email'],$_POST['senha']);
    if ($cad>0){
        if (!empty($_FILES['img'])){
            require_once(dirname(__FILE__).'/class/Upload.php');
            $nome_img="user_".$cad;
            $pasta="arquivos/";
            $upload = new Upload($_FILES['img'], 150, 150, $nome_img, $pasta);
            if ($upload->salvar()=="Sucesso"){
                $nome_img.="." . $upload->getExtensao();
                $img = $objUsuario->AtualizaImagem($cad,$nome_img);
                if ($img=="ok"){
                    header("Location:users.php?cad=ok");
                    die();
                }
            }
        }
    }
    header("Location:users.php?pesq=$pesq&cad=ok");
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
                    <h2 class="no-margin-bottom">Alterar Usuario</h2>
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
                                            <h3 class="h4">Cadastro alterado com sucesso!</h3>
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
                                <form id="form-usuario" method="post" action="" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?=$id?>" />
                                    <input type="hidden" name="pesq" value="<?=$pesq?>" />
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-inline">
                                                <? $tipos = $objUsuario->getTipos();?>
                                                <div class="col-sm-12 col-md-5 format-box-forms-ini">
                                                    <div class="form-group-material select">
                                                        <label for="tipo" class="label-material-select">Tipo de usuário</label>
                                                        <select id="tipo" name="tipo" class="input-material" required />
                                                        <option value="">Selecione um tipo</option>
                                                        <?foreach ($tipos as $row) {
                                                              echo "<option value=\"".$row[0]."\"";
                                                              if ($objUsuario->getCodTipo()==$row[0])
                                                                  echo " selected";
                                                              echo " />".$row[1]."</option>\n";
                                                          } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="tipo_aluno_ra" class="col-sm-7 col-md-4 format-box-forms-ini">
                                                    <div class="form-group-material">
                                                        <input id="ra" type="text" name="ra" value="<?=$objUsuario->getRaAluno()?>" maxlength="10" class="input-material" />
                                                        <label for="ra" class="label-material">RA</label>
                                                    </div>
                                                </div>
                                                <div id="tipo_aluno_curso" class="col-sm-5 col-md-3 format-box-forms-ini">
                                                     <? $cursos = $objUsuario->getCursos();?>
                                                    <div class="form-group-material select">
                                                        <label for="curso" class="label-material-select">Tipo de usuário</label>
                                                        <select id="curso" name="curso" class="input-material" />
                                                        <option value="">Selecione um curso</option>
                                                        <?foreach ($cursos as $row) {
                                                              echo "<option value=\"".$row[0]."\"";
                                                              if ($objUsuario->getCodCursoAluno()==$row[0])
                                                                  echo " selected";
                                                              echo " />".$row[2]." (".$row[1].")</option>\n";
                                                          } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-inline">
                                                <div class="col-sm-12 col-md-6 format-box-forms-ini">
                                                    <div class="form-group-material">
                                                        <input id="nome" type="text" name="nome" value="<?=$objUsuario->getNomeUsuario()?>" maxlength="50" class="input-material" required />
                                                        <label for="nome" class="label-material">Nome</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 format-box-forms-ini">
                                                    <div class="form-group-material">
                                                        <input id="email" type="email" name="email" value="<?=$objUsuario->getEmailUsuario()?>" maxlength="50" class="input-material" required />
                                                        <label for="email" class="label-material">E-mail</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-inline">
                                                <div class="col-sm-12 col-md-4 format-box-forms-ini">
                                                    <div class="form-group-material">
                                                        <input id="senha1" type="text" name="senha1" maxlength="50" class="input-material" />
                                                        <label for="senha1" class="label-material">Senha</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 format-box-forms-ini">
                                                    <div class="form-group-material">
                                                        <input id="senha1_conf" type="text" name="senh1a_conf" maxlength="10" class="input-material" />
                                                        <label for="senha1_conf" class="label-material">Confirmar senha</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 format-box-forms-ini">
                                                <div class="form-group-material">
                                                    <label>Foto do usuário</label>
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