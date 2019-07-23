<?php

    include("../../conexion.php");

    $nombre  = "";
    $nombre_err = $error = "";

    if( $_SERVER["REQUEST_METHOD"] == "POST" ){

        // Evaluar si el estado ya existe
        // Primero si esta vacio el campo
        if(empty(trim($_POST['addNombreEstado']))){
            $nombre_err = "El nombre esta vacio";
        }else{
            // Creamos nuestra consulta con una incognita
            $existe = "SELECT id_estado FROM estado WHERE nombre = ?";
            // Evaluamos si podemos crear la sentencia preparada
            if( $stmt = $con -> prepare($existe) ){
                // Enlazamos variables
                $stmt -> bind_param("s", $param_nombre);

                // Inicializamos variable
                $param_nombre = $con -> real_escape_string(trim($_POST['addNombreEstado']));
                
                // Intentamos ejecutar la consulta
                if( $stmt -> execute() ){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si hay un registro
                    if( $stmt -> num_rows == 1 ){
                        $nombre_err = "Este estado ya ha sido registrado";
                    }else{
                        $nombre = $con -> real_escape_string(trim($_POST['addNombreEstado']));
                    }
                }else{
                    $error = "Algo salio mal, Intentalo de nuevo";
                }
            }
            // Cerramos la consulta preparada
            $stmt -> close();
        }

        // Si no tenemos errores
        if( empty($nombre_err) && empty($error) ){
            $insertar = "INSERT INTO estado (nombre) VALUES (?)";

            if( $stmt = $con -> prepare($insertar) ){
                $stmt -> bind_param("s", $param_nombre);

                $param_nombre = $nombre;

                if( $stmt -> execute() ){
                    $max = "SELECT max(id_estado) maximus FROM estado";
                    $result = $con -> query($max);
                    $num = $result -> fetch_assoc(); 
                    echo json_encode(["status" => "1","id" => (intval($num['maximus'])) ,"nombre" => $nombre]);
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error al insertar"]);
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