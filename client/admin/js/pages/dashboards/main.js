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
                    let newRow = `<tr id='row-${data.id}'>
                    <td><input style='display: none;' class='inp-cbx checkboxTienda' type='checkbox' data-idRow='${data.id}' name='check-Tienda${data.id}' id='check-Tienda${data.id}'>
                                    <label class='cbx' for='check-Tienda${data.id}'>
                                        <span>
                                            <svg width='12px' height='10px' viewbox='0 0 12 10'>
                                                <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                            </svg>
                                        </span>
                                    </label></td><td>${data.id}</td><td id='datos-${data.id}'>${data.nombre}</td> <td><img class='img-tienda' src='${data.rutaImg}' /></td> </tr>`
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
    checkboxes("#checkAll-Tienda",".checkboxTienda");

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


    // Evaluar Chkbxs Borrar tiendas
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

    /**
     * ==============================
     *          Localidades
     *      (Estados y ciudades)
     * ==============================
     */
    $("#addEstado").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status === "1"){
                    $("#modalAgregarEstado").modal("hide");
                    limpiarFormulario("#modalAgregarEstado", "#addEstado");
                    let newRow = `<tr id='row-estado${data.id}'>
                    <td><input style='display: none;' class='inp-cbx checkboxEstado' type='checkbox' data-idRow='${data.id}' name='check-Estado${data.id}' id='check-Estado${data.id}'>
                                    <label class='cbx' for='check-Estado${data.id}'>
                                        <span>
                                            <svg width='12px' height='10px' viewbox='0 0 12 10'>
                                                <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                            </svg>
                                        </span>
                                    </label></td><td>${data.id}</td><td id='datos-nombre-estado-${data.id}'>${data.nombre}</td></tr>`
                    $("#table-body-estado").append(newRow);
                }else{
                    let mensaje = `<div id='alertAddEstadoError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-estado").append(mensaje);
                    $("#alertAddEstadoError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertAddEstadoError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertAddEstadoError").remove();
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
    checkboxes("#checkAll-Estado",".checkboxEstado");

    // Evaluar editar estado
    $("#btnEditarEstado").on('click', function(){
        if( evaluarEditar("#checkAll-Estado",".checkboxEstado") ){
            $("#alertGenEstado").append("Para realizar esta accion, selecciona solo un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenEstado").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenEstado").toggleClass("animated");
                },500);
            },2000);
        }else{
            let id = $(".checkboxEstado:checked").attr("data-idRow");
            let nombre = $("#datos-nombre-estado-"+id).text();
            $("#editNombreEstado").val(nombre);
            $("#id-edit-estado").val(id);
            $("#modalEditarEstado").modal("show");
            limpiarFormulario("#modalEditarEstado","#editEstado");
        }
    });

    // Submit de editado de estado
    $("#editEstado").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == 1){
                    setTimeout(function(){
                        $("#modalEditarEstado").modal("hide");
                        limpiarFormulario("#modalEditarEstado","#editEstado");
                        $("#temporal").remove();
                        window.location.href = "localidades.php";
                    },1000);
                }else{
                    let mensaje = `<div id='alertEditEstadoError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-editEstado").append(mensaje);
                    $("#alertEditEstadoError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertEditEstadoError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertEditEstadoError").remove();
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

    // Evaluar Chkbxs Borrar Estado
    $("#btnEliminarEstado").on('click', function(){
        if( evaluarDel("#checkAll-Estado",".checkboxEstado") ){
            $("#alertGenEstado").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenEstado").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenEstado").toggleClass("animated");
                },500);
            },2000);
        }else{
            $("#modalDelEstado").modal("show");
        }
    });

    // Boton OK de confirmacion
    $("#confirmarEstado").on('click', function(){
        let ids = $.map($(".checkboxEstado:checked"), (x) => $(x).attr('data-idRow') );
        $.ajax({
            url: "./actions/delEstado.php",
            method: "POST",
            data: {ids: ids},
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == 1){
                    data.arr.forEach((item) => $("#row-estado"+item).remove() );
                    $("#modalDelEstado").modal('hide');
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

    $("#addCiudad").submit(function(e){
        e.preventDefault();

        let info = $(this).serialize();

        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: info,
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == "1"){
                    $("#modalAgregarCiudad").modal("hide");
                    limpiarFormulario("#modalAgregarCiudad", "#addCiudad");
                    let newRow = `<tr id='row-ciudad${data.id}'>
                    <td><input style='display: none;' class='inp-cbx checkboxCiudad' type='checkbox' data-idRow='${data.id}' name='check-Ciudad${data.id}' id='check-Ciudad${data.id}'>
                                    <label class='cbx' for='check-Ciudad${data.id}'>
                                        <span>
                                            <svg width='12px' height='10px' viewbox='0 0 12 10'>
                                                <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                            </svg>
                                        </span>
                                    </label></td> <td>${data.id}</td> <td id='datos-nombre-ciudad-${data.id}'>${data.nombre}</td> <td>${data.estado}</td> </tr>`
                    $("#table-body-ciudad").append(newRow);
                }else{
                    let mensaje = `<div id='alertAddCiudadError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-ciudad").append(mensaje);
                    $("#alertAddCiudadError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertAddCiudadError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertAddCiudadError").remove();
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