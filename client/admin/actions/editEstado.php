<?php

    include("../../conexion.php");

    $nombre = "";
    $nombre_err = $error = "";

    if( $_SERVER['REQUEST_METHOD'] == "POST" ){

        // Evaluamos si esta vacio
        if( empty(trim($_POST['editNombreEstado'])) ){
            $nombre_err = "Introduce un estado";
        }else{
            // Evaluamos si ya existe el estado
            $existe = "SELECT id_estado FROM estado WHERE nombre = ?";

            // Preparamos la consulta
            if( $stmt = $con -> prepare($existe) ){
                // Enlazamos las variables
                $stmt -> bind_param("s", $param_nombre);

                // Inicializamos la(s) variable(s) de parametro
                $param_nombre = $con -> real_escape_string(trim($_POST['editNombreEstado']));

                // Intentamos ejecutar la consulta
                if($stmt -> execute()){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si hay un registro
                    if( $stmt -> num_rows == 1 ){
                        $nombre_err = "Ya existe este estado";
                    }else{
                        $nombre = $con -> real_escape_string(trim($_POST['editNombreEstado']));
                    }
                }else{
                    $error = "Algo salio mal, intentalo de nuevo.";
                }
            
            }
            $stmt -> close();

        }

        if( empty($nombre_err) && empty($error) ){
            $actualizar = "UPDATE estado SET nombre=? WHERE id_estado = ?";

            if( $stmt = $con -> prepare($actualizar) ){
                $stmt -> bind_param("si", $param_nombre, $param_id);

                $param_nombre = $nombre;
                $param_id = $_POST['id'];

                if($stmt -> execute()){
                    echo json_encode(["status" => "1", "mensaje" => "Se actualizaron los datos"]);
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error al actualizar el estado"]);
                }

            }
            $stmt -> close();

        }else{
            $cadenaReturn = "";
            $errores = [$nombre_err, $error];
            foreach($errores as $error){
                if(!empty($error)){
                    $cadenaReturn = $cadenaReturn."<li>{$error}</li>";
                }
            }
            echo json_encode(["status" => "0", "mensaje" => $cadenaReturn]);
        }

        $con -> close();
    }