/*===================================================
***********SUBIENDO LA FOTO DEL USUARIO************
=================================================*/

$(".nuevaFoto").change(function(){

    var imagen = this.files[0];
    console.log("imagen", imagen);
    /*===================================================
    ***********VALIDACION DE FORMATO DE IMAGEN***********
    =================================================*/
    if(imagen["type"]!= "image/jpeg" && imagen["type"] != "image/png"){

        $(".nuevaFoto").val("");

        Swal.fire({
            icon: "Error al subir la imagen",
            title: "!La imagen debe estar en formato JPG o PNG¡",
            type: "error",
            confirmButtonText: "¡Cerrar!"});

    }else if(imagen["size"]>2000000){

        $(".nuevaFoto").val("");

        Swal.fire({
            icon: "Error al subir la imagen",
            title: "!La imagen no debe pesar mas de 2MB¡",
            type: "error",
            confirmButtonText: "¡Cerrar!"
        });

    }else{

        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);

        $(datosImagen).on("load", function(event){

            var rutaImagen = event.target.result;

            $(".previsualizar").attr("src", rutaImagen);


        })
    }
})

/*===================================================
**************EDITAR USUARIO JAVASCRIPT**********
=================================================*/

$(".btnEditarUsuario").click(function(){

    var idUsuario = $(this).attr("idUsuario");

    
    var datos = new FormData(); 
    datos.append("idUsuario", idUsuario);

    $.ajax({

        url:"ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){

            $("#editarNombre").val(respuesta["nombre"]);
            $("#editarUsuario").val(respuesta["usuario"]);
            $("#editarPerfil").html(respuesta["perfil"]);
            $("#editarPerfil").val(respuesta["perfil"]);
             $("#fotoActual").val(respuesta["foto"]);


            $("#passwordActual").val(respuesta["password"]);


            if(respuesta["foto"] != ""){

                $(".previsualizar").attr("src", respuesta["foto"]);


            }

        }

    });

})

/*===================================================
*******************ACTIVAR USUARIO ****************
=================================================*/

$(".btnActivar").click(function(){

    var idUsuario = $(this).attr("idUsuario");
    var estadoUsuario = $(this).attr("estadoUsuario");

    var datos = new FormData();
    datos.append("activarId", idUsuario);
    datos.append("activarUsuario", estadoUsuario);

    $.ajax({

        url:"ajax/usuarios.ajax.php",
        method:"POST",
        data: datos,
        cache: false,
        contentType:false,
        processData: false,
        success: function(respuesta){

        }

    })

    if(estadoUsuario == 0){

        $(this).removeClass('btn-success');
        $(this).addClass('btn-danger');
        $(this).html('Desactivado');
        $(this).attr('estadoUsuario', 1);
        

    }else{

        $(this).addClass('btn-success');
        $(this).removeClass('btn-danger');
        $(this).html('Activado');
        $(this).attr('estadoUsuario', 0);

    }

})

/*===================================================
*****************REVISAR USUARIO REPETIR*************** 
==================================================*/

$("#nuevoUsuario").change(function(){

    //$(".alert").remove();

    var usuario = $(this).val();

    var datos = new FormData();
    datos.append("validarUsuario", usuario);

    $.ajax({

        url:"ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            

            if(respuesta){
                
                    $// Insertar el mensaje
                        let mensaje = $('<div class="alert alert-warning">Este usuario ya existe en la base de datos</div>');
                        $("#nuevoUsuario").parent().after(mensaje);

                        // Limpiar el input
                        $("#nuevoUsuario").val("");

                        // Desaparecer y eliminar el mensaje después de 10 segundos
                        setTimeout(function(){
                        mensaje.fadeOut("slow", function(){
                            $(this).remove();
                        });
                        }, 4000);

            
            }
        }

    })

})