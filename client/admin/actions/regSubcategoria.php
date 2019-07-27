<?php
    include("../../conexion.php");

    $nombre = "";
    $nombre_err = $error = "";

    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        // Validar si el nombre de la tienda esta vacio
        if( empty(trim($_POST['addNombreSubcategoria'])) ){
            $nombre_err = "Introduce el nombre de la subcategoria";
        }else{
            // Evaluamos si la tienda ya existe
            $sql = "SELECT id_subcat FROM subcategoria WHERE nombre = ? && categoria_id = ?";
            // Creamos el prepare Statement
            if( $stmt = $con -> prepare($sql) ){
                // Enlazamos una constante (incognita) con una variable
                $stmt -> bind_param("ss", $param_nombre, $param_catid);

                // Inicializamos la variable
                $param_nombre = $con -> real_escape_string(trim($_POST['addNombreSubcategoria']));
                $param_catid = $_POST["selectSubcat"];

                // Ejecutamos el query de la consulta
                if( $stmt -> execute() ){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si ya hay un registro
                    if( $stmt -> num_rows == 1 ){
                        $nombre_err = "Esta subcategoria ya ha sido registrada";
                    }else{
                        $nombre = $con -> real_escape_string(trim($_POST['addNombreSubcategoria']));
                    }
                }else{
                    $error = "Algo salio mal, intentalo de nuevo.";
                }
            }
            $stmt -> close();
        }

        
        if( empty($nombre_err) ){
            // Preparamos nuestro query
            $sql = "INSERT INTO subcategoria (nombre,categoria_id) VALUES (?,?)";
            
            if( $stmt = $con -> prepare($sql) ){
                $stmt -> bind_param("ss", $param_nombre,$param_id);

                $param_nombre = $nombre;
                $param_id = $_POST["selectSubcat"];
                

                if( $stmt -> execute() ){
                    // Obtenemos el ID maximo para actualizar la tabla en el frontend
                    $maxSql = "SELECT max(id_subcat) maximus, c.nombre nombreC FROM subcategoria, categoria c WHERE id_categoria = {$param_id}";
                    $resQuery = $con -> query($maxSql);
                    $res = $resQuery -> fetch_assoc();
                    echo json_encode(["status" => "1", "id" => $res['maximus'], "nombre" => $nombre, "categoria" => $res['nombreC']]);
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error en el registro de la subcategoria"]);
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