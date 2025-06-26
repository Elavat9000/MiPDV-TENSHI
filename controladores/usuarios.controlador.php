<?php

class ControladorUsuarios{
/*=====================================
Ingreso de Usuario
=======================================*/
    public function ctrIngresoUsuario(){
        if(isset($_POST["ingUsuario"])) {
            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && 
            preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])) {
                
                $tabla = "usuarios"; 
                $item = "usuario";
                $valor = $_POST["ingUsuario"];
                $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
                
                // Check if $respuesta is valid and contains data
                if(is_array($respuesta) && 
                $respuesta["usuario"] == $_POST["ingUsuario"] && 
                $respuesta["password"] == $_POST["ingPassword"]) {


                    $_SESSION["iniciarSesion"] = "ok";

                    echo '<script>
                    window.location = "inicio";
                    </script>';
                    
                    // Successful login logic here
                    
                } else {
                    echo '<br> <div class="alert-danger" style="margin-bottom: 20px;">Error al ingresar, vuelve a intentarlo</div><br>';
                }
            }
        }
    }
}