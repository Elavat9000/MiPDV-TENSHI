<?php

class ControladorUsuarios{
    /*=====================================
    Ingreso de Usuario
    =======================================*/
    static public function ctrIngresoUsuario(){
        if(isset($_POST["ingUsuario"])) {
            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && 
               preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])) {

                $encriptar = crypt($_POST["ingPassword"], '$2a$07$usesomesillystringforsalt$');
                
                $tabla = "usuarios"; 
                $item = "usuario";
                $valor = $_POST["ingUsuario"];
                $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

                if ($respuesta["usuario"] == $_POST["ingUsuario"] && $respuesta["password"] == $encriptar){

                    if($respuesta["estado"]== 1 ){
         
                            $_SESSION["iniciarSesion"] = "ok";
                            $_SESSION["id"] = $respuesta["id"];
                            $_SESSION["nombre"] = $respuesta["nombre"];
                            $_SESSION["usuario"] = $respuesta["usuario"];
                            $_SESSION["foto"] = $respuesta["foto"];
                            $_SESSION["perfil"] = $respuesta["perfil"];


                        echo '<script>
                            window.location = "inicio";
                            </script>';

                    }else{


                        echo '<br>
                                <div class="alert alert-danger" >El usuario aún no está activado</div>';

                    }
                
                    
                } else {
                    echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Usuario o contraseña incorrectos!",
                            footer: "<a href=\'recuperar-contrasena\'>¿Olvidaste tu contraseña?</a>"
                        });
                    </script>';
                }
            }
        }
    }

    /*=====================================
    Registro de Usuario
    =======================================*/
    static public function ctrCrearUsuario(){
        if(isset($_POST['nuevoUsuario'])) {
            
            if(preg_match('/^[a-zA-Z0-9ñÑáéióúÁÉÍÓÚ ]+$/', $_POST['nuevoNombre']) && 
               preg_match('/^[a-zA-Z0-9]+$/', $_POST['nuevoUsuario']) &&
               preg_match('/^[a-zA-Z0-9]+$/', $_POST['nuevoPassword'])){

                /*=====================================
                        VALIDAR IMAGEN
                =======================================*/ 
                
                $ruta = "";

                if(isset($_FILES['nuevaFoto']["tmp_name"])) {

                    list($ancho,$alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /*=================================================================
                        Creamos el directorio donde vamos a guarda la foto del usuario
                    ====================================================================*/ 

                    $directorio = "vistas/img/usuarios/".$_POST["nuevoUsuario"];

                    mkdir($directorio,0755);

                    /*===========================================================================
                        DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                    =============================================================================*/ 

                    if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){

                        /*===========================================================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================================================*/ 
                        
                        $aleatorio = mt_rand(100,999);

                        if(!file_exists($directorio)){
                            mkdir($directorio,0755,true);
                        }

                        $ruta = $directorio."/".$aleatorio.".jpg";

                        $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino,$origen,0,0,0,0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino,$ruta);


                    }

                    if($_FILES["nuevaFoto"]["type"] == "image/png"){

                        /*===========================================================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================================================*/ 
                        
                        $aleatorio = mt_rand(100,999);

                        if(!file_exists($directorio)){
                            mkdir($directorio,0755,true);
                        }

                        $ruta = $directorio."/".$aleatorio.".png";

                        $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino,$origen,0,0,0,0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino,$ruta);


                    }


                }
                 
                $tabla = 'usuarios';

                $encriptar = crypt($_POST["nuevoPassword"], '$2a$07$usesomesillystringforsalt$');

                $datos = array("nombre"=>$_POST["nuevoNombre"],
                               "usuario"=>$_POST["nuevoUsuario"],
                               "password"=>$encriptar,
                               "perfil"=>$_POST["nuevoPerfil"],
                                "foto" =>$ruta);

                $respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);

                if($respuesta == "ok"){
                    echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "El usuario ha sido guardado correctamente",
                            text: "Bien hecho campeon, eres un hacker",
                            footer: "Te falta comer zanahoria si no logras ver esto"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "usuarios";
                            }
                        });
                     </script>';

                }



            

            } else {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error en el formulario",
                        text: "El usuario no puede ir vacío o llevar caracteres especiales",
                        footer: "Por favor usa solo letras y números"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "usuarios";
                        }
                    });
                </script>';
            }
        }
    }

    /*===========================================================================
                        MOSTRAR USUARIOS
    =============================================================================*/ 


    static public function ctrMostrarUsuarios($item, $valor) {

        $tabla = "usuarios";

    
        $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);
        
        return $respuesta;  
    
    }

    /*===========================================================================
                        EDITAR USUARIOS
    =============================================================================*/ 

    public static function ctrEditarUsuario() {

        if(isset($_POST["editarUsuario"])){

            if(preg_match('/^[a-zA-Z0-9ñÑáéióúÁÉÍÓÚ ]+$/', $_POST['editarNombre'])){
               
            /*=====================================
                        VALIDAR IMAGEN
            =======================================*/ 
                
                $ruta = $_POST['fotoActual'];

                if(isset($_FILES['editarFoto']["tmp_name"]) && !empty($_FILES['editarFoto']["tmp_name"])) {

                    list($ancho,$alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /*=================================================================
                        Creamos el directorio donde vamos a guarda la foto del usuario
                    ====================================================================*/ 

                    $directorio = "vistas/img/usuarios/".$_POST["editarUsuario"];

                    /*=================================================================
                        PREGUNTEMOS SI EXISTE UNA IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO PHP
                    ====================================================================*/ 
                    if(!empty($_POST["fotoActual"])){

                        unlink($_POST["fotoActual"]);


                    }else{

                         mkdir($directorio,0755);


                    }

                    /*===========================================================================
                        DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                    =============================================================================*/ 

                    if($_FILES["editarFoto"]["type"] == "image/jpeg"){

                        /*===========================================================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================================================*/ 
                        
                        $aleatorio = mt_rand(100,999);

                        if(!file_exists($directorio)){
                            mkdir($directorio,0755,true);
                        }

                        $ruta = $directorio."/".$aleatorio.".jpg";

                        $origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino,$origen,0,0,0,0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino,$ruta);


                    }

                    if($_FILES["editarFoto"]["type"] == "image/png"){

                        /*===========================================================================
                        GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                        =============================================================================*/ 
                        
                        $aleatorio = mt_rand(100,999);

                       
                        $ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".png";

                        $origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino,$origen,0,0,0,0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino,$ruta);


                    }


                }


                $tabla ='usuarios'; 
            
                if($_POST['editarPassword'] != ""){

                    if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['editarPassword'])){
                        

                        $encriptar = crypt($_POST["editarPassword"], '$2a$07$usesomesillystringforsalt$');


                    }else{

                        echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "!La contraseña no puede ir vacia o llevar caracteristicas especiales¡",
                                showConfirmButton: true,
                                confirmButtonText:"Cerrar",
                                closeOnConfirm:false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = "usuarios";
                                }
                            });
                        </script>';

                    }
            

                }else{

                 $encriptar = $_POST["passwordActual"];

                }

                $datos = array( "nombre"=>$_POST["editarNombre"],
                                "usuario"=>$_POST["editarUsuario"],
                                "password"=>$encriptar,
                                "perfil"=>$_POST["editarPerfil"],
                                "foto"=>$ruta);      

                $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla,$datos);   
                if($respuesta == "ok"){

                    echo '<script>
                            Swal.fire({
                                icon: "success",
                                title: "El usuario ha sido modificado correctamente",
                                text: "Bien hecho campeon, eres un hacker",
                                footer: "Te falta comer zanahoria si no logras ver esto"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = "usuarios";
                                }
                            });
                        </script>';

                
                
                
                    }

                }

        }


    }


}