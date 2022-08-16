<header id="header">
    <div class="container" style="margin-top: 33px ">
        <div class="row">
            <div class="col-md-10">
                <h1><span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> Catalogo <small>productos</small></h1>
            </div>            
        </div>
    </div>
</header>
<style>
    .thumbnail {
        display: block;
        padding: 4px;        
        margin-bottom: 25px;
        line-height: 1.42857143;
        background-color: #fff;
        border: 1px #ddd solid;
        border-radius: 4px;
        -webkit-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;

    }
    .thumbnail .caption {
        padding: 9px;
        color: #333;
    }
</style>
<section id="main">
    <div class="container">
        <div class="row">
            <?php include 'vis/modulo/panel_izquierdo.php'; ?>
            <div class="col-md-10" >
                <?php include_once 'control/ctrl_catalogo_prod.php'; ?>
            </div>                
        </div>
    </div>
</section>
