<?php
    include("../../conexion.php");

    // function checarNombreDeImagen($nombre){
    //     return (bool) ( (preg_match("`^[-0-9A-Z_\.]+$`i",$nombre)) ? true : false );
    // }

    // function checarTamañoDeLaImagen($nombre){
    //     return (bool) ((mb_strlen($nombre,"UTF-8") > 225) ? true : false);
    // }


    // $extensionesValidas = ['jpeg', 'jpg', 'png'];
    // $nombre = $nombreImagen = "";
    // $nombre_err = $imagen_err = $error = "";
    // $carpetaDestino = "../imagenes/";

    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        // Validar si el nombre de la tienda esta vacio
        if( empty(trim($_POST['addNumero'])) ){
            $nombre_err = "Introduce el nombre de la Sucursal";
        }else{
            // Evaluamos si la tienda ya existe
            $sql = "SELECT id_direccion FROM direccion WHERE numero = ?";
            // Creamos el prepare Statement
            if( $stmt = $con -> prepare($sql) ){
                // Enlazamos una constante (incognita) con una variable
                $stmt -> bind_param("s", $param_nombre);

                // Inicializamos la variable
                $param_nombre = $con -> real_escape_string(trim($_POST['addNumero']));

                // Ejecutamos el query de la consulta
                if( $stmt -> execute() ){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si ya hay un registro
                    if( $stmt -> num_rows == 1 ){
                        $nombre_err = "Esta sucursal ya ha sido registrada";
                    }else{
                        $numero = $con -> real_escape_string(trim($_POST['addNumero']));
                    }
                }else{
                    $error = "Algo salio mal, intentalo de nuevo.";
                }
            }
            $stmt -> close();
        }

        
        if( empty($nombre_err) ){
            // Preparamos nuestro query
            $sql = "INSERT INTO direccion (calle,colonia,numero,tienda_id,ciudad_id) VALUES (?,?,?,?,?)";
            
            if( $stmt = $con -> prepare($sql) ){
                $stmt -> bind_param("sssss", $param_calle,$param_colonia,$param_numero,$param_tiendaid,$param_ciudadid);

                $param_calle = $con -> real_escape_string(trim($_POST['addCalle']));
                $param_colonia = $con -> real_escape_string(trim($_POST['addColonia']));
                $param_numero = $numero;
                $param_tiendaid = $_POST["selectTienda"];
                $param_ciudadid = $_POST["selectCiudad"];
                

                if( $stmt -> execute() ){
                    // // Obtenemos el ID maximo para actualizar la tabla en el frontend
                    // $maxSql = "SELECT max(id_categoria) maximus FROM categoria";
                    // $resQuery = $con -> query($maxSql);
                    // $res = $resQuery -> fetch_assoc();
                    // echo json_encode(["status" => "1", "id" => $res['maximus'], "nombre" => $nombre]);
                    echo json_encode(["status" => "1", "nombreSubategoria" => $numero]);
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