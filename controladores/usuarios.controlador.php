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

                $tabla = 'usuarios';
                $datos = array("nombre"=>$_POST["nuevoNombre"],
                               "usuario"=>$_POST["nuevoUsuario"],
                               "password"=>$_POST["nuevoPassword"],
                               "perfil"=>$_POST["nuevoPerfil"]);

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