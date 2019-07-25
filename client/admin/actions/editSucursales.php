<?php
    include("../../conexion.php");




    $numero = $nombreSucursal = "";
    $nombre_err = $error = "";


    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        // Validar si el nombre de la tienda esta vacio
        if( empty(trim($_POST['editNumero'])) ){
            $nombre_err = "Introduce el numero de la Sucursal";
        }else{
            // Evaluamos si la tienda ya existe
            $sql = "SELECT id_direccion FROM direccion WHERE numero = ?";
            // Creamos el prepare Statement
            if( $stmt = $con -> prepare($sql) ){
                // Enlazamos una constante (incognita) con una variable
                $stmt -> bind_param("s", $param_numero);

                // Inicializamos la variable
                $param_numero = $con -> real_escape_string(trim($_POST['editNumero']));

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



        // Validar si el archivo subido no esta vacio
        // if( empty($img) || !$_FILES['editImage'] ){
        //     $imagen_err = "Selecciona la imagen de la tienda";
        // }else{
        //     // Evaluamos si no tiene caracteres especiales
        //     if( checarNombreDeImagen($img) ){
        //         // Evaluamos si el nombre es muy grande
        //         if( checarTamañoDeLaImagen($img) ){
        //             $imagen_err = "Nombre de la imagen muy largo";
        //         }else{
        //             // Evaluamos la extension
        //             $extensionImagen = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        //             if( in_array($extensionImagen, $extensionesValidas) ){
        //                 $carpetaDestino = $carpetaDestino.$img;                
        //                 // Intentamos mover la imagen a la carpeta de destino
        //                 if( !file_exists($carpetaDestino) ){ // No existe el fichero
        //                     if( move_uploaded_file($tmp, "../".$carpetaDestino) ){
        //                         // No tengo nada que hacer aqui :v
        //                     }else{
        //                         $imagen_err = "No se pudo subir la imagen. Intentelo de nuevo mas tarde.";
        //                     }
        //                 }
        //             }else{
        //                 $imagen_err = "Tipo de extension no permitida";
        //             }
        //         }
        //     }else{
        //         $imagen_err = "Nombre del archivo no permitido";
        //     }
        // }


        
        if( empty($nombre_err) && empty($error)){
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