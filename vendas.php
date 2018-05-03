<?php
require_once(dirname(__FILE__).'/class/Login.php');
require_once(dirname(__FILE__).'/class/Produto.php');
require_once(dirname(__FILE__).'/class/Usuario.php');
require_once(dirname(__FILE__).'/class/Vendas.php');
$objLogin = new Login();

$objLogin->verificarLogado();

$objProduto = new Produto();
$objUsuario = new Usuario();

$objVendas = new Vendas();

if(!isset($_SESSION["vendas"])){
    $_SESSION['vendas'] = "";
}

if (isset($_POST['incluir'])){
    $objProduto->getDados($_POST['produto']);
    $vendas=$objVendas->Carrinho($objProduto->getCodProduto(),$objProduto->getNomeCategoria()." ".$objProduto->getNomeProduto(),$objProduto->getValorProduto());
    header ('Location: vendas.php');
}

if (isset($_POST['qtd'])){
    $objVendas->AltQtd($_POST['id'],$_POST['qtd']);
    header ('Location: vendas.php');
}

if (isset($_POST['limpar'])){
    $objVendas->LimparCarrinho();
}

if (isset($_POST['avancar'])){
    header ('Location: vendas_finalizar.php');
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
                    <h2 class="no-margin-bottom">Vendas</h2>
                </div>
            </header>
            <section>
                <div class="container-fluid no-margin-bottom">
                    <div class="row">
                        <div class="chart col-lg-12 col-12">
                            <div class="bg-white align-items-center justify-content-center has-shadow format-box-forms">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-inline">
                                                <div class="col-sm-12 col-md-9">
                                                    <? $produtos = $objProduto->ListarProdutos('',0,$objProduto->QtdProdutos(''));?>
                                                    <div class="form-group-material select cprodutos">
                                                        <select id="produto" name="produto" class="input-material" required />
                                                            <option value="">Selecione um produto</option>
                                                            <?foreach ($produtos as $row) {
                                                                  echo "<option value=\"".$row[0]."\" />".$row[5]." ".$row[1]." R$ ".str_replace(".",",",$row[2])."</option>\n";
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <button type="submit" name="incluir" class="btn btn-primary" value="ok">Incluir no Carrinho</button>
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
                                <?if (!is_array($_SESSION['vendas'])){
                                    echo "CARRINHO VAZIO.";
                                }else{
                                    $carrinho_qtdItens=count($_SESSION['vendas']);
                                    if ($qtd_usuarios==1)
                                        echo "1 item no carrinho";
                                    else
                                        echo "$carrinho_qtdItens itens no carrinho";
                                    echo "<br>";
                                    
                                    $total_qtd=0;
                                    $total_unit=0;
                                    $total=0;?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Produto</th>
                                                <th id="lista_grd">Qtd</th>
                                                <th id="lista_grd">Valor Unit</th>
                                                <th id="lista_grd">Valor</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody><?for ($i=0;$i<$carrinho_qtdItens;$i++) {
                                                $qtd=$_SESSION['vendas'][$i]['qtd_produto'];
                                                $valor=$_SESSION['vendas'][$i]['vl_produto'];

                                                $total_qtd+=$qtd;
                                                $total_unit+=$valor;
                                                $total+=($valor*$qtd);

                                                $valor=number_format(str_replace(".",",",$valor),2);?>
                                                
                                                <tr>
                                                    <th scope="row"><?=$i+1?>
                                                    </th>
                                                    <td><?=$_SESSION['vendas'][$i]['nome_produto']?>
                                                    </td>
                                                    <td id="lista_grd"><form id="item<?=$i?>" method="post"><input type="hidden" name="id" value="<?=$i?>" /><input id="qtd" type="number" name="qtd" value="<?=$qtd?>" maxlength="3" class="qtd_carrinho" min="1" max="99" required /></form></td>
                                                    <td id="lista_grd"><?=$valor?>
                                                    </td>
                                                    <td id="lista_grd"><?=number_format($qtd*$valor,2)?>
                                                    </td>
                                                    <td class="text-right lista_botoes" style="color:#cc0000">
                                                        <a href="#" onclick="validar_alterar('item<?=$i?>')" aria-expanded="false" data-toggle="collapse">
                                                            <i class="fa fa-2x fa-check bt-alterar"></i>
                                                        </a>
                                                        <a href="#" onclick="validar_excluir('Tem certeza que deseja excluir este item?','users11.php?id=<?=$row[0] ?>&pesq=<?=$pesq ?>')" aria-expanded="false" data-toggle="collapse">
                                                            <i class="fa fa-2x fa-close bt-excluir"></i>
                                                        </a>
                                                    </td>
                                            </tr><? } ?>
                                            <tr>
                                                <th scope="row"></th>
                                                <td></td>
                                                <td id="lista_grd carrinho_total"><?=$total_qtd?></td>
                                                <td id="lista_grd carrinho_total"><?=number_format($total_unit,2)?></td>
                                                <td id="lista_grd carrinho_total"><?=number_format($total,2)?></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-sm-12">
                                        <div class="form-inline">
                                            <div class="col-sm-6">
                                                <div class="form-group pull-left">
                                                    <form id="carrinho-limpar" method="post"><input type="hidden" name="limpar" value="ok" /><button type="button" name="bt-limpar" class="btn btn-secondary" value="limpar" onclick="validar_limpar('Tem certeza que deseja excluir todos os itens do carrinho?','carrinho-limpar')">Limpar Carrinho</button></form>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group pull-right">
                                                    <form id="carrinho-avancar" method="post"><button type="submit" name="avancar" class="btn btn-primary" value="avancar">Avançar</button></form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
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