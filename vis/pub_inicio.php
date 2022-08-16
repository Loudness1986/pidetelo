
<hr class="featurette-divider">
<div class="container">

    <div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto; width: 1140px;  height: 350px; overflow: hidden;">

        <!-- cargando imagen -->
        <div data-u="loading" style="position:absolute;top:0px;left:0px;background:url('recursos/img/loading.gif') no-repeat 50% 50%; background-color: rgba(0, 0, 0, .7);"></div>

        <!-- Slides Container -->
        <div u="slides" style="position: absolute; left: 0px; top: 0px; width: 1140px; height: 350px;
             overflow: hidden;">
            <div>
                <img u="image" src2="recursos/img/baner_p.png" class="img-fluid" alt="Responsive image"/>
            </div>
            <div>
                <img u="image" src2="recursos/img/baner_s.png" class="img-fluid" alt="Responsive image"/>
            </div>
            <div>
                <img u="image" src2="recursos/img/baner_t.png" class="img-fluid" alt="Responsive image"/>
            </div>
            <div>
                <img u="image" src2="recursos/img/baner_c.png" class="img-fluid" alt="Responsive image"/>
            </div>
        </div>

        <!--#region Bullet Navigator Skin Begin -->
        <style>
            .jssorb051 .i {position:absolute;cursor:pointer;}
            .jssorb051 .i .b {fill:#fff;fill-opacity:0.5;stroke:#000;stroke-width:400;stroke-miterlimit:10;stroke-opacity:0.5;}
            .jssorb051 .i:hover .b {fill-opacity:.7;}
            .jssorb051 .iav .b {fill-opacity: 1;}
            .jssorb051 .i.idn {opacity:.3;}
        </style>
        <div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:16px;height:16px;">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                </svg>
            </div>
        </div>
    </div>
</div>
<hr class="featurette-divider">

<section id="main">
    <div class="container">
        <div class="row">                   

            <?php
            include 'vis/modulo/panel_izquierdo.php';
            require_once 'clases/cls_load.php';
            $obje = new load();
            $cosulta = $obje->load_con('SELECT * FROM producto JOIN det_prod_negocio ON det_prod_negocio.cod_pro=producto.cod_pro ORDER BY producto.visi_pro DESC LIMIT 0, 7');
            ?>                 

            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading main-color-bg">
                        <h3 class="panel-title">Más vendidos</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        while ($row = $obje->load_arry($cosulta)) {
                            ?>      
                            <div class="col-md-3">
                                <div class="well dash-box">
                                    <a href='?pg=detalle_catalogo_prod&CodProd=<?php echo $row['id_tama'] ?>' ><img src="subidas/<?php echo $row['logo_ful_pro'] ?>" style="width: 157px; height: 100px"/> </a>
                                    <small><?php echo 'Bfs.'.$row['precio_pro'] ?></small>
                                    
                                </div>
                            </div>

                            <?php
                        }
                        ?>  
                        <div class="col-md-3">
                            <div class="well dash-box">
                                <h2><span class="fa fa-thumbs-o-up" aria-hidden="true"></span> Píde!</h2>
                                <h4> Disfruta</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <?php require_once 'vis/modulo/ultimas_noticias.php'; ?>     
            </div>
            </section>

