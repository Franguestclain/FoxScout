<?php
    include("conexion.php");

    if( isset($_POST['registrar']) ){
        $correo = $conn-> real_scape_string(trim($_POST['']));
        $correo_error = "";

    }