<?php

    include("../../conexion.php");

    $nombre = "";
    $nombre_err = $error = "";

    if( $_SERVER["REQUEST_METHOD"] == "POST" ){

        // Evaluar si el nombre de la ciudad esta vacio
        if( empty(trim($_POST['addNombreCiudad'])) ){
            $nombre_err = "Introduce una ciudad";
        }else{
            // Evaluar si ya existe esa ciudad
            $existe = "SELECT id_ciudad FROM ciudad WHERE nombre = ?";

            // Verificamos si podemos crear una consulta preparada
            if( $stmt = $con -> prepare($existe) ){
                // Enlazamos variable con constante
                $stmt -> bind_param("s", $param_nombre);

                // Inicializamos variable
                $param_nombre = $con -> real_escape_string(trim($_POST['addNombreCiudad']));

                // Intentamos ejecutar el query
                if( $stmt -> execute() ){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si existe ese registro
                    if( $stmt -> num_rows == 1 ){
                        $nombre_err = "Esa ciudad ya existe";
                    }else{
                        $nombre = $con -> real_escape_string(trim($_POST['addNombreCiudad']));
                    }
                }else{
                    $error = "Algo salio mal. Intentalo de nuevo.";
                }

            }
            // Cerramos la consulta preparada
            $stmt -> close();


        }

        // Evaluamos si tenemos errores
        if( empty($nombre_err) && empty($error) ){
            $insertar = "INSERT INTO ciudad (nombre, estado_id) VALUES (?,?)";

            if($stmt = $con -> prepare($insertar)){
                $stmt -> bind_param("ss", $param_nombre, $param_idEst);

                $param_nombre = $nombre;
                $param_idEst = $_POST['selectEstado'];

                if( $stmt -> execute() ){
                    $max = "SELECT max(id_ciudad) maximus, e.nombre nombreE FROM ciudad c, estado e WHERE estado_id = id_estado";
                    $result = $con -> query($max);
                    $num = $result -> fetch_assoc(); 
                    echo json_encode(["status" => "1", "id" => intval($num['maximus']), "nombre" => $nombre, "estado" => $num['nombreE']]);
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


    }