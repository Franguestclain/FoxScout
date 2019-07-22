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
                                        <button class="btn btn-success btnAgregar" data-toggle="modal" data-target=""><i class="fa fa-plus"></i> Agregar</button>
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
                                            <th class="border-top-0">Calle</th>
                                            <th class="border-top-0">Colonia</th>
                                            <th class="border-top-0">Numero</th>
                                            <th class="border-top-0">Tienda</th>
                                            <th class="border-top-0">Ciudad</th>
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