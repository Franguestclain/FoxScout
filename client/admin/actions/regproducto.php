<?php

    include("../../conexion.php");

    function checarNombreDeImagen($nombre){
        $bandera = false;
        foreach($nombre as $item){
            $bandera = (preg_match("`^[-0-9A-Z_\.]+$`i",$item)) ? true : false;
        }

        return (bool) $bandera;
    }

    function checarTamañoNombreImagen($nombre){
        $bandera = false;
        foreach($nombre as $item){
            $bandera = (mb_strlen($item,"UTF-8") > 225) ? true : false;
        }
        return (bool)$bandera;
    }

    $extensionesValidas = ['jpeg', 'jpg', 'png'];
    $producto = $descripcion = $nombreImagen = "";
    $producto_err = $imagen_err = $descripcion_err = $error = "";
    $carpetaDestino = "imagenes/productos/";
    $carpetasDestino = [];

    if( $_SERVER['REQUEST_METHOD'] == "POST" ){

        // Evaluamos si el nombre del producto esta vacio
        if( empty(trim($_POST['addNombreProd'])) ){
            $producto_err = "Introduce el nombre del producto";
        }else{
            // Evaluamos si existe ese producto
            $existe = "SELECT id_prod FROM producto WHERE nombre = ? && subcategoria_id= ?";

            // Evaluamos si podemos preparar la consulta
            if( $stmt = $con -> prepare($existe) ){
                $stmt -> bind_param("ss", $param_nombre, $param_subcat);

                // Inicializamos la variable
                $param_nombre = $con -> real_escape_string(trim($_POST['addNombreProd']));
                $param_subcat = $_POST["selectSubCat"];
                // Verificamos si podemos ejecutar el query
                if( $stmt -> execute() ){

                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si nos regresa algun registro
                    if( $stmt -> num_rows == 1 ){
                        $producto_err = "Este producto ya existe";
                    }else{
                        $producto = $con -> real_escape_string(trim($_POST['addNombreProd']));
                    }
                }else{
                    $error = "Hubo un error. Intentalo de nuevo.";
                }

            }
            $stmt -> close();

        }

        // Agregar evaluaciones de imagen de codigo de barras
        $arrImg = $arrImgTmp = [];
        $img = $_FILES['imagen']['name'];
        $tmp = $_FILES['imagen']['tmp_name'];
        foreach($img as $item){
            array_push($arrImg, $item); //Almacenando los nombres
        }
        foreach($tmp as $item){
            array_push($arrImgTmp, $item);
        }
        // Validar si el archivo subido no esta vacio
        if( empty($img) || !$_FILES['imagen'] ){
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
                    if( count($existen) == 0 ){
                        // $carpetaDestino = $carpetaDestino.$img;
                        $contador = 0;  
                        foreach($arrImg as $item){
                            if(!file_exists($carpetaDestino.$item)){
                                array_push($carpetasDestino, $carpetaDestino.$item);
                                if(move_uploaded_file($arrImgTmp[$contador], "../../".$carpetaDestino.$item)){

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
        if( empty($_POST['descripcion']) ){
            $descripcion_err = "Introduce algo en la descripcion";
        }else{
            $descripcion = $con -> real_escape_string($_POST['descripcion']);
        }


        // Evaluamos si no tenemos errores
        if( empty($producto_err) && empty($error) && empty($imagen_err) && empty($descripcion_err)){
            $insertar = "INSERT INTO producto (nombre, descripcion, subcategoria_id) VALUES (?,?,?)";
            // Preparamos la consulta
            if( $stmt = $con -> prepare($insertar) ){
                // Enlazamos las variables
                $stmt -> bind_param("sss", $param_nombre, $param_descripcion, $param_subCatId);

                $param_nombre = $producto;
                $param_descripcion = $descripcion;
                $param_subCatId = $_POST['selectSubCat'];
                // Agregar el codigo de barras
                // $param_codigoB = $carpetaDestino;

                if( $stmt -> execute() ){
                    // Obtenemos el ID maximo para actualizar la tabla en el frontend
                    $maxSql = "SELECT max(p.id_prod) maximus, s.nombre nombreS, c.nombre nombreC FROM producto p INNER JOIN subcategoria s ON subcategoria_id = id_subcat INNER JOIN categoria c ON categoria_id = id_categoria";
                    $resQuery = $con -> query($maxSql);
                    $res = $resQuery -> fetch_assoc();
                    $mensajeImg = "";
                    $insertImg = "";
                    foreach($arrImg as $item){
                        if( $item === $arrImg[0] ){
                            $insertImg = "INSERT INTO imagenesprod (ruta,indice, prod_id) VALUES('{$carpetaDestino}{$item}',1,{$res['maximus']})";
                        }else{
                            $insertImg = "INSERT INTO imagenesprod (ruta, prod_id) VALUES('{$carpetaDestino}{$item}',{$res['maximus']})";
                        }
                        if( $con -> query($insertImg) ){

                        }else{
                            $mensajeImg = $mensajeImg." | ".$con->error;
                        }
                    }
                    echo json_encode(["status" => "1", "id" => $res['maximus'], "nombre" => $producto,"desc" => $descripcion,"categorias" => "{$res['nombreC']} > {$res['nombreS']}", "mensajeWea" => $mensajeImg]);
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error en el registro de la tienda"]);
                }


            }
            $stmt -> close();
        }else{
            $cadenaReturn = "";
            $errores = [$producto_err, $imagen_err, $error];
            foreach($errores as $error){
                if(!empty($error)){
                    $cadenaReturn = $cadenaReturn."<li>{$error}</li>";
                }
            }
            echo json_encode(["status" => "0", "mensaje" => $cadenaReturn]);
        }

        $con -> close();
    }