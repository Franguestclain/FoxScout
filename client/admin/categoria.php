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

        <div class="modal fade" id="modalAgregarCategoria" tabindex="-1" role="dialog" aria-labelledby="modalAgregarCategoriaTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarCategoriaTitulo">Agregar Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-categoria" class="modal-body">
                        <form id="addCategoria" action="./actions/regCategoria.php" method="POST" enctype="multipart/form-data"> <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="addNombre">Nombre</label>
                                <input type="text" name="addNombre" id="addNombre" class="form-control">
                            </div>
                            <!-- <div class="form-group">
                                <label for="addImage">Imagen</label>
                                <input type="file" accept="image/png, image/jpeg, image/jpg" name="addImage" id="addImage" class="form-control">
                            </div> -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="addCategoria" id="registrarCategoria" name="registrarCategoria" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalAgregarSubcategoria" tabindex="-1" role="dialog" aria-labelledby="modalAgregarSubcategoriaTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarSubcategoriaTitulo">Agregar Subcategoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-subcategoria" class="modal-body">
                        <form id="addSubcategoria" action="./actions/regSubcategoria.php" method="POST" > <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="addNombre">Nombre</label>
                                <input type="text" name="addNombre" id="addNombre" class="form-control">
                            </div>
                           
                           <select class="form-control" name="selectSubcat" id="selectSubcat">
                           <?php
                                        $optionSubcat = "SELECT * FROM categoria";
                                        if($resOptionE = $con -> query($optionSubcat)){
                                            if( $resOptionE -> num_rows > 0 ){
                                                while($filaOptionE = $resOptionE -> fetch_assoc()){
                                                    echo "<option id='option-subcategoria-id{$filaOptionE['id_categoria']}' value='{$filaOptionE['id_categoria']}'>{$filaOptionE['nombre']}</option>";
                                                }
                                            }
                                        }
                                    ?> 
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="addSubcategoria" id="registrarSubcategoria" name="registrarSubcategoria" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditarCategoria" tabindex="-1" role="dialog" aria-labelledby="modalEditarCategoriaTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarCategoriaTitulo">Editar Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-editCategoria" class="modal-body">
                        <form id="editCategoria" action="./actions/editCategoria.php" method="POST"> <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="editNombreCategoria">Nombre</label>
                                <input type="text" name="editNombreCategoria" id="editNombreCategoria" class="form-control">
                            </div>
                            <!-- <div class="form-group">
                                <label for="editImage">Imagen</label>
                                <input type="file" accept="image/png, image/jpeg, image/jpg" name="editImage" id="editImage" class="form-control">
                            </div> -->
                            <input type="hidden" name="id" id="id-edit-Categoria">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="editCategoria" id="editarCategoria" name="editarCategoria" type="submit" class="btn btn-success" value="Hecho">
                    </div>
                </div>
            </div>
        </div>
       
        <div class="modal fade" id="modalEditarSubcategoria" tabindex="-1" role="dialog" aria-labelledby="modalEditarSubcategoriaTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarSubcategoriaTitulo">Editar Subcategoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body-ediSubcategoria" class="modal-body">
                        <form id="editSubcategoria" action="./actions/editSubcategoria.php" method="POST" enctype="multipart/form-data"> <!-- si nuestro form utiliza un input file, necesitamos incluid enctype="multipart/form-data" -->
                            <div class="form-group">
                                <label for="editNombreSubcategoria">Nombre</label>
                                <input type="text" name="editNombreSubcategoria" id="editNombreSubcategoria" class="form-control">
                            </div>
                            <select class="form-control" name="selectSubcat" id="selectSubcat">
                           <?php
                                        $optionSubcat = "SELECT * FROM categoria";
                                        if($resOptionE = $con -> query($optionSubcat)){
                                            if( $resOptionE -> num_rows > 0 ){
                                                while($filaOptionE = $resOptionE -> fetch_assoc()){
                                                    echo "<option id='option-subcategoria-id{$filaOptionE['id_categoria']}' value='{$filaOptionE['id_categoria']}'>{$filaOptionE['nombre']}</option>";
                                                }
                                            }
                                        }
                                    ?> 
                            </select>
                            <input type="hidden" name="id" id="id-edit-Subcategoria">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="editSubcategoria" id="editarSubcategoria" name="editarSubcategoria" type="submit" class="btn btn-success" value="Hecho">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDelCategoria" tabindex="-1" role="dialog">
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
                    <button id="confirmarCategoria" type="button" class="btn btn-primary">Ok</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDelSubcategoria" tabindex="-1" role="dialog">
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
                    <button id="confirmarSubcategoria" type="button" class="btn btn-primary">Ok</button>
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
                                        <h4 class="card-title">Categorías</h4>
                                        <!-- <h5 class="card-subtitle">Overview of Top Selling Items</h5> -->
                                    </div>
                                    <div class="ml-auto">
                                        <button id="btnAgregarCategoria" class="btn mb-2 btnAccion btn-success btnAgregar" data-toggle="modal" data-target="#modalAgregarCategoria"><i class="fa fa-plus"></i> Agregar</button>
                                        <button id="btnEditarCategoria" class="btn mb-2 btnAccion btn-primary btnEditar" data-toggle="modal" ><i class="fa fa-sync-alt"></i> Editar</button>
                                        <!-- <button id="btnHechoCategoria" class="btn mb-2 btnAccion btn-success btnHecho"><i class="fa fa-check"></i> Hecho</!-->
                                        <button id="btnEliminarCategoria" class="btn mb-2 btnAccion btn-danger btnEliminar"><i class="fa fa-trash"></i> Eliminar</button>
                                    </div>
                                </div>
                                <!-- title -->
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="border-top-0">
                                                <input style="display: none;" class="inp-cbx" type="checkbox" name="checkAll-Categoria" id="checkAll-Categoria">
                                                <label class="cbx" for="checkAll-Categoria">
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
                                    <tbody id="table-body-Categoria">
                                        <?php
                                            $listarCategorias = "SELECT * FROM categoria";
                                            // $ciudad = "SELECT nombre from ciudad"
                                            if($res = $con -> query($listarCategorias)){
                                                if($res -> num_rows > 0){
                                                    while($fila = $res -> fetch_assoc()) {
                                                        echo "<tr id='row-Categoria{$fila['id_categoria']}'>";
                                                            echo "<td>";
                                                                echo "<input style='display: none;' class='inp-cbx checkboxCategoria' type='checkbox' data-idRow='{$fila['id_categoria']}' name='check-Categoria{$fila['id_categoria']}' id='check-Categoria{$fila['id_categoria']}'>";
                                                                echo "<label class='cbx' for='check-Categoria{$fila['id_categoria']}'>";
                                                                    echo "<span>";
                                                                        echo "<svg width='12px' height='10px' viewbox='0 0 12 10'>";
                                                                            echo "<polyline points='1.5 6 4.5 9 10.5 1'></polyline>";
                                                                        echo "</svg>";
                                                                    echo "</span>";
                                                                echo "</label>";
                                                            echo "</td>";
                                                            echo "<td>{$fila['id_categoria']}</td>";
                                                            echo "<td id='datos-nombre-Categoria{$fila['id_categoria']}' >{$fila['nombre']}</td>";
                                                            // echo "<td><img id='img-Categoria{$fila['id_categoria']}' class='img-Categoria' src='{$fila['img']}' /></td>";
                                                        echo "</tr>";
                                                    }
                                                }else{
                                                    echo "<tr class='no_existe'>";
                                                        echo "<td colspan='3'>";
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
                <!-- Subcategorias -->
                <div class="row">
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Subcategorias</h4>
                                        <!-- <h5 class="card-subtitle">Overview of Top Selling Items</h5> -->
                                    </div>
                                    <div class="ml-auto">
                                        <button id="btnAgregarSubcategoria" class="btn mb-2 btnAccion btn-success btnAgregar" data-toggle="modal" data-target="#modalAgregarSubcategoria"><i class="fa fa-plus"></i> Agregar</button>
                                        <button id="btnEditarSubcategoria" class="btn mb-2 btnAccion btn-primary btnEditar" data-toggle="modal" ><i class="fa fa-sync-alt"></i> Editar</button>
                                        <!-- <button id="btnHechoTienda" class="btn mb-2 btnAccion btn-success btnHecho"><i class="fa fa-check"></i> Hecho</!-->
                                        <button id="btnEliminarSubcategoria" class="btn mb-2 btnAccion btn-danger btnEliminar"><i class="fa fa-trash"></i> Eliminar</button>
                                    </div>
                                </div>
                                <!-- title -->
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="border-top-0">
                                                <input style="display: none;" class="inp-cbx" type="checkbox" name="checkAll-Subcategoria" id="checkAll-Subcategoria">
                                                <label class="cbx" for="checkAll-Subcategoria">
                                                    <span>
                                                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                </label>
                                            </th>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Subcategoria</th>
                                            <th class="border-top-0">Categoria</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body-subcategoria">
                                        <?php
                                            $listarSubcategorias = "SELECT s.*, c.nombre nombreC FROM subcategoria s, categoria c WHERE categoria_id=id_categoria";
                                            // $ciudad = "SELECT nombre from ciudad"
                                            if($res = $con -> query($listarSubcategorias)){
                                                if($res -> num_rows > 0){
                                                    while($fila = $res -> fetch_assoc()) {
                                                        echo "<tr id='row-{$fila['id_subcat']}'>";
                                                            echo "<td>";
                                                                echo "<input style='display: none;' class='inp-cbx checkboxSubcategoria' type='checkbox' data-idRow='{$fila['id_subcat']}' name='check-Subcategoria{$fila['id_subcat']}' id='check-Subcategoria{$fila['id_subcat']}'>";
                                                                echo "<label class='cbx' for='check-Subcategoria{$fila['id_subcat']}'>";
                                                                    echo "<span>";
                                                                        echo "<svg width='12px' height='10px' viewbox='0 0 12 10'>";
                                                                            echo "<polyline points='1.5 6 4.5 9 10.5 1'></polyline>";
                                                                        echo "</svg>";
                                                                    echo "</span>";
                                                                echo "</label>";
                                                            echo "</td>";
                                                            echo "<td>{$fila['id_subcat']}</td>";
                                                            echo "<td id='datos-{$fila['id_subcat']}' >{$fila['nombre']}</td>";
                                                            echo "<td>{$fila['nombreC']}</td>";
                                                            
                                                        echo "</tr>";
                                                    }
                                                }else{
                                                    echo "<tr>";
                                                    echo "<td colspan='4'>";
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
        
        </div>
        <div id="alertGenCategoria" class="alert bg-dark alertGen fadeOutDown"></div>
    </div>



<?php
    include("footer.php");
    }
?>