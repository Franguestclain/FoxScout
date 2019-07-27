<?php
    include("../../conexion.php");

    $calle = $colonia = $numero = $tienda = $ciudad = "";
    $calle_err = $colonia_err = $numero_err = $error = ""; 

    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        // Evaluar si la calle esta vacia
        if( empty($_POST['addCalle']) ){
            $calle_err = "Por favor introduce una calle";
        }else{
            $calle = $con -> real_escape_string($_POST['addCalle']);
        }

        // Evaluar si la colonia esta vacia
        if( empty($_POST['addColonia']) ){
            $colonia_err = "Por favor introduce una colonia";
        }else{
            $colonia = $con -> real_escape_string($_POST['addColonia']);
        }

        // Validar si el nombre de la tienda esta vacio
        if( empty(trim($_POST['addNumero'])) ){
            $numero_err = "Introduce el numero de la Sucursal";
        }else{
            // Evaluamos si la tienda ya existe
            $sql = "SELECT id_direccion FROM direccion WHERE numero = ? && calle = ?";
            // Creamos el prepare Statement
            if( $stmt = $con -> prepare($sql) ){
                // Enlazamos una constante (incognita) con una variable
                $stmt -> bind_param("ss", $param_nombre, $param_calle);

                // Inicializamos la variable
                $param_nombre = $con -> real_escape_string(trim($_POST['addNumero']));
                $param_calle = $calle;
                // Ejecutamos el query de la consulta
                if( $stmt -> execute() ){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si ya hay un registro
                    if( $stmt -> num_rows == 1 ){
                        $numero_err = "Este numero de sucursal ya ha sido registrado";
                    }else{
                        $numero = $con -> real_escape_string(trim($_POST['addNumero']));
                    }
                }else{
                    $error = "Algo salio mal, intentalo de nuevo.";
                }
            }
            $stmt -> close();
        }

        
        if( empty($calle_err) && empty($colonia_err) && empty($numero_err) && empty($error) ){
            // Preparamos nuestro query
            $sql = "INSERT INTO direccion (calle,colonia,numero,tienda_id,ciudad_id) VALUES (?,?,?,?,?)";
            
            if( $stmt = $con -> prepare($sql) ){
                $stmt -> bind_param("sssss", $param_calle,$param_colonia,$param_numero,$param_tiendaid,$param_ciudadid);

                $param_calle = $calle;
                $param_colonia = $colonia;
                $param_numero = $numero;
                $param_tiendaid = $_POST["selectTienda"];
                $param_ciudadid = $_POST["selectCiudad"];
                

                if( $stmt -> execute() ){
                    // Obtenemos el ID maximo para actualizar la tabla en el frontend
                    $maxSql = "SELECT max(id_direccion) maximus, t.nombre nombreT, c.nombre nombreC FROM direccion d, tienda t, ciudad c WHERE id_tienda = {$param_tiendaid} && id_ciudad = {$param_ciudadid}";
                    $resQuery = $con -> query($maxSql);
                    $res = $resQuery -> fetch_assoc();
                    echo json_encode(["status" => "1", "id" => $res['maximus'], "calle" => $calle, "colonia" => $colonia, "numero" => $numero, "tienda" => $res['nombreT'], "ciudad" => $res['nombreC']]);
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error en el registro de la subcategoria"]);
                }

            }
            $stmt -> close();
            
        }else{
            $cadenaReturn = "";
            $errores = [$numero_err, $error, $calle_err, $colonia_err];
            foreach($errores as $error){
                if(!empty($error)){
                    $cadenaReturn = $cadenaReturn."<li>{$error}</li>";
                }
            }
            echo json_encode(["status" => "0", "mensaje" => $cadenaReturn]);
        }


        $con->close();
    }