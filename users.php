<?php
require_once(dirname(__FILE__).'/class/Login.php');
require_once(dirname(__FILE__).'/class/Usuario.php');
require_once(dirname(__FILE__).'/class/Paginacao.php');
$objLogin = new Login();

$objLogin->verificarLogado();

$objUsuario = new Usuario();

$pesq="";
if (isset($_GET['pesquisa'])){
    $pesq=$_GET['pesquisa'];
}

if(isset($_GET["id"])){
    $objUsuario->getDados($_GET["id"]);
	$exc = $objUsuario->ExcUsuario($_GET["id"]);
    if ($exc>0){
        require_once(dirname(__FILE__).'/class/Upload.php');
        $nome_img=$objUsuario->getImgUsuario();
        $pasta="arquivos/";
        $upload = new Upload("", "", "", $nome_img, $pasta);
        $upload->deletar();
        header("Location:users.php?pesq=$pesq&exc=ok");
    }
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
                    <h2 class="no-margin-bottom">Usuários</h2>
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
            <? }
              if(isset($_GET["exc"])){?>
            <section class="projects padding-top no-padding-bottom">
                <div class="container-fluid">
                    <div class="project">
                        <div class="row bg-yellow has-shadow">
                            <div class="left-col retirar_borda d-flex align-items-center justify-content-between">
                                <div class="project-title d-flex align-items-center">
                                    <div class="text">
                                        <small>Mensagem</small>
                                        <h3 class="h4">Cadastro excluído com sucesso!</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <? } ?>
            <section>
                <div class="container-fluid no-margin-bottom">
                    <div class="row">
                        <div class="chart col-lg-12 col-12">
                            <div class="bg-white align-items-center justify-content-center has-shadow format-box-forms">
                                <form method="get">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-inline">
                                                <div class="col-sm-12 col-md-10">
                                                    <div class="form-group">
                                                        <input id="pesquisa" type="text" name="pesquisa" placeholder="Nome / RA / E-mail" maxlength="100" style="width:100%" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-2">
                                                    <div class="form-group">
                                                        <button type="submit" name="pesq" class="btn btn-primary" value="ok">Pesquisar</button>
                                                    </div>
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
            <section class="tela no-margin-top no-padding-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="chart col-lg-12 col-12">
                            <div class="bg-white align-items-center justify-content-center has-shadow format-box-forms">
                                <? $qtd_usuarios =$objUsuario->QtdUsuarios($pesq);
                                   $objPaginacao = new Paginacao($qtd_usuarios);
                                   if (isset($_GET['ini']))
                                       $objPaginacao->SetIni($_GET['ini']);
                                   if (isset($_GET['itens']))
                                       $objPaginacao->SetItens($_GET['itens']);

                                   if ($objPaginacao->ValidarPaginacao()){
                                       $usuarios =$objUsuario->ListarUsuarios($pesq,$objPaginacao->GetIni(), $objPaginacao->GetItens());
                                       if (!$usuarios){
                                           echo "FAÇA A BUSCA NOS CAMPOS ACIMA.";
                                       }else{
                                           if ($qtd_usuarios==1)
                                               echo "Foi encontrado 1 usuário";
                                           else
                                               echo "Foram encontrados $qtd_usuarios usuários";
                                           echo "<br>".$objPaginacao->ItensPaginar();?>
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tipo</th>
                                                        <th id="lista_grd">Nome</th>
                                                        <th id="lista_grd">E-mail</th>
                                                        <th id="lista_grd">RA/Curso</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?foreach ($usuarios as $row) { ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <?=$row[0]?>
                                                        </th>
                                                        <td>
                                                            <?=$row[5]?>
                                                        </td>
                                                        <td id="lista_grd">
                                                            <?=$row[1]?>
                                                        </td>
                                                        <td id="lista_grd">
                                                            <?=$row[2]?>
                                                        </td>
                                                        <td id="lista_grd">
                                                            <?if ($row[4]){ echo $row[4]."/".$row[6]; }?>
                                                        </td>
                                                        <td class="text-right lista_botoes" style="color:#cc0000">
                                                            <a href="user_alt.php?id=<?=$row[0] ?>&pesq=<?=$pesq ?>">
                                                                <i class="fa fa-2x fa-check bt-alterar"></i>
                                                            </a>
                                                            <a href="#" onclick="validar_excluir('Tem certeza que deseja excluir este usuário?','users.php?id=<?=$row[0] ?>&pesq=<?=$pesq ?>')" aria-expanded="false" data-toggle="collapse">
                                                                <i class="fa fa-2x fa-close bt-excluir"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <? } ?>
                                                </tbody>
                                            </table>
                                            <? echo $objPaginacao->Paginar();
                                       }
                                   }else
                                       echo "PÁGINA INVÁLIDA"; ?>
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