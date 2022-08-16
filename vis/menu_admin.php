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
        <div id="navbar" class="collapse navbar-collapse" >
            <ul class="nav navbar-nav">
                <li><a href="?pg=catalogo_prod">Prodúctos</a></li>
                <li><a href="?pg=pub_ofert">Oferta</a></li>
                <li><a href="?pg=pub_frec">Preguntas frecuentes</a></li>
                <li><a href="?pg=pub_soporte">Soporte</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">               
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Registros<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="?pg=new_negocio">Gestionar Negocios</a></li>
                        <li><a href="?pg=ges_categoria">Gestionar Categorias</a></li>
                    <!--<li><a href="?pg=ges_contorno">Contornos</a></li>
                        <li><a href="?pg=new_producto">Productos</a></li>
                        <li><a href="?pg=">Sub-productos</a></li>-->
                        <li><a href="?pg=">Repartidor</a></li>                                    
                    </ul>
                </li>                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Operaciones<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="?pg=">Monitor de ordenes</a></li>
                        <li><a href="?pg=">Validar pago</a></li>                       
                        <!--<li><a href="?pg=">Cierre de operaciones</a></li>
                        <li><a href="?pg=">Enviar Correo</a></li> -->
                        <li><a href="?pg=ges_usuarios">Gestinoar usuarios</a></li>                                   
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['nom'] . ' ' . $_SESSION['ape']; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="?pg=mi_cuenta">Mis datos</a></li>
                        <li><a href="?pg=eerferv">Mi negocio</a></li>
                        <li><a href="?pg=">Cofigurar sitio</a></li>
                        <li><a href="control/sesion_off.php">Salir</a></li>
                        <li role="separator" class="divider"></li>                                    
                        <li><a href="#">Ayuda</a></li>                                    
                    </ul>
                </li> 
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>