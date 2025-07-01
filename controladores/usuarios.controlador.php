<?php

class ControladorUsuarios{
    /*=====================================
    Ingreso de Usuario
    =======================================*/
    static public function ctrIngresoUsuario(){
        if(isset($_POST["ingUsuario"])) {
            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && 
               preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])) {
                
                $tabla = "usuarios"; 
                $item = "usuario";
                $valor = $_POST["ingUsuario"];
                $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);
                
                if(is_array($respuesta) && 
                   $respuesta["usuario"] == $_POST["ingUsuario"] && 
                   $respuesta["password"] == $_POST["ingPassword"]) {

                    $_SESSION["iniciarSesion"] = "ok";
                    echo '<script>
                        window.location = "inicio";
                    </script>';
                    
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
                        Registro de Usuario
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

                        imagejpeg($destino,$ruta);


                    }


                }
                

                $tabla = 'usuarios';
                $datos = array("nombre"=>$_POST["nuevoNombre"],
                               "usuario"=>$_POST["nuevoUsuario"],
                               "password"=>$_POST["nuevoPassword"],
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
}