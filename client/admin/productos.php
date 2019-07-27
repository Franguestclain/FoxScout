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

        <div class="modal fade" id="modalAgregarProducto" tabindex="-1" role="dialog" aria-labelledby="modalAgregarProductoTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarProductoTitulo">Agregar Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-producto" class="modal-body">
                        <form id="addProducto" action="./actions/regProducto.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="addNombreProd">Nombre</label>
                                <input type="text" name="addNombreProd" id="addNombreProd" class="form-control">
                            </div>
                            <div class="form-row">
                                <div class="col form-group">
                                    <label for="selectSubCat">Subcategoria</label>
                                    <select class="form-control" name="selectSubCat" id="selectSubCat">
                                        <?php
                                            $listarSubcategorias = "SELECT * FROM subcategoria";
                                            if( $res = $con -> query($listarSubcategorias) ){
                                                if( $res -> num_rows > 0 ){
                                                    while( $fila = $res -> fetch_assoc() ){
                                                        echo "<option id='option-add-subcat-id{$fila['id_subcat']}' value='{$fila['id_subcat']}'>{$fila['nombre']}</option>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col form-group">
                                    <label for="codigoB">Codigo de barras</label>
                                    <input class="form-control" accept="image/png, image/jpeg, image/jpg" type="file" name="codigoB" id="codigoB">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="addProducto" id="registrarProducto" name="registrarProducto" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditarProducto" tabindex="-1" role="dialog" aria-labelledby="modalEditarProductoTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarProductoTitulo">Editar Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-editProducto" class="modal-body">
                        <form id="editProducto" action="./actions/editProducto.php" method="POST" enctype="multipart/form-data"> <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                        <div class="form-group">
                                <label for="editNombreProd">Nombre</label>
                                <input type="text" name="editNombreProd" id="editNombreProd" class="form-control">
                            </div>
                            <div class="form-row">
                                <div class="col form-group">
                                    <label for="selecteditSubCat">Subcategoria</label>
                                    <select class="form-control" name="selecteditSubCat" id="selecteditSubCat">
                                        <?php
                                            $listarSubcategorias = "SELECT * FROM subcategoria";
                                            if( $res = $con -> query($listarSubcategorias) ){
                                                if( $res -> num_rows > 0 ){
                                                    while( $fila = $res -> fetch_assoc() ){
                                                        echo "<option id='option-editSubcat-{$fila['nombre']}' value='{$fila['id_subcat']}'>{$fila['nombre']}</option>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col form-group">
                                    <label for="editCodigoB">Codigo de barras</label>
                                    <input class="form-control" accept="image/png, image/jpeg, image/jpg" type="file" name="editCodigoB" id="editCodigoB">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="editDescripcion">Descripcion</label>
                                <textarea class="form-control" name="editDescripcion" id="editDescripcion" cols="30" rows="10"></textarea>
                            </div>
                            <input type="hidden" name="id" id="id-edit-producto">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="editProducto" id="editarProducto" name="editarProducto" type="submit" class="btn btn-success" value="Hecho">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalDelProducto" tabindex="-1" role="dialog">
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
                    <button id="confirmarProducto" type="button" class="btn btn-primary">Ok</button>
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
                                        <h4 class="card-title">Productos</h4>
                                        <!-- <h5 class="card-subtitle">Overview of Top Selling Items</h5> -->
                                    </div>
                                    <div class="ml-auto">
                                        <button id="btnAgregarProducto" class="btn mb-2 btnAccion btn-success btnAgregar" data-toggle="modal" data-target="#modalAgregarProducto"><i class="fa fa-plus"></i> Agregar</button>
                                        <button id="btnEditarProducto" class="btn mb-2 btnAccion btn-primary btnEditar" data-toggle="modal" ><i class="fa fa-sync-alt"></i> Editar</button>
                                        <!-- <button id="btnHechoProducto" class="btn mb-2 btnAccion btn-success btnHecho"><i class="fa fa-check"></i> Hecho</!-->
                                        <button id="btnEliminarProducto" class="btn mb-2 btnAccion btn-danger btnEliminar"><i class="fa fa-trash"></i> Eliminar</button>
                                    </div>
                                </div>
                                <!-- title -->
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="border-top-0">
                                                <input style="display: none;" class="inp-cbx" type="checkbox" name="checkAll-Producto" id="checkAll-Producto">
                                                <label class="cbx" for="checkAll-Producto">
                                                    <span>
                                                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                </label>
                                            </th>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nombre</th>
                                            <th class="border-top-0">Descripcion</th>
                                            <th class="border-top-0">Categorias</th>
                                            <th class="border-top-0">CodigoBarras</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body-producto">
                                        <?php
                                            $listarProductos = "SELECT p.*, s.nombre nombreS, c.nombre nombreC FROM producto p INNER JOIN subcategoria s ON subcategoria_id = id_subcat INNER JOIN categoria c ON categoria_id = id_categoria ORDER BY id_prod";
                                            
                                            if($res = $con -> query($listarProductos)){
                                                if($res -> num_rows > 0){
                                                    while($fila = $res -> fetch_assoc()) {
                                                        echo "<tr id='row-producto{$fila['id_prod']}'>";
                                                            echo "<td>";
                                                                echo "<input style='display: none;' class='inp-cbx checkboxProducto' type='checkbox' data-idRow='{$fila['id_prod']}' name='check-Producto{$fila['id_prod']}' id='check-Producto{$fila['id_prod']}'>";
                                                                echo "<label class='cbx' for='check-Producto{$fila['id_prod']}'>";
                                                                    echo "<span>";
                                                                        echo "<svg width='12px' height='10px' viewbox='0 0 12 10'>";
                                                                            echo "<polyline points='1.5 6 4.5 9 10.5 1'></polyline>";
                                                                        echo "</svg>";
                                                                    echo "</span>";
                                                                echo "</label>";
                                                            echo "</td>";
                                                            echo "<td>{$fila['id_prod']}</td>";
                                                            echo "<td id='datos-nombre-producto-{$fila['id_prod']}' >{$fila['nombre']}</td>";
                                                            echo "<td id='datos-desc-producto-{$fila['id_prod']}'>{$fila['descripcion']}</td>";
                                                            echo "<td id='datos-subcat-producto-{$fila['id_prod']}'>{$fila['nombreS']}</td>";
                                                            echo "<td>{$fila['codigoB']}</td>";
                                                        echo "</tr>";
                                                    }
                                                }else{
                                                    echo "<tr>";
                                                        echo "<td colspan='6'>";
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
        <div id="alertGenProducto" class="alert bg-dark alertGen fadeOutDown"></div>
    </div>


<?php
    include("footer.php");
    }
?>