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
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php 
            include("nav.php");
            include("aside.php");
        ?>
        <!-- Agregar estado -->
        <div class="modal fade" id="modalAgregarEstado" tabindex="-1" role="dialog" aria-labelledby="modalAgregarEstadoTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarEstadoTitulo">Agregar Estado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-estado" class="modal-body">
                        <form id="addEstado" action="./actions/regEstado.php" method="POST"> <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="addNombreEstado">Nombre</label>
                                <input type="text" name="addNombreEstado" id="addNombreEstado" class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="addEstado" id="registrarEstado" name="registrarEstado" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div> <!-- Fin agregar estado -->

        <!-- Agregar ciudad -->
        <div class="modal fade" id="modalAgregarCiudad" tabindex="-1" role="dialog" aria-labelledby="modalAgregarCiudadTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarCiudadTitulo">Agregar Ciudad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-ciudad" class="modal-body">
                        <form id="addCiudad" action="./actions/regCiudad.php" method="POST"> <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="addNombreCiudad">Nombre</label>
                                <input type="text" name="addNombreCiudad" id="addNombreCiudad" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="selectEstado">Estado</label>
                                <select class="form-control" name="selectEstado" id="selectEstado">
                                    <?php
                                        $optionEstado = "SELECT * FROM estado";
                                        if($resOptionE = $con -> query($optionEstado)){
                                            if( $resOptionE -> num_rows > 0 ){
                                                while($filaOptionE = $resOptionE -> fetch_assoc()){
                                                    echo "<option id='option-estado-id{$filaOptionE['id_estado']}' value='{$filaOptionE['id_estado']}'>{$filaOptionE['nombre']}</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="addCiudad" id="registrarCiudad" name="registrarCiudad" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div> <!-- Fin agregar ciudad -->


        <!-- Modal edit Estado -->
        <div class="modal fade" id="modalEditarEstado" tabindex="-1" role="dialog" aria-labelledby="modalEditarEstadoTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarEstadoTitulo">Editar Estado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-editEstado" class="modal-body">
                        <form id="editEstado" action="./actions/editEstado.php" method="POST"> <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="editNombreEstado">Nombre</label>
                                <input type="text" name="editNombreEstado" id="editNombreEstado" class="form-control">
                            </div>
                            <input type="hidden" name="id" id="id-edit-estado" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="editEstado" id="editarEstado" name="editarEstado" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div> <!-- Fin modal edit Estado -->
        
        <!-- Modal edit Ciudad -->
        <div class="modal fade" id="modalEditarCiudad" tabindex="-1" role="dialog" aria-labelledby="modalEditarCiudadTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarCiudadTitulo">Editar Ciudad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-editCiudad" class="modal-body">
                        <form id="editCiudad" action="./actions/editCiudad.php" method="POST"> <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="editNombreCiudad">Nombre</label>
                                <input type="text" name="editNombreCiudad" id="editNombreCiudad" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="selectEditEstado">Estado</label>
                                <select class="form-control" name="selectEditEstado" id="selectEditEstado">
                                    <?php
                                        $optionEstado = "SELECT * FROM estado";
                                        if($resOptionE = $con -> query($optionEstado)){
                                            if( $resOptionE -> num_rows > 0 ){
                                                while($filaOptionE = $resOptionE -> fetch_assoc()){
                                                    echo "<option id='option-editEstado-id{$filaOptionE['id_estado']}' value='{$filaOptionE['id_estado']}'>{$filaOptionE['nombre']}</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="id" id="id-edit-ciudad" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="editCiudad" id="editarCiudad" name="editarCiudad" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div> <!-- Fin modal edit Ciudad -->


        <!-- Modal Delete Estado -->
        <div class="modal fade" id="modalDelEstado" tabindex="-1" role="dialog">
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
                    <button id="confirmarEstado" type="button" class="btn btn-primary">Ok</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div> <!-- Fin modal Delete Estado -->
        
        <!-- Modal Delete Estado -->
        <div class="modal fade" id="modalDelCiudad" tabindex="-1" role="dialog">
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
                    <button id="confirmarCiudad" type="button" class="btn btn-primary">Ok</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div> <!-- Fin modal Delete Estado -->

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Estados</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-success btnAgregar" data-toggle="modal" data-target="#modalAgregarEstado"><i class="fa fa-plus"></i> Agregar</button>
                                        <button id="btnEditarEstado" class="btn btn-primary btnEditar"><i class="fa fa-sync-alt"></i> Editar</button>
                                        <button id="btnEliminarEstado" class="btn btn-danger btnEliminar"><i class="fa fa-trash"></i> Eliminar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="border-top-0">
                                                <input style="display: none;" class="inp-cbx" type="checkbox" name="checkAll-Estado" id="checkAll-Estado">
                                                <label class="cbx" for="checkAll-Estado">
                                                    <span>
                                                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                </label>
                                            </th>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body-estado">
                                        <?php
                                            $listar = "SELECT * FROM estado";

                                            if( $res = $con -> query($listar) ){
                                                if( $res -> num_rows > 0 ){
                                                    while($fila = $res -> fetch_assoc() ){
                                                        echo "<tr id='row-estado{$fila['id_estado']}'>";
                                                            echo "<td>";
                                                                echo "<input style='display: none;' class='inp-cbx checkboxEstado' type='checkbox' data-idRow='{$fila['id_estado']}' name='check-Estado{$fila['id_estado']}' id='check-Estado{$fila['id_estado']}'>";
                                                                echo "<label class='cbx' for='check-Estado{$fila['id_estado']}'>";
                                                                    echo "<span>";
                                                                        echo "<svg width='12px' height='10px' viewbox='0 0 12 10'>";
                                                                            echo "<polyline points='1.5 6 4.5 9 10.5 1'></polyline>";
                                                                        echo "</svg>";
                                                                    echo "</span>";
                                                                echo "</label>";
                                                            echo "</td>";
                                                            echo "<td>{$fila['id_estado']}</td>";
                                                            echo "<td id='datos-nombre-estado-{$fila['id_estado']}'>{$fila['nombre']}</td>";
                                                        echo "</tr>";
                                                    }
                                                }else{
                                                    echo "<tr>";
                                                        echo "<td colspan='7'>";
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ciudades -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Ciudades</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-success btnAgregar" data-toggle="modal" data-target="#modalAgregarCiudad"><i class="fa fa-plus"></i> Agregar</button>
                                        <button id="btnEditarCiudad" class="btn btn-primary btnEditar"><i class="fa fa-sync-alt"></i> Editar</button>
                                        <button id="btnEliminarCiudad" class="btn btn-danger btnEliminar"><i class="fa fa-trash"></i> Eliminar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="border-top-0">
                                                <input style="display: none;" class="inp-cbx" type="checkbox" name="checkAll-Ciudad" id="checkAll-Ciudad">
                                                <label class="cbx" for="checkAll-Ciudad">
                                                    <span>
                                                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                </label>
                                            </th>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nombre</th>
                                            <th class="border-top-0">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body-ciudad">
                                        <?php
                                            $listarCiudad = "SELECT c.*, e.nombre nombreE FROM ciudad c, estado e WHERE c.estado_id = e.id_estado";

                                            if( $res = $con -> query($listarCiudad) ){
                                                if( $res -> num_rows > 0 ){
                                                    while($fila = $res -> fetch_assoc() ){
                                                        echo "<tr id='row-ciudad{$fila['id_ciudad']}'>";
                                                            echo "<td>";
                                                                echo "<input style='display: none;' class='inp-cbx checkboxCiudad' type='checkbox' data-idRow='{$fila['id_ciudad']}' name='check-Direccion{$fila['id_ciudad']}' id='check-Ciudad{$fila['id_ciudad']}'>";
                                                                echo "<label class='cbx' for='check-Ciudad{$fila['id_ciudad']}'>";
                                                                    echo "<span>";
                                                                        echo "<svg width='12px' height='10px' viewbox='0 0 12 10'>";
                                                                            echo "<polyline points='1.5 6 4.5 9 10.5 1'></polyline>";
                                                                        echo "</svg>";
                                                                    echo "</span>";
                                                                echo "</label>";
                                                            echo "</td>";
                                                            echo "<td>{$fila['id_ciudad']}</td>";
                                                            echo "<td id='datos-ciudad-nombre{$fila['id_ciudad']}'>{$fila['nombre']}</td>";
                                                            echo "<td id='datos-ciudad-nombreE'>{$fila['nombreE']}</td>";
                                                        echo "</tr>";
                                                    }
                                                }else{
                                                    echo "<tr class='no_existe'>";
                                                        echo "<td colspan='7'>";
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <div id="alertGenLocalidad" class="alert bg-dark alertGen fadeOutDown"></div>
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <?php
    include("footer.php");

    }
    ?>