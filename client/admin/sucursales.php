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
        <div class="modal fade" id="modalAgregarSucursal" tabindex="-1" role="dialog" aria-labelledby="modalAgregarSucursalTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarSucursalTitulo">Agregar Sucursal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-sucursal" class="modal-body">
                        <form id="addSucursal" action="./actions/regSucursales.php" method="POST" > <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="addCalle">Calle</label>
                                <input type="text" name="addCalle" id="addCalle" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="addColonia">Colonia</label>
                                <input type="text" name="addColonia" id="addColonia" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="addNumero">Numero</label>
                                <input type="text" name="addNumero" id="addNumero" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="selectTienda">Tienda</label>
                                <select class="form-control" name="selectTienda" id="selectTienda">
                                    <?php
                                        $optionTienda = "SELECT * FROM tienda";
                                        if($resOptionE = $con -> query($optionTienda)){
                                            if( $resOptionE -> num_rows > 0 ){
                                                while($filaOptionE = $resOptionE -> fetch_assoc()){
                                                    echo "<option id='option-tienda-id{$filaOptionE['id_tienda']}' value='{$filaOptionE['id_tienda']}'>{$filaOptionE['nombre']}</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="selectCiudad">Ciudad</label>
                                <select class="form-control" name="selectCiudad" id="selectCiudad">
                                    <?php
                                        $optionCiudad = "SELECT * FROM ciudad";
                                        if($resOptionE = $con -> query($optionCiudad)){
                                            if( $resOptionE -> num_rows > 0 ){
                                                while($filaOptionE = $resOptionE -> fetch_assoc()){
                                                    echo "<option id='option-ciudad-id{$filaOptionE['id_ciudad']}' value='{$filaOptionE['id_ciudad']}'>{$filaOptionE['nombre']}</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label for="addImage">Imagen</label>
                                <input type="file" accept="image/png, image/jpeg, image/jpg" name="addImage" id="addImage" class="form-control">
                            </div> -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="addSucursal" id="registrarSucursal" name="registrarSucursal" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalEditarSucursal" tabindex="-1" role="dialog" aria-labelledby="modalAgregarSucursalTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarSucursalTitulo">Editar Sucursal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-editSucursal" class="modal-body">
                        <form id="editSucursal" action="./actions/editSucursales.php" method="POST" > <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="editCalle">Calle</label>
                                <input type="text" name="editCalle" id="editCalle" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="editColonia">Colonia</label>
                                <input type="text" name="editColonia" id="editColonia" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="editNumero">Numero</label>
                                <input type="text" name="editNumero" id="editNumero" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="editselectTienda">Tienda</label>
                                <select class="form-control" name="editselectTienda" id="editselectTienda">
                                    <?php
                                        $optionTienda = "SELECT * FROM tienda";
                                        if($resOptionE = $con -> query($optionTienda)){
                                            if( $resOptionE -> num_rows > 0 ){
                                                while($filaOptionE = $resOptionE -> fetch_assoc()){
                                                    echo "<option id='option-editTienda-{$filaOptionE['nombre']}' value='{$filaOptionE['id_tienda']}'>{$filaOptionE['nombre']}</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editselectCiudad">Ciudad</label>
                                <select class="form-control" name="editselectCiudad" id="editselectCiudad">
                                    <?php
                                        $optionCiudad = "SELECT * FROM ciudad";
                                        if($resOptionE = $con -> query($optionCiudad)){
                                            if( $resOptionE -> num_rows > 0 ){
                                                while($filaOptionE = $resOptionE -> fetch_assoc()){
                                                    echo "<option id='option-editCiudad-{$filaOptionE['nombre']}' value='{$filaOptionE['id_ciudad']}'>{$filaOptionE['nombre']}</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="id" id="id-edit-Sucursal" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="editSucursal" id="editSucursal" name="editSucursal" type="submit" class="btn btn-primary" value="Editar">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDelSucursal" tabindex="-1" role="dialog">
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
                    <button id="confirmarSucursal" type="button" class="btn btn-primary">Ok</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div>
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
                                        <h4 class="card-title">Sucursales</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-success btnAgregar" data-toggle="modal" data-target="#modalAgregarSucursal"><i class="fa fa-plus"></i> Agregar</button>
                                        <button id="btnEditarSucursal" class="btn btn-primary btnEditar"><i class="fa fa-sync-alt"></i> Editar</button>
                                        <button id="btnEliminarSucursal" class="btn btn-danger btnEliminar"><i class="fa fa-trash"></i> Eliminar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="border-top-0">
                                                <input style="display: none;" class="inp-cbx" type="checkbox" name="checkAll-Sucursal" id="checkAll-Sucursal">
                                                <label class="cbx" for="checkAll-Sucursal">
                                                    <span>
                                                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                </label>
                                            </th>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Calle</th>
                                            <th class="border-top-0">Colonia</th>
                                            <th class="border-top-0">Numero</th>
                                            <th class="border-top-0">Tienda</th>
                                            <th class="border-top-0">Ciudad</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body-sucursal">
                                        <?php
                                            $listar = "SELECT d.*, t.nombre nombreT, c.nombre nombreC FROM direccion d, tienda t, ciudad c WHERE tienda_id=id_tienda && ciudad_id=id_ciudad ORDER BY id_direccion";

                                            if( $res = $con -> query($listar) ){
                                                if( $res -> num_rows > 0 ){
                                                    while($fila = $res -> fetch_assoc() ){
                                                        echo "<tr id='row-Sucursal{$fila['id_direccion']}'>";
                                                            echo "<td>";
                                                                echo "<input style='display: none;' class='inp-cbx checkboxSucursal' type='checkbox' data-idRow='{$fila['id_direccion']}' name='check-Sucursal{$fila['id_direccion']}' id='check-Sucursal{$fila['id_direccion']}'>";
                                                                echo "<label class='cbx' for='check-Sucursal{$fila['id_direccion']}'>";
                                                                    echo "<span>";
                                                                        echo "<svg width='12px' height='10px' viewbox='0 0 12 10'>";
                                                                            echo "<polyline points='1.5 6 4.5 9 10.5 1'></polyline>";
                                                                        echo "</svg>";
                                                                    echo "</span>";
                                                                echo "</label>";
                                                            echo "</td>";
                                                            echo "<td>{$fila['id_direccion']}</td>";
                                                            echo "<td id='datos-calle-sucursal-{$fila['id_direccion']}'>{$fila['calle']}</td>";
                                                            echo "<td id='datos-colonia-sucursal-{$fila['id_direccion']}'>{$fila['colonia']}</td>";
                                                            echo "<td id='datos-numero-sucursal-{$fila['id_direccion']}'>{$fila['numero']}</td>";
                                                            echo "<td id='datos-tienda-sucursal-{$fila['id_direccion']}'>{$fila['nombreT']}</td>";
                                                            echo "<td id='datos-ciudad-sucursal-{$fila['id_direccion']}'>{$fila['nombreC']}</td>";
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
        <div id="alertGenSucursal" class="alert bg-dark alertGen fadeOutDown"></div>
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <?php
    include("footer.php");

    }
    ?>