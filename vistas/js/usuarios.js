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