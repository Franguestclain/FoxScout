$(document).ready(function(){

    function limpiarFormulario(modal,formulario){
        $(modal).on('hidden.bs.modal', function(e){
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

    const quitarNoExiste = () => ($(".no_existe")) ? $(".no_existe").remove() : console.log("no existe el inexistente");

    const evaluarEditar = (checkAll, checkboxes) =>
                ( $(checkAll).checked || $(checkboxes+":checked").length > 1 || $(checkboxes+":checked").length == 0 ) ?  true : false;

    const evaluarDel = (checkAll,checkboxes) => ( $(checkboxes+":checked").length == 0 || $(checkAll).checked === false ) ? true : false;

    const reiniciarSelect = (select) => $(`#${select}`).empty(); 

    const mostrarSucursal = () => {
        $("#addTienda").on('change', function(e){
            reiniciarSelect("addSucursalPxT");
            let id = $(this).val();
            $.ajax({
                url: "./actions/getSucursal.php",
                type: "GET",
                data: {id:id},
                dataType: 'json',
                success: function(data, status, jqXHR){
                    if( data.status == 1){
                        data.registros.forEach((reg)=> {
                            $("#addSucursalPxT").append(`<option value='${reg.id_direccion}'>${reg.calle} ${reg.colonia} ${reg.numero}</option>`);
                        });
                    }else{
                        $("#addSucursalPxT").append(`<option>${data.mensaje}</option>`);
                    }
                },
                error: function(data,status,error){
                    console.log("error");
                    console.log(data);
                    console.log(status);
                    console.log(error);
                }
            });
        });
    }

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
                    quitarNoExiste();
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
                    quitarNoExiste();
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
                    quitarNoExiste();
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
                    quitarNoExiste();
                }else{
                    let mensaje = `<div id='alertAddCategoriaError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-categoria").append(mensaje);
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

    //Editar categoria
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

    // Agregar Sucursal
    $("#addSucursal").submit(function(e){
        e.preventDefault();

        let info = $(this).serialize();
        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: info,
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == "1"){
                    $("#modalAgregarSucursal").modal("hide");
                    limpiarFormulario("#modalAgregarSucursal", "#addSucursal");
                    let newRow = `<tr id='row-sucursal${data.id}'>
                    <td><input style='display: none;' class='inp-cbx checkboxSucursal' type='checkbox' data-idRow='${data.id}' name='check-Sucursal${data.id}' id='check-Sucursal${data.id}'>
                                    <label class='cbx' for='check-Sucursal${data.id}'>
                                        <span>
                                            <svg width='12px' height='10px' viewbox='0 0 12 10'>
                                                <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                            </svg>
                                        </span>
                                    </label></td>
                                    <td>${data.id}</td>
                                    <td id='datos-calle-sucursal-${data.id}'>${data.calle}</td>
                                    <td id='datos-colonia-sucursal-${data.id}'>${data.colonia}</td>
                                    <td id='datos-numero-sucursal-${data.id}'>${data.numero}</td>
                                    <td id='datos-tienda-sucursal-${data.id}'>${data.tienda}</td>
                                    <td id='datos-ciudad-sucursal-${data.id}'>${data.ciudad}</td></tr>`
                    $("#table-body-sucursal").append(newRow);
                    quitarNoExiste();
                }else{
                    let mensaje = `<div id='alertAddSucursalError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-sucursal").append(mensaje);
                    $("#alertAddSucursalError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertAddSucursalError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertAddSucursalError").remove();
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
            let calle = $("#datos-calle-sucursal-"+id).text();
            let colonia = $("#datos-colonia-sucursal-"+id).text();
            let numero = $("#datos-numero-sucursal-"+id).text();
            let tienda = $("#datos-tienda-sucursal-"+id).text();
            let ciudad = $("#datos-ciudad-sucursal-"+id).text();
            $("#editCalle").val(calle);
            $("#editColonia").val(colonia);
            $("#editNumero").val(numero);
            $(`#option-editTienda-${tienda}`).attr('selected', 'selected');
            $(`#option-editCiudad-${ciudad}`).attr('selected', 'selected');
            $("#id-edit-Sucursal").val(id);
            $("#modalEditarSucursal").modal("show");
            limpiarFormulario("#modalEditarSucursal","#editSucursal");
        }
    });

    // Editar sucursal
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

    // Agregar Subcategoria
    $("#addSubcategoria").submit(function(e){
        e.preventDefault();

        let info = $(this).serialize();
        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: info,
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == "1"){
                    $("#modalAgregarSubcategoria").modal("hide");
                    limpiarFormulario("#modalAgregarSubcategoria", "#addSubcategoria");
                    let newRow = `<tr id='row-subcategoria${data.id}'>
                    <td><input style='display: none;' class='inp-cbx checkboxSubcategoria' type='checkbox' data-idRow='${data.id}' name='check-Subcategoria${data.id}' id='check-Subcategoria${data.id}'>
                                    <label class='cbx' for='check-Subcategoria${data.id}'>
                                        <span>
                                            <svg width='12px' height='10px' viewbox='0 0 12 10'>
                                                <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                            </svg>
                                        </span>
                                    </label></td> <td>${data.id}</td> <td id='datos-nombre-subcategoria-${data.id}'>${data.nombre}</td> <td>${data.categoria}</td></tr>`
                    $("#table-body-subcategoria").append(newRow);
                    quitarNoExiste();
                }else{
                    let mensaje = `<div id='alertAddSubcategoriaError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-subcategoria").append(mensaje);
                    $("#alertAddSubcategoriaError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertAddSubcategoriaError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertAddSubcategoriaError").remove();
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
    checkboxes("#checkAll-Subcategoria",".checkboxSubcategoria");
    // Evaluar editar Subcategoria
    $("#btnEditarSubcategoria").on('click', function(){
        if( evaluarEditar("#checkAll-Subcategoria",".checkboxSubcategoria") ){
            $("#alertGenCategoria").append("Para realizar esta accion, selecciona solo un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenCategoria").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenCategoria").toggleClass("animated");
                },500);
            },2000);
        }else{
            let id = $(".checkboxSubcategoria:checked").attr("data-idRow");
            let nombreSub = $("#datos-nombre-subcat-"+id).text();
            let nombreCat = $("#datos-nombre-sCat-"+id).text();
            $("#editNombreSubcategoria").val(nombreSub);
            $(`#option-selectCat-${nombreCat}`).attr('selected','selected');
            $("#id-edit-Subcategoria").val(id);
            $("#modalEditarSubcategoria").modal("show");
            limpiarFormulario("#modalEditarSubcategoria","#editSubcategoria");
        }
    });

    // Editar subcategoria
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


    // Agregar Producto
    $("#addProducto").submit(function(e){
        e.preventDefault();

        let info = new FormData(this);
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
                                    </label></td> <td>${data.id}</td> <td id='datos-nombre-producto-${data.id}'>${data.nombre}</td> <td>${data.desc}</td><td>${data.categorias}</td><td>${data.rutaImg}</td> </tr>`
                    $("#table-body-producto").append(newRow);
                    quitarNoExiste();
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


    // Evaluar checkboxes de editar producto
    checkboxes("#checkAll-Producto",".checkboxProducto");
    // Evaluar editar Producto
    $("#btnEditarProducto").on('click', function(){
        if( evaluarEditar("#checkAll-Producto",".checkboxProducto") ){
            $("#alertGenProducto").append("Para realizar esta accion, selecciona solo un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenProducto").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenProducto").toggleClass("animated");
                },500);
            },2000);
        }else{
            let id = $(".checkboxProducto:checked").attr("data-idRow");
            let nombre = $("#datos-nombre-producto-"+id).text();
            let desc = $("#datos-desc-producto-"+id).text();
            let subcat = $("#datos-subcat-producto-"+id).text();
            $("#editNombreProd").val(nombre);
            $(`#option-editSubcat-${subcat}`).attr('selected', 'selected');
            $("#editDescripcion").val(desc);
            $("#id-edit-producto").val(id);
            $("#modalEditarProducto").modal("show");
            limpiarFormulario("#modalEditarProducto","#editProducto");
        }
    });

    // Editar producto
    $("#editProducto").submit(function(e){
        e.preventDefault();
        let datos = new FormData(this);

        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: datos,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function(data,status,jqXHR){
                if(data.status == 1){
                    setTimeout(function(){
                        $("#modalEditarProducto").modal("hide");
                        limpiarFormulario("#modalEditarProducto","#editProducto");
                        $("#temporal").remove();
                        window.location.href = "productos.php";
                    },1000);
                }else{
                    let mensaje = `<div id='alertEditProductoError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-editProducto").append(mensaje);
                    $("#alertEditProductoError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertEditProductoError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertEditProductoError").remove();
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
    $("#btnEliminarProducto").on('click', function(){
        if( evaluarDel("#checkAll-Producto",".checkboxProducto") ){
            $("#alertGenProducto").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenProducto").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenProducto").toggleClass("animated");
                },500);
            },2000);
        }else{
            $("#modalDelProducto").modal("show");
        }
    });

    // Boton OK de confirmacion
    $("#confirmarProducto").on('click', function(){
        let ids = $.map($(".checkboxProducto:checked"), (x) => $(x).attr('data-idRow') );
        $.ajax({
            url: "./actions/delProducto.php",
            method: "POST",
            data: {ids: ids},
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == 1){
                    data.arr.forEach((item) => $("#row-producto"+item).remove() );
                    $("#modalDelProducto").modal('hide');
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

    // Llamamos a la funcion mostrar sucursal
    $("#modalAgregarPxT").on('show.bs.modal', mostrarSucursal());
        
    // Agregar precioxTienda
    $("#addPxt").submit(function(e){
        e.preventDefault();

        let info = $(this).serialize();
        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: info,
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == "1"){
                    $("#modalAgregarPxT").modal("hide");
                    limpiarFormulario("#modalAgregarPxT", "#addPxt");
                    let newRow = `<tr id='row-Precio${data.id}'>
                    <td><input style='display: none;' class='inp-cbx checkboxPrecio' type='checkbox' data-idRow='${data.id}' name='check-Precio${data.id}' id='check-Precio${data.id}'>
                                    <label class='cbx' for='check-Precio${data.id}'>
                                        <span>
                                            <svg width='12px' height='10px' viewbox='0 0 12 10'>
                                                <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                            </svg>
                                        </span>
                                    </label></td> <td>${data.id}</td> <td id='datos-Precio-${data.id}'>${data.precio}</td> <td>${data.producto}</td> <td>${data.sucursal}</td></tr>`
                    $("#table-body-Precio").append(newRow);
                    quitarNoExiste();
                }else{
                    let mensaje = `<div id='alertAddPrecioError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-Precio").append(mensaje);
                    $("#alertAddPrecioError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertAddPrecioError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertAddPrecioError").remove();
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
    checkboxes("#checkAll-Precio",".checkboxPrecio");
    // Evaluar editar precioxTienda

    $("#btnEditarPrecio").on('click', function(){
        if( evaluarEditar("#checkAll-Precio",".checkboxPrecio") ){
            $("#alertGenPrecio").append("Para realizar esta accion, selecciona solo un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenPrecio").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenPrecio").toggleClass("animated");
                },500);
            },2000);
        }else{
            let id = $(".checkboxPrecio:checked").attr("data-idRow");
            let precio = $("#datos-precio-"+id).text();
            let producto = $("#datos-producto-"+id).text();
            let direccion = $("#datos-direccion-"+id).text();
            $("#editPrecio").val(precio);
            $("#id-edit-Precio").val(id);
            $(`#option-Sucursal-id${id}`).attr('selected','selected');
            $("#modalEditarPxT").modal("show");
            limpiarFormulario("#modalEditarPxT","#editPxt");
        }
    });
    // Editar precioxTienda

    $("#editPxt").submit(function(e){
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
                        $("#modalEditarPrecio").modal("hide");
                        limpiarFormulario("#modalEditarPrecio","#editPrecio");
                        $("#temporal").remove();
                        window.location.href = "precioxtienda.php";
                    },1000);
                }else{
                    let mensaje = `<div id='alertEditPrecioError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                    $("#modal-body-editPrecio").append(mensaje);
                    $("#alertEditPrecioError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertEditPrecioError").toggleClass("fade");
                        setTimeout(function(){
                            $("#alertEditPrecioError").remove();
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

    // Evaluar Chkbxs Borrar PrecioxTienda
    $("#btnEliminarPrecio").on('click', function(){
        if( evaluarDel("#checkAll-Precio",".checkboxPrecio") ){
            $("#alertGenPrecio").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenPrecio").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenPrecio").toggleClass("animated");
                },500);
            },2000);
        }else{
            $("#modalDelPrecio").modal("show");
        }
    });

    // Boton OK de confirmacion
    $("#confirmarPrecio").on('click', function(){
        let ids = $.map($(".checkboxPrecio:checked"), (x) => $(x).attr('data-idRow') );
        $.ajax({
            url: "./actions/delPrecio.php",
            method: "POST",
            data: {ids: ids},
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == 1){
                    data.arr.forEach((item) => $("#row-Precio"+item).remove() );
                    $("#modalDelPrecio").modal('hide');
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




    // Admin Usuario
    checkboxes("#checkAll-Usuario",".checkboxUsuario");
    $("#btnAdmin").on('click', function(){
        if( evaluarDel("#checkAll-Usuario",".checkboxUsuario") ){
            $("#alertGenUsuarios").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenUsuarios").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenUsuarios").toggleClass("animated");
                },500);
            },2000);
        }else{
            // Ajax
            let ids = $.map($(".checkboxUsuario:checked"), (x) => $(x).attr('data-idRow') );
            console.log(ids);
            $.ajax({
                url: "./actions/regUsuario.php",
                method: "POST",
                data: {ids:ids},
                dataType: "json",
                success: function(data, status, jqXHR){
                    if(data.status == 1){
                        // Aqui pasa algo en el front-end
                        window.location.href = "index.php";
                    }else{
                        console.log(data.mensaje);
                    }
                },
                error: function(data,status, error){
                    console.log(data);
                    console.log(status);
                    console.log(error);
                }
            })
        }
    });


    // Evaluar Chkbxs Borrar Subcategoria
    $("#btnEliminarUsuario").on('click', function(){
        if( evaluarDel("#checkAll-Usuario",".checkboxUsuario") ){
            $("#alertGenUsuarios").append("Para realizar esta accion, selecciona al menos un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenUsuarios").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenUsuarios").toggleClass("animated");
                },500);
            },2000);
        }else{
            $("#modalDelUsuario").modal("show");
        }
    });

    // Boton OK de confirmacion
    $("#confirmarUsuario").on('click', function(){
        let ids = $.map($(".checkboxUsuario:checked"), (x) => $(x).attr('data-idRow') );
        $.ajax({
            url: "./actions/delUsuario.php",
            method: "POST",
            data: {ids: ids},
            dataType: "json",
            success: function(data, status, jqXHR){
                if(data.status == 1){
                    data.arr.forEach((item) => $("#row-usuario"+item).remove() );
                    $("#modalDelUsuario").modal('hide');
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




    // Evaluar editar usuario

    $("#btnEditarUsuario").on('click', function(){
        if( evaluarEditar("#checkAll-Usuario",".checkboxUsuario") ){
            $("#alertGenUsuario").append("Para realizar esta accion, selecciona solo un registro.").toggleClass("fadeInUp animated fadeOutDown");
            setTimeout(function(){
                $("#alertGenUsuario").toggleClass("fadeInUp fadeOutDown").empty();
                setTimeout(function(){
                    $("#alertGenUsuario").toggleClass("animated");
                },500);
            },2000);
        }else{
            let id = $(".checkboxUsuario:checked").attr("data-idRow");
            let nombre = $("#datos-nombre-"+id).text();
            let apellidop = $("#datos-ap-"+id).text();
            let apellidom = $("#datos-am-"+id).text();
            let email = $("#datos-email-"+id).text();
            // let ciudad = $("#datos-ciudad-"+id).text();
            $("#editNombre").val(nombre);
            $("#editApellidoP").val(apellidop);
            $("#editApellidoM").val(apellidom);
            $("#editEmail").val(email);
            // $("#id-edit-nombre").val(id);
            // $(`#option-Sucursal-id${id}`).attr('selected','selected');
            $("#modalEditarU").modal("show");
            limpiarFormulario("#modalEditarU","#editUser");
        }
    });
// Editar usuario

$("#editUser").submit(function(e){
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
                    $("#modalEditarUsuario").modal("hide");
                    limpiarFormulario("#modalEditarUsuario","#editUsuario");
                    $("#temporal").remove();
                    window.location.href = "index.php";
                },1000);
            }else{
                let mensaje = `<div id='alertEditUsuarioError' class='alert alert-danger fade'>${data.mensaje}</div>`;
                $("#modal-body-editUsuario").append(mensaje);
                $("#alertEditUsuarioError").toggleClass("fade");
                setTimeout(function(){
                    $("#alertEditUsuarioError").toggleClass("fade");
                    setTimeout(function(){
                        $("#alertEditUsuarioError").remove();
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