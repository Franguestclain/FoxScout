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

    function checkboxes(checkAll, checkboxes){
        $(checkAll).on('click', function(){
            if(this.checked){
                $(checkboxes).each(function(){
                    this.checked = true;
                });
            }else{
                $(checkboxes).each(function(){
                    this.checked = false;
                });
            }
        });

        $(checkboxes).on('click', function(){
            if( $(checkboxes+":checked").length == $(checkboxes).length ){
                $(checkAll).prop('checked',true);
            }else{
                $(checkAll).prop('checked',false);
            }
        });

    }

    const evaluarEditar = (checkAll, checkboxes) =>
                ( $(checkAll).checked || $(checkboxes+":checked").length > 1 || $(checkboxes+":checked").length == 0 ) ?  true : false;

    const evaluarDel = (checkAll,checkboxes) => ( $(checkboxes+":checked").length == 0 || $(checkAll).checked === false ) ? true : false;

    /**
     * ==============================
     *          TIENDA
     * ==============================
     */

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
                    let newRow = `<tr>
                    <td><input style='display: none;' class='inp-cbx checkboxTienda' type='checkbox' name='check-Tienda${data.id}' id='check-Tienda${data.id}'>
                                    <label class='cbx' for='checkAll-Tienda'>
                                        <span>
                                            <svg width='12px' height='10px' viewbox='0 0 12 10'>
                                                <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                            </svg>
                                        </span>
                                    </label></td><td>${data.id}</td><td>${data.nombre}</td> <td><img class='img-tienda' src='${data.rutaImg}' /></td> </tr>`
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

    // Eventos de checkboxes
    checkboxes("#checkAll-Tienda",".checkboxTienda")

    // Animacion al hacer click en editar
    $("#btnEditarTienda").on('click', function(){
        // Evaluamos si solo hay un checkbox seleccionado
        if( evaluarEditar("#checkAll-Tienda",".checkboxTienda") ){
            $("#alertGen").append("Para realizar esta accion, selecciona solo un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGen").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGen").toggleClass("animated");
                },500);
            },2000);
        }else{
            let id = $(".checkboxTienda:checked").attr("data-idRow");
            let nombre = $("#datos-"+id).text();
            $("#editNombre").val(nombre);
            $("#id-edit").val(id);
            $("#modalEditarTienda").modal("show");
            limpiarFormulario("#modalEditarTienda","#editTienda");
        }
    });

    // Ajax de formulario para editar
    $("#editTienda").submit(function(e){
        e.preventDefault();
        let datos = new FormData(this); //Vanilla Serialize
        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: datos,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data, status, jqXHR){
                if(data.status == 1){
                    setTimeout(function(){
                        $("#modalEditarTienda").modal("hide");
                        limpiarFormulario("#modalEditarTienda","#editTienda");
                        $("#temporal").remove();
                        window.location.href = "tiendas.php";
                    },1000);
                }else{
                    let mensaje = `<div id='alertAddTiendaError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-editienda").append(mensaje);
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


    // Borrar tiendas
    $("#btnEliminarTienda").on('click', function(){
        if( evaluarDel("#checkAll-Tienda",".checkboxTienda") ){
            $("#alertGen").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGen").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGen").toggleClass("animated");
                },500);
            },2000);
        }else{
            $("#modalDel").modal("show");
        }
    });

    // Boton OK de confirmacion
    $("#confirmar").on('click', function(){
        let ids = $.map($(".checkboxTienda:checked"), (x) => $(x).attr('data-idRow') );
        $.ajax({
            url: "./actions/delTienda.php",
            method: "POST",
            data: {ids: ids},
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == 1){
                    data.arr.forEach((item) => $("#row-"+item).remove() );
                    $("#modalDel").modal('hide');
                }else{
                    console.log("Nel no jalo");
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