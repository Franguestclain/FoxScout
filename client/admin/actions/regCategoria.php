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

        // $img = $_FILES['addImage']['name'];
        // $tmp = $_FILES['addImage']['tmp_name'];

        // // Validar si el archivo subido no esta vacio
        // if( empty($img) || !$_FILES['addImage'] ){
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


        
        if( empty($nombre_err) ){
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