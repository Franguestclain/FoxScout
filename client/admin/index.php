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
        <?php include("nav.php"); ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include("aside.php"); ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->

        <!-- Comienza el Agregar usuario -->
        <!-- Termina agregar usuario -->

        <!-- Comienza el editar usuarios -->
        <div class="modal fade" id="modalEditarU" tabindex="-1" role="dialog" aria-labelledby="modalEditarUTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarUTitulo">Editar usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editUser" action="./actions/editUsuario.php" method="POST">
                            <div class="form-group">
                                <label for="editNombre">Nombre</label>
                                <input type="text" name="editNombre" id="editNombre" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <label for="editApellidoP">Apellido Paterno</label>
                                    <input type="text" name="editApellidoP" id="editApellidoP" class="form-control">
                                </div>
                                <div class="col form-group">
                                    <label for="editApellidoM">Apellido Materno</label>
                                    <input type="text" name="editApellidoM" id="editApellidoM" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="editEmail">Email</label>
                                <input type="email" name="editEmail" id="editEmail" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input type="checkbox" name="editAdmin" id="editAdmin" class="form-check-input">
                                        <label for="editAdmin" class="form-check-label">Administrador</label>
                                    </div>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="editCiudad" id="editCiudad">
                                    <?php
                                            $optionCiudad = "SELECT * FROM ciudad";
                                            if($resOptionC = $con -> query($optionCiudad)){
                                            if( $resOptionC -> num_rows > 0 ){
                                            while($filaOptionC = $resOptionC -> fetch_assoc()){
                                                echo "<option id='option-Ciudad-id{$filaOptionC['id_ciudad']}' value='{$filaOptionC['id_ciudad']}'>{$filaOptionC['nombre']}</option>";
                                                }
                                            }
                                         }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="id" id="id-edit-usuario">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input form="editUser" id="editarUsuario" name="editarUsuario" type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </div>
            </div>
        </div>                                    
        
        <!-- Termina el editar usuario -->

        <div class="modal fade" id="modalDelUsuario" tabindex="-1" role="dialog">
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
                    <button id="confirmarUsuario" type="button" class="btn btn-primary">Ok</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div>



        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-5">
                        <h4 class="page-title">Usuarios</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Table -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Usuarios</h4>
                                        <!-- <h5 class="card-subtitle">Overview of Top Selling Items</h5> -->
                                    </div>
                                    <div class="ml-auto">
                                        <button id="btnAdmin" class="btn btn-warning btnAgregar"><i class="fa fa-star"></i> Admin</button>
                                        <button id="btnEditarUsuario" class="btn btn-primary btnEditar"><i class="fa fa-sync-alt"></i> Editar</button>
                                        <button id="btnEliminarUsuario" class="btn btn-danger btnEliminar"><i class="fa fa-trash"></i> Eliminar</button>
                                    </div>
                                </div>
                                <!-- title -->
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle">
                                    <thead>
                                        <tr class="bg-light">
                                        <th class="border-top-0">
                                                <input style="display: none;" class="inp-cbx" type="checkbox" name="checkAll-Usuario" id="checkAll-Usuario">
                                                <label class="cbx" for="checkAll-Usuario">
                                                    <span>
                                                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                </label>
                                            </th>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nombre</th>
                                            <th class="border-top-0">Apellido Paterno</th>
                                            <th class="border-top-0">Apellido Materno</th>
                                            <th class="border-top-0">Email</th>
                                            <th class="border-top-0">Privilegio</th>
                                            <th class="border-top-0">Ciudad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $listar = "SELECT u.*, c.nombre nombreC FROM usuarios u INNER JOIN ciudad c ON id_ciudad = ciudad_id";
                                            // $ciudad = "SELECT nombre from ciudad"
                                            if($res = $con -> query($listar)){
                                                if($res -> num_rows > 0){
                                                    while($fila = $res -> fetch_assoc()) {
                                                        echo "<tr class='row-usuario' id='row-usuario{$fila['id_usuario']}'>";
                                                            echo "<td>";
                                                                echo "<input style='display: none;' class='inp-cbx checkboxUsuario' type='checkbox' data-idRow='{$fila['id_usuario']}' name='check-Usuario{$fila['id_usuario']}' id='check-Usuario{$fila['id_usuario']}'>";
                                                                echo "<label class='cbx' for='check-Usuario{$fila['id_usuario']}'>";
                                                                    echo "<span>";
                                                                        echo "<svg width='12px' height='10px' viewbox='0 0 12 10'>";
                                                                            echo "<polyline points='1.5 6 4.5 9 10.5 1'></polyline>";
                                                                        echo "</svg>";
                                                                    echo "</span>";
                                                                echo "</label>";
                                                            echo "</td>";
                                                            echo "<td>{$fila['id_usuario']}</td>";
                                                                        echo "<td id='datos-nombre-{$fila['id_usuario']}'>{$fila['nombre']}</td>";
                                                                        echo "<td id='datos-ap-{$fila['id_usuario']}'>{$fila['apellidoP']}</td>";
                                                                        echo "<td id='datos-am-{$fila['id_usuario']}'>{$fila['apellidoM']}</td>";
                                                                        echo "<td id='datos-email-{$fila['id_usuario']}'>{$fila['email']}</td>";
                                                                        if($fila['admin'] == 1){
                                                                          echo "<td id='datos-admin-{$fila['id_usuario']}' data-admin='{$fila['admin']}'><label class='label label-warning'>Admin</label></td>";
                                                                        }else{
                                                                            echo "<td id='datos-admin-{$fila['id_usuario']}' data-admin='{$fila['admin']}'><label class='label label-primary'>Usuario</label></td>";
                                                                        }
                                                                        echo "<td>{$fila['nombreC']}</td>";
                                                                        echo "</tr>";
                                                                        echo "<tr id='row-usuario{$fila['id_usuario']}'>";
                                                                        echo "<tr>";
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
                <!-- ============================================================== -->
                <!-- Table -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Recent comment and chats -->
                <!-- ============================================================== -->
                <!-- <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Recent Comments</h4>
                            </div>
                            <div class="comment-widgets scrollable">
                                <div class="d-flex flex-row comment-row m-t-0">
                                    <div class="p-2"><img src="assets/images/users/1.jpg" alt="user" width="50" class="rounded-circle"></div>
                                    <div class="comment-text w-100">
                                        <h6 class="font-medium">James Anderson</h6>
                                        <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                        <div class="comment-footer">
                                            <span class="text-muted float-right">April 14, 2016</span> <span class="label label-rounded label-primary">Pending</span> <span class="action-icons">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-heart"></i></a>    
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2"><img src="assets/images/users/4.jpg" alt="user" width="50" class="rounded-circle"></div>
                                    <div class="comment-text active w-100">
                                        <h6 class="font-medium">Michael Jorden</h6>
                                        <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                        <div class="comment-footer ">
                                            <span class="text-muted float-right">April 14, 2016</span>
                                            <span class="label label-success label-rounded">Approved</span>
                                            <span class="action-icons active">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="icon-close"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-heart text-danger"></i></a>    
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2"><img src="assets/images/users/5.jpg" alt="user" width="50" class="rounded-circle"></div>
                                    <div class="comment-text w-100">
                                        <h6 class="font-medium">Johnathan Doeting</h6>
                                        <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                        <div class="comment-footer">
                                            <span class="text-muted float-right">April 14, 2016</span>
                                            <span class="label label-rounded label-danger">Rejected</span>
                                            <span class="action-icons">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-heart"></i></a>    
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Temp Guide</h4>
                                <div class="d-flex align-items-center flex-row m-t-30">
                                    <div class="display-5 text-info"><i class="wi wi-day-showers"></i> <span>73<sup>°</sup></span></div>
                                    <div class="m-l-10">
                                        <h3 class="m-b-0">Saturday</h3><small>Ahmedabad, India</small>
                                    </div>
                                </div>
                                <table class="table no-border mini-table m-t-20">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted">Wind</td>
                                            <td class="font-medium">ESE 17 mph</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Humidity</td>
                                            <td class="font-medium">83%</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Pressure</td>
                                            <td class="font-medium">28.56 in</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Cloud Cover</td>
                                            <td class="font-medium">78%</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <ul class="row list-style-none text-center m-t-30">
                                    <li class="col-3">
                                        <h4 class="text-info"><i class="wi wi-day-sunny"></i></h4>
                                        <span class="d-block text-muted">09:30</span>
                                        <h3 class="m-t-5">70<sup>°</sup></h3>
                                    </li>
                                    <li class="col-3">
                                        <h4 class="text-info"><i class="wi wi-day-cloudy"></i></h4>
                                        <span class="d-block text-muted">11:30</span>
                                        <h3 class="m-t-5">72<sup>°</sup></h3>
                                    </li>
                                    <li class="col-3">
                                        <h4 class="text-info"><i class="wi wi-day-hail"></i></h4>
                                        <span class="d-block text-muted">13:30</span>
                                        <h3 class="m-t-5">75<sup>°</sup></h3>
                                    </li>
                                    <li class="col-3">
                                        <h4 class="text-info"><i class="wi wi-day-sprinkle"></i></h4>
                                        <span class="d-block text-muted">15:30</span>
                                        <h3 class="m-t-5">76<sup>°</sup></h3>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- ============================================================== -->
                <!-- Recent comment and chats -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <div id="alertGenUsuarios" class="alert bg-dark alertGen fadeOutDown"></div>
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
<?php
    include("footer.php");
    }
?>