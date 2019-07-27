<?php
    include("../../conexion.php");

    $nombre = "";
    $nombre_err = $error = "";

    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        // Validar si el nombre de la tienda esta vacio
        if( empty(trim($_POST['addNombre'])) ){
            $nombre_err = "Introduce el nombre de la categoria";
        }else{
            // Evaluamos si la tienda ya existe
            $sql = "SELECT id_categoria FROM categoria WHERE nombre = ?";
            // Creamos el prepare Statement
            if( $stmt = $con -> prepare($sql) ){
                // Enlazamos una constante (incognita) con una variable
                $stmt -> bind_param("s", $param_nombre);

                // Inicializamos la variable
                $param_nombre = $con -> real_escape_string(trim($_POST['addNombre']));

                // Ejecutamos el query de la consulta
                if( $stmt -> execute() ){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si ya hay un registro
                    if( $stmt -> num_rows == 1 ){
                        $nombre_err = "Esta categoria ya ha sido registrada";
                    }else{
                        $nombre = $con -> real_escape_string(trim($_POST['addNombre']));
                    }
                }else{
                    $error = "Algo salio mal, intentalo de nuevo.";
                }
            }
            $stmt -> close();
        }
        
        if( empty($nombre_err) && empty($error) ){
            // Preparamos nuestro query
            $sql = "INSERT INTO categoria (nombre) VALUES (?)";
            
            if( $stmt = $con -> prepare($sql) ){
                $stmt -> bind_param("s", $param_nombre);

                $param_nombre = $nombre;
                

                if( $stmt -> execute() ){
                    // // Obtenemos el ID maximo para actualizar la tabla en el frontend
                    $sql = "SELECT max(id_categoria) maximo FROM categoria";
                    $res = $con -> query($sql);
                    $dato = $res -> fetch_assoc();
                    echo json_encode(["status" => "1", "mensaje" => "Se agrego correctamente", "nombre" => $nombre, "id" => $dato['maximo'] ]);
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error en el registro de la categoria"]);
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


        $con->close();
    }