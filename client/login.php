<?php 
    session_start();

    if( isset($_SESSION['log']) && $_SESSION['log'] === true ){
        header("location: index.php");
        exit;
    }

    include("conexion.php");

    $correo = $contraseña = "";
    $correo_err = $contraseña_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty(trim($_POST['correo']))){
            $correo_err = "Introduce un correo";
        }else {
            if( !filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL) ){
                $correo_err = "Introduce un email valido";
            }
        }

    }