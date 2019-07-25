<?php
    include("../../conexion.php");




    $nombre = $nombreCategoria = "";
    $nombre_err = $error = "";


    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        // Validar si el nombre de la tienda esta vacio
        if( empty(trim($_POST['editNombreCategoria'])) ){
            $nombre_err = "Introduce el nombre de la categoria";
        }else{
            // Evaluamos si la tienda ya existe
            $sql = "SELECT id_categoria FROM categoria WHERE nombre = ?";
            // Creamos el prepare Statement
            if( $stmt = $con -> prepare($sql) ){
                // Enlazamos una constante (incognita) con una variable
                $stmt -> bind_param("s", $param_nombre);

                // Inicializamos la variable
                $param_nombre = $con -> real_escape_string(trim($_POST['editNombreCategoria']));

                // Ejecutamos el query de la consulta
                if( $stmt -> execute() ){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si ya hay un registro
                    if( $stmt -> num_rows == 1 ){
                        $nombre_err = "Esta categoria ya ha sido registrada";
                    }else{
                        $nombre = $con -> real_escape_string(trim($_POST['editNombreCategoria']));
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


        
        if( empty($nombre_err)){
            // Preparamos nuestro query
            $sql = "UPDATE categoria SET nombre=? WHERE id_categoria=?";
            
            if( $stmt = $con -> prepare($sql) ){
                $stmt -> bind_param("si", $param_nombre, $param_id);

                $param_nombre = $nombre;
                $param_id = $_POST['id'];

                if( $stmt -> execute() ){
                    $sql = "SELECT max(id_categoria) maximo FROM categoria";
                    $res = $con -> query($sql);
                    $dato = $res -> fetch_assoc();
                    echo json_encode(["status" => "1", "mensaje" => "Se actualizo correctamente", "nombre" => $nombre, "id" => $dato['maximo'] ]);
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