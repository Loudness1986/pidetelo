<nav class="navbar navbar-default navbar-fixed-top" >
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="?">
                <img src="recursos/img/branb.png" width="100" height="35" alt="logo"/>
            </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse" ><!--menu dereho-->
            <ul class="nav navbar-nav">
                <li><a href="?pg=catalogo_prod">Prodúctos</a></li>
                <li><a href="?pg=pub_ofert">Oferta</a></li>
                <li><a href="?pg=pub_frec">Preguntas frecuentes</a></li>
                <li><a href="?pg=pub_soporte">Soporte</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right"> <!--menu izquierdo-->
                <?php
                require_once 'clases/cls_load.php';
                $objeto = new load();
                $cod = $_SESSION['id'];
                $con_sql = "SELECT * FROM negocio JOIN det_negocio_usuario ON det_negocio_usuario.cod_neg=negocio.cod_neg WHERE det_negocio_usuario.cod_user='$cod';";
                $datos = $objeto->load_arry($objeto->load_con("$con_sql"));
                    
                if ($_SESSION['nego'] == 'S' && $datos['estado_neg'] == 'ACTIVO') {
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Registros<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="?pg=ges_contorno">Contornos</a></li>
                            <li><a href="?pg=new_producto">Productos</a></li>
                            <li><a href="?pg=new_sub_producto">Sub-productos</a></li>                                   
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Operaciones<span class="caret"></span></a>
                        <ul class="dropdown-menu">    
                            <li><a href="?pg=">Monitor de ordenes</a></li>
                            <li><a href="?pg=">Cierre de operaciones</a></li>                                   
                        </ul>
                    </li>
                <?php } ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['nom'] . ' ' . $_SESSION['ape']; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="?pg=mi_cuenta">Mi Cuenta</a></li>                        
                        <li><a href="?pg=compras">Mis Pedidos</a></li>
                        <?php
                        if ($_SESSION['nego'] == 'S') {
                            ?>
                            <li class="active"><a href="?pg=mi_negocio">Mi Negocio</a></li>
                        <?php } ?>
                        <li><a href="control/sesion_off.php">Salir</a></li>
                        <li role="separator" class="divider"></li>                                    
                        <li><a href="#">Ayuda</a></li>                                    
                    </ul>
                </li>  
            </ul>
        </div>
    </div>
</nav>