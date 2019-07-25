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
            $("#alertGenLocalidad").append("Para realizar esta accion, selecciona solo un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenLocalidad").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenLocalidad").toggleClass("animated");
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
            $("#alertGenLocalidad").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenLocalidad").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenLocalidad").toggleClass("animated");
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

    // Agregar Ciudad
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

    // Eventos de checkboxes
    checkboxes("#checkAll-Ciudad",".checkboxCiudad");

    // Animacion al hacer click en editar
    $("#btnEditarCiudad").on('click', function(){
        // Evaluamos si solo hay un checkbox seleccionado
        if( evaluarEditar("#checkAll-Ciudad",".checkboxCiudad") ){
            $("#alertGenLocalidad").append("Para realizar esta accion, selecciona solo un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenLocalidad").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenLocalidad").toggleClass("animated");
                },500);
            },2000);
        }else{
            let id = $(".checkboxCiudad:checked").attr("data-idRow");
            let nombre = $("#datos-ciudad-nombre"+id).text();
            $("#editNombreCiudad").val(nombre);
            $("#id-edit-ciudad").val(id);
            $("#modalEditarCiudad").modal("show");
            limpiarFormulario("#modalEditarCiudad","#editCiudad");
        }
    });

    // Editar ciudad
    $("#editCiudad").submit(function(e){
        e.preventDefault();
        let datos = $(this).serialize();

        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: datos,
            dataType: "json",
            success: function(data,status,jqXHR){
                if(data.status == 1){
                    setTimeout(function(){
                        $("#modalEditarCiudad").modal("hide");
                        limpiarFormulario("#modalEditarCiudad","#editCiudad");
                        $("#temporal").remove();
                        window.location.href = "localidades.php";
                    },1000);
                }else{
                    let mensaje = `<div id='alertEditCiudadError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-editCiudad").append(mensaje);
                    $("#alertEditCiudadError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertEditCiudadError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertEditCiudadError").remove();
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


    // Evaluar Chkbxs Borrar Ciudad
    $("#btnEliminarCiudad").on('click', function(){
        if( evaluarDel("#checkAll-Ciudad",".checkboxCiudad") ){
            $("#alertGenLocalidad").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenLocalidad").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenLocalidad").toggleClass("animated");
                },500);
            },2000);
        }else{
            $("#modalDelCiudad").modal("show");
        }
    });

    // Boton OK de confirmacion
    $("#confirmarCiudad").on('click', function(){
        let ids = $.map($(".checkboxCiudad:checked"), (x) => $(x).attr('data-idRow') );
        $.ajax({
            url: "./actions/delCiudad.php",
            method: "POST",
            data: {ids: ids},
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == 1){
                    data.arr.forEach((item) => $("#row-ciudad"+item).remove() );
                    $("#modalDelCiudad").modal('hide');
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




// Agregar Categoria
$("#addCategoria").submit(function(e){
    e.preventDefault();

    let info = $(this).serialize();

    $.ajax({
        url: $(this).attr("action"),
        method: "POST",
        data: info,
        dataType: "json",
        success: function(data, status, jqXHR){
            if(data.status == "1"){
                $("#modalAgregarCategoria").modal("hide");
                limpiarFormulario("#modalAgregarCategoria", "#addCategoria");
                let newRow = `<tr id='row-Categoria${data.id}'>
                <td><input style='display: none;' class='inp-cbx checkboxCategoria' type='checkbox' data-idRow='${data.id}' name='check-Categoria${data.id}' id='check-Categoria${data.id}'>
                                <label class='cbx' for='check-Categoria${data.id}'>
                                    <span>
                                        <svg width='12px' height='10px' viewbox='0 0 12 10'>
                                            <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                </label></td> <td>${data.id}</td> <td id='datos-nombre-Categoria-${data.id}'>${data.nombre}</td></tr>`
                $("#table-body-Categoria").append(newRow);
            }else{
                let mensaje = `<div id='alertAddCategoriaError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                $("#modal-body-Categoria").append(mensaje);
                $("#alertAddCategoriaError").toggleClass("fade");
                setTimeout(function(){
                    $("#alertAddCategoriaError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertAddCategoriaError").remove();
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
checkboxes("#checkAll-Categoria",".checkboxCategoria");
    // Eventos de checkboxes
    checkboxes("#checkAll-Categoria",".checkboxCategoria");

    // Evaluar editar Categoria
    $("#btnEditarCategoria").on('click', function(){
        if( evaluarEditar("#checkAll-Categoria",".checkboxCategoria") ){
            $("#alertGenCategoria").append("Para realizar esta accion, selecciona solo un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenCategoria").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenCategoria").toggleClass("animated");
                },500);
            },2000);
        }else{
            let id = $(".checkboxCategoria:checked").attr("data-idRow");
            let nombre = $("#datos-nombre-Categoria-"+id).text();
            $("#editNombreCategoria").val(nombre);
            $("#id-edit-Categoria").val(id);
            $("#modalEditarCategoria").modal("show");
            limpiarFormulario("#modalEditarCategoria","#editCategoria");
        }
    });

$("#editCategoria").submit(function(e){
    e.preventDefault();
    let datos = $(this).serialize();

    $.ajax({
        url: $(this).attr("action"),
        method: "POST",
        data: datos,
        dataType: "json",
        success: function(data,status,jqXHR){
            if(data.status == 1){
                setTimeout(function(){
                    $("#modalEditarCategoria").modal("hide");
                    limpiarFormulario("#modalEditarCategoria","#editCategoria");
                    $("#temporal").remove();
                    window.location.href = "categoria.php";
                },1000);
            }else{
                let mensaje = `<div id='alertEditCategoriaError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                $("#modal-body-editCategoria").append(mensaje);
                $("#alertEditCategoriaError").toggleClass("fade");
                setTimeout(function(){
                    $("#alertEditCategoriaError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertEditCategoriaError").remove();
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

// Evaluar Chkbxs Borrar categoria
$("#btnEliminarCategoria").on('click', function(){
    if( evaluarDel("#checkAll-Categoria",".checkboxCategoria") ){
        $("#alertGenCategoria").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
        setTimeout(function(){
            $("#alertGenCategoria").toggleClass("fadeInUp fadeOutDown").empty();
            setTimeout(function(){
                $("#alertGenCategoria").toggleClass("animated");
            },500);
        },2000);
    }else{
        $("#modalDelCategoria").modal("show");
    }
});
    // Editar Categoria
    $("#editCategoria").submit(function(e){
        e.preventDefault();
        let datos = $(this).serialize();

        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: datos,
            dataType: "json",
            success: function(data,status,jqXHR){
                if(data.status == 1){
                    setTimeout(function(){
                        $("#modalEditarCategoria").modal("hide");
                        limpiarFormulario("#modalEditarCategoria","#editCategoria");
                        $("#temporal").remove();
                        window.location.href = "categoria.php";
                    },1000);
                }else{
                    let mensaje = `<div id='alertEditCategoriaError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-editCategoria").append(mensaje);
                    $("#alertEditCategoriaError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertEditCategoriaError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertEditCategoriaError").remove();
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

    // Evaluar Chkbxs Borrar categoria
    $("#btnEliminarCategoria").on('click', function(){
        if( evaluarDel("#checkAll-Categoria",".checkboxCategoria") ){
            $("#alertGenCategoria").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenCategoria").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenCategoria").toggleClass("animated");
                },500);
            },2000);
        }else{
            $("#modalDelCategoria").modal("show");
        }
    });

    // Boton OK de confirmacion
    $("#confirmarCategoria").on('click', function(){
        let ids = $.map($(".checkboxCategoria:checked"), (x) => $(x).attr('data-idRow') );
        $.ajax({
            url: "./actions/delcategoria.php",
            method: "POST",
            data: {ids: ids},
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == 1){
                    data.arr.forEach((item) => $("#row-Categoria"+item).remove() );
                    $("#modalDelCategoria").modal('hide');
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


/////Sucursal

// Eventos de checkboxes
checkboxes("#checkAll-Sucursal",".checkboxSucursal");

// Evaluar editar Sucursal
$("#btnEditarSucursal").on('click', function(){
    if( evaluarEditar("#checkAll-Sucursal",".checkboxSucursal") ){
        $("#alertGenSucursal").append("Para realizar esta accion, selecciona solo un registro.").toggleClass("fadeInUp animated fadeOutDown");
        setTimeout(function(){
            $("#alertGenSucursal").toggleClass("fadeInUp fadeOutDown").empty();
            setTimeout(function(){
                $("#alertGenSucursal").toggleClass("animated");
            },500);
        },2000);
    }else{
        let id = $(".checkboxSucursal:checked").attr("data-idRow");
        let nombre = $("#datos-nombre-Sucursal-"+id).text();
        $("#editNombreSucursal").val(nombre);
        $("#id-edit-Sucursal").val(id);
        $("#modalEditarSucursal").modal("show");
        limpiarFormulario("#modalEditarSucursal","#editSucursal");
    }
});


$("#editSucursal").submit(function(e){
    e.preventDefault();
    let datos = $(this).serialize();

    $.ajax({
        url: $(this).attr("action"),
        method: "POST",
        data: datos,
        dataType: "json",
        success: function(data,status,jqXHR){
            if(data.status == 1){
                setTimeout(function(){
                    $("#modalEditarSucursal").modal("hide");
                    limpiarFormulario("#modalEditarSucursal","#editSucursal");
                    $("#temporal").remove();
                    window.location.href = "sucursales.php";
                },1000);
            }else{
                let mensaje = `<div id='alertEditSucursalError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                $("#modal-body-editSucursal").append(mensaje);
                $("#alertEditSucursalError").toggleClass("fade");
                setTimeout(function(){
                    $("#alertEditSucursalError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertEditSucursalError").remove();
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

// Evaluar Chkbxs Borrar Sucursal
$("#btnEliminarSucursal").on('click', function(){
    if( evaluarDel("#checkAll-Sucursal",".checkboxSucursal") ){
        $("#alertGenSucursal").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
        setTimeout(function(){
            $("#alertGenSucursal").toggleClass("fadeInUp fadeOutDown").empty();
            setTimeout(function(){
                $("#alertGenSucursal").toggleClass("animated");
            },500);
        },2000);
    }else{
        $("#modalDelSucursal").modal("show");
    }
});

// Boton OK de confirmacion
$("#confirmarSucursal").on('click', function(){
    let ids = $.map($(".checkboxSucursal:checked"), (x) => $(x).attr('data-idRow') );
    $.ajax({
        url: "./actions/delSucursales.php",
        method: "POST",
        data: {ids: ids},
        dataType: "json",
        success: function(data, status, jqXHR){
            if(data.status == 1){
                data.arr.forEach((item) => $("#row-Sucursal"+item).remove() );
                $("#modalDelSucursal").modal('hide');
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

// Eventos de checkboxes
checkboxes("#checkAll-Subcategoria",".checkboxSubcategoria");
// Evaluar editar Subcategoria
$("#btnEditarSubcategoria").on('click', function(){
    if( evaluarEditar("#checkAll-Subcategoria",".checkboxSubcategoria") ){
        $("#alertGenSubcategoria").append("Para realizar esta accion, selecciona solo un registro.").toggleClass("fadeInUp animated fadeOutDown");
        setTimeout(function(){
            $("#alertGenSubcategoria").toggleClass("fadeInUp fadeOutDown").empty();
            setTimeout(function(){
                $("#alertGenSubcategoria").toggleClass("animated");
            },500);
        },2000);
    }else{
        let id = $(".checkboxSubcategoria:checked").attr("data-idRow");
        let nombre = $("#datos-nombre-Subcategoria-"+id).text();
        $("#editNombreSubcategoria").val(nombre);
        $("#id-edit-Subcategoria").val(id);
        $("#modalEditarSubcategoria").modal("show");
        limpiarFormulario("#modalEditarSubcategoria","#editSubcategoria");
    }
});

$("#editSubcategoria").submit(function(e){
    e.preventDefault();
    let datos = $(this).serialize();

    $.ajax({
        url: $(this).attr("action"),
        method: "POST",
        data: datos,
        dataType: "json",
        success: function(data,status,jqXHR){
            if(data.status == 1){
                setTimeout(function(){
                    $("#modalEditarSubcategoria").modal("hide");
                    limpiarFormulario("#modalEditarSubcategoria","#editSubcategoria");
                    $("#temporal").remove();
                    window.location.href = "categoria.php";
                },1000);
            }else{
                let mensaje = `<div id='alertEditSubcategoriaError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                $("#modal-body-editSubcategoria").append(mensaje);
                $("#alertEditSubcategoriaError").toggleClass("fade");
                setTimeout(function(){
                    $("#alertEditSubcategoriaError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertEditSubcategoriaError").remove();
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

// Evaluar Chkbxs Borrar Subcategoria
    $("#btnEliminarSubcategoria").on('click', function(){
        if( evaluarDel("#checkAll-Subcategoria",".checkboxSubcategoria") ){
            $("#alertGenSubcategoria").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenSubcategoria").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenSubcategoria").toggleClass("animated");
                },500);
            },2000);
        }else{
            $("#modalDelSubcategoria").modal("show");
        }
    });

    // Boton OK de confirmacion
    $("#confirmarSubcategoria").on('click', function(){
        let ids = $.map($(".checkboxSubcategoria:checked"), (x) => $(x).attr('data-idRow') );
        $.ajax({
            url: "./actions/delSubcategoria.php",

            method: "POST",
            data: {ids: ids},
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == 1){

                    data.arr.forEach((item) => $("#row-Categoria"+item).remove() );
                    $("#modalDelCategoria").modal('hide');

                    data.arr.forEach((item) => $("#row-Subcategoria"+item).remove() );
                    $("#modalDelSubcategoria").modal('hide');

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

<<<<<<< HEAD
=======
    // Agregar Producto
    $("#addProducto").submit(function(e){
        e.preventDefault();

        let info = new FormData(this);

<<<<<<< HEAD
=======
        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: info,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function(data, status, jqXHR){
                if(data.status == "1"){
                    $("#modalAgregarProducto").modal("hide");
                    limpiarFormulario("#modalAgregarProducto", "#addProducto");
                    let newRow = `<tr id='row-producto${data.id}'>
                    <td><input style='display: none;' class='inp-cbx checkboxProducto' type='checkbox' data-idRow='${data.id}' name='check-Producto${data.id}' id='check-Producto${data.id}'>
                                    <label class='cbx' for='check-Producto${data.id}'>
                                        <span>
                                            <svg width='12px' height='10px' viewbox='0 0 12 10'>
                                                <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                            </svg>
                                        </span>
                                    </label></td> <td>${data.id}</td> <td id='datos-nombre-producto-${data.id}'>${data.nombre}</td> <td>${data.estado}</td> </tr>`
                    $("#table-body-producto").append(newRow);
                }else{
                    let mensaje = `<div id='alertAddProductoError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-producto").append(mensaje);
                    $("#alertAddProductoError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertAddProductoError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertAddProductoError").remove();
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
>>>>>>> origin/master
>>>>>>> 724bd08f546877e6e402534b3c52ce48dc91056b
});