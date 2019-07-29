<?php
    session_start();

    if(!isset($_SESSION['log']) && $_SESSION['log'] !== true ){
        header("location: ../index.php");
        exit;
    }else{

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
                        <form id="addPxt" action="./actions/regPrecio.php" method="POST">
                            <div class="form-group">
                                <label for="addPrecio">Precio</label>
                                <input type="text" name="addPrecio" id="addPrecio" class="form-control">
                            </div>
                            <div class="form-row">
                                <div class="col form-group">
                                    <label for="addProducto">Producto</label>
                                    <select class="form-control" name="addProducto" id="addProducto">
                                        <?php
                                        $optionProducto = "SELECT * FROM producto";
                                        if($resOptionP = $con -> query($optionProducto)){
                                            if( $resOptionP -> num_rows > 0 ){
                                                while($filaOptionP = $resOptionP -> fetch_assoc()){
                                                    echo "<option id='option-producto-id{$filaOptionP['id_prod']}' value='{$filaOptionP['id_prod']}'>{$filaOptionP['nombre']}</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col form-group">
                                    <label for="addTienda">Tienda</label>
                                    <select class="form-control" name="addTienda" id="addTienda">
                                        <option>Selecciona una tienda</option>
                                        <?php
                                            $optionTienda = "SELECT * FROM tienda";
                                            if($resOptionT = $con -> query($optionTienda)){
                                            if( $resOptionT -> num_rows > 0 ){
                                            while($filaOptionT = $resOptionT -> fetch_assoc()){
                                                echo "<option id='option-Tienda-id{$filaOptionT['id_tienda']}' value='{$filaOptionT['id_tienda']}'>{$filaOptionT['nombre']}</option>";
                                                }
                                            }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="addSucursalPxT">Sucursal</label>
                                <select class="form-control" name="addSucursalPxT" id="addSucursalPxT">
                                    <option>Sucursales</option>
                                </select>
                            </div>                             
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="addPxt" id="submit" name="submit" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div>

        <!-- Aqui comienza el modal de edit -->
        <div class="modal fade" id="modalEditarPxT" tabindex="-1" role="dialog" aria-labelledby="modalEditarPxTTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarPxTTitulo">Editar Precio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-PxT" class="modal-body">
                        <form id="editPxt" action="./actions/editPrecio.php" method="POST">
                            <div class="form-group">
                                <label for="editPrecio">Precio</label>
                                <input type="text" name="editPrecio" id="editPrecio" class="form-control">
                            </div>
                            <div class="form-row">
                                <div class="col form-group">
                                    <label for="editProducto">Producto</label>
                                    <select class="form-control" name="editProducto" id="editProducto">
                                        <?php
                                        $optionProducto = "SELECT * FROM producto";
                                        if($resOptionP = $con -> query($optionProducto)){
                                            if( $resOptionP -> num_rows > 0 ){
                                                while($filaOptionP = $resOptionP -> fetch_assoc()){
                                                    echo "<option id='option-producto-id{$filaOptionP['id_prod']}' value='{$filaOptionP['id_prod']}'>{$filaOptionP['nombre']}</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col form-group">
                                    <label for="editTiendaPxT">Tienda</label>
                                    <select class="form-control" name="editTiendaPxT" id="editTiendaPxT">
                                        <?php
                                            $optionTienda = "SELECT * FROM tienda";
                                            if($resOptionT = $con -> query($optionTienda)){
                                                if( $resOptionT -> num_rows > 0 ){
                                                    while($filaOptionT = $resOptionT -> fetch_assoc()){
                                                        echo "<option id='option-tiendaPxt-id{$filaOptionT['id_tienda']}' value='{$filaOptionT['id_tienda']}'>{$filaOptionT['nombre']}</option>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label for="editSucursalPxT">Sucursal</label>
                                    <select class="form-control" name="editSucursalPxT" id="editSucursalPxT">
                                        
                                    </select>
                                </div>
                                <input type="hidden" id='id-edit-Precio' name="id" value="">                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="editPxt" id="submit" name="submit" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div> 
        <!-- Aqui acaba el modal de edit -->

        <div class="modal fade" id="modalDelPrecio" tabindex="-1" role="dialog">
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
                    <button id="confirmarPrecio" type="button" class="btn btn-primary">Ok</button>
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
                                        <h4 class="card-title">Precio por tienda</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-success btnAgregar" data-toggle="modal" data-target="#modalAgregarPxT"><i class="fa fa-plus"></i> Agregar</button>
                                        <button id="btnEditarPrecio" class="btn btn-primary btnEditar"><i class="fa fa-sync-alt"></i> Editar</button>
                                        <button id="btnEliminarPrecio" class="btn btn-danger btnEliminar"><i class="fa fa-trash"></i> Eliminar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="border-top-0">
                                                <input style="display: none;" class="inp-cbx" type="checkbox" name="checkAll-Precio" id="checkAll-Precio">
                                                <label class="cbx" for="checkAll-Precio">
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
                                    <tbody id="table-body-Precio">
                                        <?php
                                            $listar = "SELECT * FROM precioxtienda";

                                            if( $res = $con -> query($listar) ){
                                                if( $res -> num_rows > 0 ){
                                                    while($fila = $res -> fetch_assoc() ){
                                                        echo "<tr id='row-Precio{$fila['id_PxTienda']}'>";
                                                            echo "<td>";
                                                                echo "<input style='display: none;' class='inp-cbx checkboxPrecio' type='checkbox' data-idRow='{$fila['id_PxTienda']}' name='check-Precio{$fila['id_PxTienda']}' id='check-Precio{$fila['id_PxTienda']}'>";
                                                                echo "<label class='cbx' for='check-Precio{$fila['id_PxTienda']}'>";
                                                                    echo "<span>";
                                                                        echo "<svg width='12px' height='10px' viewbox='0 0 12 10'>";
                                                                            echo "<polyline points='1.5 6 4.5 9 10.5 1'></polyline>";
                                                                        echo "</svg>";
                                                                    echo "</span>";
                                                                echo "</label>";
                                                            echo "</td>";
                                                            echo "<td>{$fila['id_PxTienda']}</td>";
                                                            echo "<td id='datos-precio-{$fila['id_PxTienda']}'>{$fila['precio']}</td>";
                                                            echo "<td id='datos-producto-{$fila['id_PxTienda']}' data-idprod='{$fila['prod_id']}'>{$fila['prod_id']}</td>";
                                                            echo "<td id='datos-direccion-{$fila['id_PxTienda']}' data-iddir='{$fila['direccion_id']}'>{$fila['direccion_id']}</td>";
                                                            //echo "<td>{$fila['nombreT']}</td>";
                                                            //echo "<td>{$fila['nombreC']}</td>";
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
        <div id="alertGenPrecio" class="alert bg-dark alertGen fadeOutDown"></div>
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <?php
    include("footer.php");

    }
    ?>