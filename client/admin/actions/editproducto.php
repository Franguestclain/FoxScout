<?php

    include("../../conexion.php");

    function checarNombreDeImagen($nombre){
        $bandera = false;
        // Usamos el array 1ue contiene las cadenas de texto (proveninente de el index  name)
        foreach($nombre as $item){
            // Le pasamos verdadero o falso, a la bandera, que sera lo que determina nuestra sentencia if
            $bandera = (preg_match("`^[-0-9A-Z_\.]+$`i",$item)) ? true : false;
        }

        return (bool) $bandera;
    }

    function checarTamañoNombreImagen($nombre){
        $bandera = false;
        foreach($nombre as $item){
            $bandera = (mb_strlen($item,"UTF-8") > 225) ? true : false;
        }
        return (bool) $bandera;
    }

    $extensionesValidas = ['jpeg', 'jpg', 'png'];
    $producto = $descripcion = $nombreImagen = "";
    $producto_err = $imagen_err = $descripcion_err = $error = "";
    // Agregar "../../" en admin para que salgan las imagenes
    $carpetaDestino = "imagenes/productos/";
    $carpetasDestino = [];

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
        $arrImg = $arrImgTmp = [];
        $img = $_FILES['editImagenes']['name'];
        $tmp = $_FILES['editImagenes']['tmp_name'];
        // var_dump($_FILES['editImagenes']);
        foreach($img as $item){
            array_push($arrImg, $item); //Almacenando los nombres
        }
        foreach($tmp as $item){
            array_push($arrImgTmp, $item);
        }
        // Validar si el archivo subido no esta vacio
        if( empty($img) || !$_FILES['editImagenes'] ){
            $imagen_err = "Selecciona la imagen de el producto";
        }else{
            // Evaluamos si no tiene caracteres especiales
            if( checarNombreDeImagen($arrImg) ){
                // Evaluamos si el nombre es muy grande
                if( checarTamañoNombreImagen($arrImg) ){
                    $imagen_err = "Nombre de la(s) imagen(es) muy largo";
                }else{
                    // Evaluamos la extension
                    $extensionImagen = [];
                    foreach($arrImg as $item){
                        array_push($extensionImagen, strtolower(pathinfo($item, PATHINFO_EXTENSION)));
                    }
                    $existen = array_diff($extensionImagen, $extensionesValidas); //Obtenemos la diferencia, es decir si el array con las extensiones contiene algo diferente al de las permitidas
                    // var_dump($existen);
                    if( count($existen) == 0 ){
                        // $carpetaDestino = $carpetaDestino.$img;
                        $contador = 0;  
                        foreach($arrImg as $item){
                            if(!file_exists($carpetaDestino.$item)){
                                array_push($carpetasDestino, $carpetaDestino.$item);
                                if(move_uploaded_file($arrImgTmp[$contador], "../../".$carpetaDestino.$item)){
                                    // var_dump($arrImgTmp[$contador]);
                                }else{
                                    $imagen_err = "No se pudo subir la(s) imagen(es).";
                                }
                            }
                            $contador++;
                        }
                    }else{
                        $imagen_err = "Tipo de extension no permitida";
                    }
                }
            }else{
                $imagen_err = "Nombre del o los archivos no permitidos";
            }
        }

        // Evaluamos si la descripcion esta vacia
        if( empty($_POST['editDescripcion']) ){
            $descripcion_err = "Introduce algo en la descripcion";
        }else{
            $descripcion = $con -> real_escape_string($_POST['editDescripcion']);
        }


        // Evaluamos si no tenemos errores
        if( empty($producto_err) && empty($error) && empty($imagen_err) && empty($descripcion_err) ){
            $actualizar = "UPDATE producto SET nombre = ?, descripcion = ?, subcategoria_id = ? WHERE id_prod = ?";
            // Preparamos la consulta
            if( $stmt = $con -> prepare($actualizar) ){
                // Enlazamos las variables
                $stmt -> bind_param("sssi", $param_nombre, $param_descripcion, $param_subCatId, $param_id);

                $param_nombre = $producto;
                $param_descripcion = $descripcion;
                $param_subCatId = $_POST['selecteditSubCat'];
                // Agregar el codigo de barras
                // $param_codigoB = $carpetaDestino;
                $param_id = $_POST['id'];

                if( $stmt -> execute() ){
                    // Obtenemos el ID maximo para actualizar la tabla en el frontend
                    $mensajeImg = "";
                    // Obtenemos los ID de imagenesProd
                    $allIds = [];
                    $selectRegImg = "SELECT id_img FROM imagenesprod WHERE prod_id = {$_POST['id']}";
                    if( $res = $con -> query($selectRegImg) ){
                        if($res -> num_rows > 0){
                            while($registros = $res -> fetch_assoc()){
                                array_push($allIds, $registros['id_img']);
                            }
                        }else{
                            echo "Nel no hay registros del ID {$_POST['id']}";
                        }
                    }else{
                        echo "Nel no se ejecuto";
                    }

                    $contador = 0;

                    foreach($carpetasDestino as $item){
                        $insertImg = "UPDATE imagenesprod SET ruta = '{$item}' WHERE prod_id =  {$param_id} && id_img = {$allIds[$contador]}";
                        // var_dump($insertImg);
                        if( $con -> query($insertImg) ){
                        }else{
                            $mensajeImg = $mensajeImg." | ".$con->error;
                        }
                        $contador++;
                    }
                    echo json_encode(["status" => "1", "mensaje" => "exito", "carpetas" => $carpetasDestino]);
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