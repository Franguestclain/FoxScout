<?php
    session_start();

    if(!isset($_SESSION['log']) && $_SESSION['log'] !== true ){
        header("location: ../index.php");
        exit;
    }else{
        /**
         * FIXME:
         * Los usuarios normales pueden ver este directorio
         */
        if($_SESSION['admin'] == false){
            header("location: ../index.php");
        }
    }

    include("../conexion.php");
    if($con -> connect_errno){
        echo "Hubo un error en la conexion";
    }else{
        include("header.php");
?>

    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

        <?php
            include("nav.php");

            include("aside.php");
        ?>

        <div class="modal fade" id="modalAgregarTienda" tabindex="-1" role="dialog" aria-labelledby="modalAgregarTiendaTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarTiendaTitulo">Agregar Tienda</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-tienda" class="modal-body">
                        <form id="addTienda" action="./actions/regTienda.php" method="POST" enctype="multipart/form-data"> <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="addNombre">Nombre</label>
                                <input type="text" name="addNombre" id="addNombre" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="addImage">Imagen</label>
                                <input type="file" accept="image/png, image/jpeg, image/jpg" name="addImage" id="addImage" class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="addTienda" id="registrarTienda" name="registrarTienda" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditarTienda" tabindex="-1" role="dialog" aria-labelledby="modalEditarTiendaTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarTiendaTitulo">Editar Tienda</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-editienda" class="modal-body">
                        <form id="editTienda" action="./actions/editTienda.php" method="POST" enctype="multipart/form-data"> <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="editNombre">Nombre</label>
                                <input type="text" name="editNombre" id="editNombre" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="editImage">Imagen</label>
                                <input type="file" accept="image/png, image/jpeg, image/jpg" name="editImage" id="editImage" class="form-control">
                            </div>
                            <input type="hidden" name="id" id="id-edit">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="editTienda" id="editarTienda" name="editarTienda" type="submit" class="btn btn-success" value="Hecho">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalDel" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Estas seguro de eliminar estos registros?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Estos datos se eliminaran de forma permanente.</p>
                </div>
                <div class="modal-footer">
                    <button id="confirmar" type="button" class="btn btn-primary">Ok</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div>

        <div class="page-wrapper">

            <div class="container-fluid">
                <div class="row">
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Tiendas</h4>
                                        <!-- <h5 class="card-subtitle">Overview of Top Selling Items</h5> -->
                                    </div>
                                    <div class="ml-auto">
                                        <button id="btnAgregarTienda" class="btn mb-2 btnAccion btn-success btnAgregar" data-toggle="modal" data-target="#modalAgregarTienda"><i class="fa fa-plus"></i> Agregar</button>
                                        <button id="btnEditarTienda" class="btn mb-2 btnAccion btn-primary btnEditar" data-toggle="modal" ><i class="fa fa-sync-alt"></i> Editar</button>
                                        <!-- <button id="btnHechoTienda" class="btn mb-2 btnAccion btn-success btnHecho"><i class="fa fa-check"></i> Hecho</!-->
                                        <button id="btnEliminarTienda" class="btn mb-2 btnAccion btn-danger btnEliminar"><i class="fa fa-trash"></i> Eliminar</button>
                                    </div>
                                </div>
                                <!-- title -->
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="border-top-0">
                                                <input style="display: none;" class="inp-cbx" type="checkbox" name="checkAll-Tienda" id="checkAll-Tienda">
                                                <label class="cbx" for="checkAll-Tienda">
                                                    <span>
                                                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                </label>
                                            </th>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nombre</th>
                                            <th class="border-top-0">Logo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body-tienda">
                                        <?php
                                            $listarTiendas = "SELECT * FROM tienda";
                                            // $ciudad = "SELECT nombre from ciudad"
                                            if($res = $con -> query($listarTiendas)){
                                                if($res -> num_rows > 0){
                                                    while($fila = $res -> fetch_assoc()) {
                                                        echo "<tr id='row-{$fila['id_tienda']}'>";
                                                            echo "<td>";
                                                                echo "<input style='display: none;' class='inp-cbx checkboxTienda' type='checkbox' data-idRow='{$fila['id_tienda']}' name='check-Tienda{$fila['id_tienda']}' id='check-Tienda{$fila['id_tienda']}'>";
                                                                echo "<label class='cbx' for='check-Tienda{$fila['id_tienda']}'>";
                                                                    echo "<span>";
                                                                        echo "<svg width='12px' height='10px' viewbox='0 0 12 10'>";
                                                                            echo "<polyline points='1.5 6 4.5 9 10.5 1'></polyline>";
                                                                        echo "</svg>";
                                                                    echo "</span>";
                                                                echo "</label>";
                                                            echo "</td>";
                                                            echo "<td>{$fila['id_tienda']}</td>";
                                                            echo "<td id='datos-{$fila['id_tienda']}' >{$fila['nombre']}</td>";
                                                            echo "<td><img id='img-tienda{$fila['id_tienda']}' class='img-tienda' src='{$fila['img']}' /></td>";
                                                        echo "</tr>";
                                                    }
                                                }else{
                                                    echo "<tr>";
                                                        echo "<td colspan='2'>";
                                                            echo "<div class='container text-center'>";
                                                                echo "<h5 class='display-5'> <i class='mdi mdi-cloud-outline-off'></i> </h5>";
                                                                echo "<h3>No existen elementos</h3>";
                                                            echo "</div>";
                                                        echo "</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="alertGen" class="alert bg-dark alertGen fadeOutDown"></div>
    </div>


<?php
    include("footer.php");
    }
?>