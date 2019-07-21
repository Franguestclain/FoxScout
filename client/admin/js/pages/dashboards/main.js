$(document).ready(function(){

    function limpiarFormulario(modal,formulario){
        $(modal).on('hidden.bs.modal', function(e){
            // $(formulario)
            // .not(':button, :submit, :reset, :hidden')
            // .val('')
            // .removeAttr('checked')
            // .removeAttr('selected');
            $(formulario)[0].reset();
        });
    };
    
    // Ajax agregar Tienda 
    $("#addTienda").submit(function(e){
        e.preventDefault();
        
        let datos = new FormData(this); //Vanilla Serialize
        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: datos,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function(data, status, jqXHR){
                if(data.status === "1"){
                    $("#modalAgregarTienda").modal("hide");
                    limpiarFormulario("#modalAgregarTienda", "#addTienda");
                    let newRow = `<tr> <td>${data.id}</td> <td>${data.nombre}</td> <td><img class='img-tienda' src='${data.rutaImg}' /></td> </tr>`
                    $("#table-body-tienda").append(newRow);
                }else{
                    let mensaje = `<div id='alertAddTiendaError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-tienda").append(mensaje);
                    $("#alertAddTiendaError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertAddTiendaError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertAddTiendaError").remove();
                        },500);
                    },2000);
                }
            },
            error: function(data, status, error){
                console.log(data);
                console.log(status);
                console.log(error);
            }
        });
    });


});