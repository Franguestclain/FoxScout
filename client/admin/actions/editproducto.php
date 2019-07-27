<?php

    include("../../conexion.php");

    function checarNombreDeImagen($nombre){
        return (bool) ( (preg_match("`^[-0-9A-Z_\.]+$`i",$nombre)) ? true : false );
    }

    function checarTamañoNombreImagen($nombre){
        return (bool) ((mb_strlen($nombre,"UTF-8") > 225) ? true : false);
    }

    $extensionesValidas = ['jpeg', 'jpg', 'png'];
    $producto = $descripcion = $nombreImagen = "";
    $producto_err = $imagen_err = $descripcion_err = $error = "";
    $carpetaDestino = "../imagenes/productos/";

    if( $_SERVER['REQUEST_METHOD'] == "POST" ){

        // Evaluamos si el nombre del producto esta vacio
        if( empty(trim($_POST['editNombreProd'])) ){
            $producto_err = "Introduce el nombre del producto";
        }else{
            // Evaluamos si existe ese producto
            $existe = "SELECT id_prod FROM producto WHERE nombre = ? && subcategoria_id = ?";

            // Evaluamos si podemos preparar la consulta
            if( $stmt = $con -> prepare($existe) ){
                $stmt -> bind_param("ss", $param_nombre, $param_subcat);

                // Inicializamos la variable
                $param_nombre = $con -> real_escape_string(trim($_POST['editNombreProd']));
                $param_subcat = $_POST['selecteditSubCat'];
                // Verificamos si podemos ejecutar el query
                if( $stmt -> execute() ){

                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si nos regresa algun registro
                    if( $stmt -> num_rows == 1 ){
                        $producto_err = "Este producto ya existe";
                    }else{
                        $producto = $con -> real_escape_string(trim($_POST['editNombreProd']));
                    }
                }else{
                    $error = "Hubo un error. Intentalo de nuevo.";
                }

            }
            $stmt -> close();

        }

        // Agregar evaluaciones de imagen de codigo de barras
        $img = $_FILES['editCodigoB']['name'];
        $tmp = $_FILES['editCodigoB']['tmp_name'];

        // Validar si el archivo subido no esta vacio
        if( empty($img) || !$_FILES['editCodigoB'] ){
            $imagen_err = "Selecciona la imagen de el producto";
        }else{
            // Evaluamos si no tiene caracteres especiales
            if( checarNombreDeImagen($img) ){
                // Evaluamos si el nombre es muy grande
                if( checarTamañoNombreImagen($img) ){
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

        // Evaluamos si la descripcion esta vacia
        if( empty($_POST['editDescripcion']) ){
            $descripcion_err = "Introduce algo en la descripcion";
        }else{
            $descripcion = $con -> real_escape_string($_POST['editDescripcion']);
        }


        // Evaluamos si no tenemos errores
        if( empty($producto_err) && empty($error) && empty($imagen_err) && empty($descripcion_err)){
            $actualizar = "UPDATE producto SET nombre = ?, descripcion = ?, subcategoria_id = ?, codigoB = ? WHERE id_prod = ?";
            // Preparamos la consulta
            if( $stmt = $con -> prepare($actualizar) ){
                // Enlazamos las variables
                $stmt -> bind_param("ssssi", $param_nombre, $param_descripcion, $param_subCatId, $param_codigoB, $param_id);

                $param_nombre = $producto;
                $param_descripcion = $descripcion;
                $param_subCatId = $_POST['selecteditSubCat'];
                // Agregar el codigo de barras
                $param_codigoB = $carpetaDestino;
                $param_id = $_POST['id'];

                if( $stmt -> execute() ){
                    // Obtenemos el ID maximo para actualizar la tabla en el frontend
                    echo json_encode(["status" => "1", "mensaje" => "exito"]);
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error en el registro de la tienda"]);
                }


            }
            $stmt -> close();
        }else{
            $cadenaReturn = "";
            $errores = [$producto_err, $imagen_err, $error, $descripcion_err];
            foreach($errores as $error){
                if(!empty($error)){
                    $cadenaReturn = $cadenaReturn."<li>{$error}</li>";
                }
            }
            echo json_encode(["status" => "0", "mensaje" => $cadenaReturn]);
        }

        $con -> close();
    }