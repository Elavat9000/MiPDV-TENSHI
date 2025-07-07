<header class="main-header">

    <!-- ==========================================
    LOGOTIPO
    ==============================================-->

    <a href="inicio" class="logo">
        <!-- LOGO MINI-->
        <span class="logo-mini">
            <img src="vistas/img/plantilla/logo.png" class="img-responsive" style="padding: 5px; max-height: 50px;">
        </span>

        <!-- LOGO NORMAL-->
        <span class="logo-lg">
            <img src="vistas/img/plantilla/logo-plano.png" class="img-responsive" style="padding-top: 0px; max-height: 50px;">
        </span>
    </a>

    <!-- ==========================================
    BARRA DE NAVEGACION
    ==============================================-->

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        
        <!--Perfil de usuario-->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                    <?php

                        if($_SESSION["foto"] != ""){

                            echo'<img src=" '.$_SESSION["foto"].'" class="user-image" width="40px" height="40px">';

                        }else{
                        
                            echo '<img src="vistas\Img\usuarios\default\usuario.png" class="user-image" width="40px" height="40px">';

                        }

                    ?>
                
                        <span class="hiden-xs"> <?php echo $_SESSION["nombre"]; ?></span>

                    </a>
                      <!--DropDown-Toggle-->

                    <ul class="dropdown-menu">
                        <li class="user-body">
                            <div class="pull-rigth">
                                <a href="salir" class="btn btn-default btn-flat">Salir</a>
                            </div>
                        </li>
                    </ul>

                </li>
            </ul>
        </div>

    </nav>

</header>