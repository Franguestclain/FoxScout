<?php
    include("../../conexion.php");




    $numero = $tienda = $colonia = $calle = $ciudad = "";
    $numero_err = $colonia_err = $calle_err = $error = "";


    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        
        // Evaluar si la colonia esta vacia
        if( empty(trim($_POST['editColonia'])) ){
            $colonia_err = "Introduce una colonia";
        }else{
            $colonia = $con -> real_escape_string(trim($_POST['editColonia']));
        }
        
        // Evaluar si esta vacia la calle
        if( empty(trim($_POST['editCalle'])) ){
            $calle_err = "Introduce una calle";
        }else{
            $calle = $con -> real_escape_string(trim($_POST['editCalle']));
        }
        
        // Validar si el numero 
        if( empty(trim($_POST['editNumero'])) ){
            $nombre_err = "Introduce el numero de la Sucursal";
        }else{
            // Evaluamos si la tienda ya existe
            $sql = "SELECT id_direccion FROM direccion WHERE numero = ? && calle = ? && ciudad_id = ?";
            // Creamos el prepare Statement
            if( $stmt = $con -> prepare($sql) ){
                // Enlazamos una constante (incognita) con una variable
                $stmt -> bind_param("sss", $param_numero, $param_calle, $param_ciudad);

                // Inicializamos la variable
                $param_numero = $con -> real_escape_string(trim($_POST['editNumero']));
                $param_calle = $calle;
                $param_ciudad = $_POST['editselectCiudad'];

                // Ejecutamos el query de la consulta
                if( $stmt -> execute() ){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si ya hay un registro
                    if( $stmt -> num_rows == 1 ){
                        $nombre_err = "Esta Sucursal ya ha sido registrada";
                    }else{
                        $numero = $con -> real_escape_string(trim($_POST['editNumero']));
                    }
                }else{
                    $error = "Algo salio mal, intentalo de nuevo.";
                }
            }
            $stmt -> close();
        }


        
        if( empty($numero_err) && empty($colonia_err) && empty($calle_err) && empty($error) ){
            // Preparamos nuestro query
            $sql = "UPDATE direccion SET calle=?, colonia=?, numero=?, tienda_id=?, ciudad_id=? WHERE id_direccion=?";
            
            if( $stmt = $con -> prepare($sql) ){
                $stmt -> bind_param("sssssi", $param_calle, $param_colonia,$param_numero,$param_tiendaid,$param_ciudadid, $param_id);

                $param_calle = $con -> real_escape_string(trim($_POST['editCalle']));
                $param_colonia = $con -> real_escape_string(trim($_POST['editColonia']));
                $param_numero = $numero;
                $param_tiendaid = $_POST["editselectTienda"];
                $param_ciudadid = $_POST["editselectCiudad"];
                $param_id = $_POST['id'];

                if( $stmt -> execute() ){
                    echo json_encode(["status" => "1", "mensaje" => "Se actualizo correctamente", "numero" => $numero]);
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error al actualizar la tienda"]);
                }

            }
            $stmt -> close();
            // echo json_encode(["status" => "1", "nombreTienda" => $nombre, "nombreArchivo" => $nombreImagen]);
        }else{
            $cadenaReturn = "";
            $errores = [$numero_err, $colonia_err, $calle_err, $error];
            foreach($errores as $error){
                if(!empty($error)){
                    $cadenaReturn = $cadenaReturn."<li>{$error}</li>";
                }
            }
            echo json_encode(["status" => "0", "mensaje" => $cadenaReturn]);
        }


        $con->close();
    }