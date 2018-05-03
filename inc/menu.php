<nav class="side-navbar">
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="../arquivos/<?php echo $_SESSION['adm_foto']; ?>" alt="<?php echo $_SESSION['adm_nome']; ?>" class="img-fluid rounded-circle"></div>
        <div class="title">
            <h4 class="h4"><?php echo $idUsuario = $objLogin->getIdUsuario(); ?></h4>
            <p><?php echo $tipoUsuario = $objLogin->getTipoUsuario(); ?></p>
        </div>
    </div>
    <ul class="list-unstyled">
        <li<?php if ($menu==""){?> class="active"<?php }?>> <a href="admin.php"> <i class="fa fa-2x fa-tachometer"></i>Dashboard</a></li>
        <? $cad=1;
        $list=1;
        $adm=1;?>
        <li<?php if ($menu=="users"){?> class="active"<?php }?>>
            <a href="#menu-users" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-2x fa-user"></i>Usuários</a>
            <ul id="menu-users" class="collapse list-unstyled">
                <? if ($cad==1){ ?><li><a href="user_cad.php">Cadastrar</a></li><? } ?>
                <? if ($list==1){ ?><li><a href="users.php">Manutenção</a></li><? } ?>
            </ul>
        </li>
        <li<?php if ($menu=="compras"){?> class="active"<?php }?>>
            <a href="#menu-compras" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-2x fa-user"></i>Vendas</a>
            <ul id="menu-compras" class="collapse list-unstyled">
                <? if ($cad==1){ ?><li><a href="vendas.php">Efetuar</a></li><? } ?>
            </ul>
        </li>
        <li<?php if ($menu=="produtos"){?> class="active"<?php }?>>
            <a href="#menu-produtos" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-2x fa-user"></i>Produtos</a>
            <ul id="menu-produtos" class="collapse list-unstyled">
                <? if ($cad==1){ ?><li><a href="produto_cad.php">Incluir</a></li><? } ?>
                <? if ($list==1){ ?><li><a href="produtos.php">Manutenção</a></li><? } ?>
            </ul>
        </li>
        <li<?php if ($menu=="config"){?> class="active"<?php }?>>
            <a href="#menu-config" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-2x fa-wrench"></i>Ajustes</a>
            <ul id="menu-config" class="collapse list-unstyled">
                <? if ($adm==1){ ?><li><a href="config.php">Configurações gerais</a></li><? } ?>
            </ul>
        </li>
    </ul>
</nav>