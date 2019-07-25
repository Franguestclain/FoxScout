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
        <div class="modal fade" id="modalAgregarPxT" tabindex="-1" role="dialog" aria-labelledby="modalAgregarPxTTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarPxTTitulo">Agregar Precio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-PxT" class="modal-body">
                        <form id="addTienda" action="./actions/regPrecio.php" method="POST">
                            <div class="form-group">
                                <label for="addPrecio">Precio</label>
                                <input type="text" name="addPrecio" id="addPrecio" class="form-control">
                            </div>
                            <div class="form-row">
                                <div class="col form-group">
                                    <label for="addProducto">Producto</label>
                                        <select class="form-control" name="addProducto" id="addProducto">
                                            <option value="cd1">Chihuahua</option>
                                            <option value="cd2">Ciudad 2</option>
                                            <option value="cd3">Ciudad 3</option>
                                        </select>
                                </div>
                                <div class="col form-group">
                                <label for="addSucursal">Sucursal</label>
                                    <select class="form-control" name="addSucursal" id="addSucursal">
                                        <option value="cd1">Chihuahua</option>
                                        <option value="cd2">Ciudad 2</option>
                                        <option value="cd3">Ciudad 3</option>
                                    </select>
                                </div>  
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
                                        <h4 class="card-title">Precio por tienda</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-success btnAgregar" data-toggle="modal" data-target="#modalAgregarPxT"><i class="fa fa-plus"></i> Agregar</button>
                                        <button class="btn btn-primary btnEditar"><i class="fa fa-sync-alt"></i> Editar</button>
                                        <button class="btn btn-danger btnEliminar"><i class="fa fa-trash"></i> Eliminar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="border-top-0">
                                                <input style="display: none;" class="inp-cbx" type="checkbox" name="checkAll-Direccion" id="checkAll-Direccion">
                                                <label class="cbx" for="checkAll-Direccion">
                                                    <span>
                                                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                </label>
                                            </th>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Precio</th>
                                            <th class="border-top-0">Producto</th>
                                            <th class="border-top-0">Sucursal</th>
                                            <!--<th class="border-top-0">Tienda</th>
                                            <th class="border-top-0">Ciudad</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $listar = "SELECT * FROM direccion";

                                            if( $res = $con -> query($listar) ){
                                                if( $res -> num_rows > 0 ){
                                                    while($fila = $res -> fetch_assoc() ){
                                                        echo "<tr id='row-{$fila['id_direccion']}'>";
                                                            echo "<td>";
                                                                echo "<input style='display: none;' class='inp-cbx checkboxDireccion' type='checkbox' data-idRow='{$fila['id_direccion']}' name='check-Direccion{$fila['id_direccion']}' id='check-Direccion{$fila['id_direccion']}'>";
                                                                echo "<label class='cbx' for='check-Direccion{$fila['id_direccion']}'>";
                                                                    echo "<span>";
                                                                        echo "<svg width='12px' height='10px' viewbox='0 0 12 10'>";
                                                                            echo "<polyline points='1.5 6 4.5 9 10.5 1'></polyline>";
                                                                        echo "</svg>";
                                                                    echo "</span>";
                                                                echo "</label>";
                                                            echo "</td>";
                                                            echo "<td>{$fila['id_direccion']}</td>";
                                                            echo "<td>{$fila['calle']}</td>";
                                                            echo "<td>{$fila['colonia']}</td>";
                                                            echo "<td>{$fila['numero']}</td>";
                                                            echo "<td>{$fila['nombreT']}</td>";
                                                            echo "<td>{$fila['nombreC']}</td>";
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
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <?php
    include("footer.php");

    }
    ?>