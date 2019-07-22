<?php
    include("../../conexion.php");

    function checarNombreDeImagen($nombre){
        return (bool) ( (preg_match("`^[-0-9A-Z_\.]+$`i",$nombre)) ? true : false );
    }

    function checarTamañoDeLaImagen($nombre){
        return (bool) ((mb_strlen($nombre,"UTF-8") > 225) ? true : false);
    }

    $extensionesValidas = ['jpeg', 'jpg', 'png'];
    $nombre = $nombreImagen = "";
    $nombre_err = $imagen_err = $error = "";
    $carpetaDestino = "../imagenes/";

    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        // Validar si el nombre de la tienda esta vacio
        if( empty(trim($_POST['editNombre'])) ){
            $nombre_err = "Introduce el nombre de la tienda";
        }else{
            // Evaluamos si la tienda ya existe
            $sql = "SELECT id_tienda FROM tienda WHERE nombre = ?";
            // Creamos el prepare Statement
            if( $stmt = $con -> prepare($sql) ){
                // Enlazamos una constante (incognita) con una variable
                $stmt -> bind_param("s", $param_nombre);

                // Inicializamos la variable
                $param_nombre = $con -> real_escape_string(trim($_POST['editNombre']));

                // Ejecutamos el query de la consulta
                if( $stmt -> execute() ){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si ya hay un registro
                    if( $stmt -> num_rows == 1 ){
                        $nombre_err = "Esta tienda ya ha sido registrada";
                    }else{
                        $nombre = $con -> real_escape_string(trim($_POST['editNombre']));
                    }
                }else{
                    $error = "Algo salio mal, intentalo de nuevo.";
                }
            }
            $stmt -> close();
        }

        $img = $_FILES['editImage']['name'];
        $tmp = $_FILES['editImage']['tmp_name'];

        // Validar si el archivo subido no esta vacio
        if( empty($img) || !$_FILES['editImage'] ){
            $imagen_err = "Selecciona la imagen de la tienda";
        }else{
            // Evaluamos si no tiene caracteres especiales
            if( checarNombreDeImagen($img) ){
                // Evaluamos si el nombre es muy grande
                if( checarTamañoDeLaImagen($img) ){
                    $imagen_err = "Nombre de la imagen muy largo";
                }else{
                    // Evaluamos la extension
                    $extensionImagen = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                    if( in_array($extensionImagen, $extensionesValidas) ){
                        $carpetaDestino = $carpetaDestino.$img;                
                        // Intentamos mover la imagen a la carpeta de destino
                        if( !file_exists($carpetaDestino) ){ // No existe el fichero
                            if( move_uploaded_file($tmp, "../".$carpetaDestino) ){
                                // No tengo nada que hacer aqui :v
                            }else{
                                $imagen_err = "No se pudo subir la imagen. Intentelo de nuevo mas tarde.";
                            }
                        }
                    }else{
                        $imagen_err = "Tipo de extension no permitida";
                    }
                }
            }else{
                $imagen_err = "Nombre del archivo no permitido";
            }
        }


        
        if( empty($nombre_err) && empty($imagen_err) ){
            // Preparamos nuestro query
            $sql = "UPDATE tienda SET nombre=?, img=? WHERE id_tienda=?";
            
            if( $stmt = $con -> prepare($sql) ){
                $stmt -> bind_param("ssi", $param_nombre, $param_imagen, $param_id);

                $param_nombre = $nombre;
                $param_imagen = $carpetaDestino;
                $param_id = $_POST['id'];

                if( $stmt -> execute() ){
                    echo json_encode(["status" => "1", "mensaje" => "Se actualizo correctamente", "nombre" => $nombre, "rutaImg" => $carpetaDestino]);
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error al actualizar la tienda"]);
                }

            }
            $stmt -> close();
            // echo json_encode(["status" => "1", "nombreTienda" => $nombre, "nombreArchivo" => $nombreImagen]);
        }else{
            $cadenaReturn = "";
            $errores = [$nombre_err, $imagen_err, $error];
            foreach($errores as $error){
                if(!empty($error)){
                    $cadenaReturn = $cadenaReturn."<li>{$error}</li>";
                }
            }
            echo json_encode(["status" => "0", "mensaje" => $cadenaReturn]);
        }


        $con->close();
    }