<?php
    include("../../conexion.php");




    $nombre = $nombreCategoria = "";
    $nombre_err = $error = "";


    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        // Validar si el nombre de la tienda esta vacio
        if( empty(trim($_POST['editNombreSubcategoria'])) ){
            $nombre_err = "Introduce el nombre de la subcategoria";
        }else{
            // Evaluamos si la tienda ya existe
            $sql = "SELECT id_subcat FROM subcategoria WHERE nombre = ?";
            // Creamos el prepare Statement
            if( $stmt = $con -> prepare($sql) ){
                // Enlazamos una constante (incognita) con una variable
                $stmt -> bind_param("s", $param_nombre);

                // Inicializamos la variable
                $param_nombre = $con -> real_escape_string(trim($_POST['editNombreSubcategoria']));

                // Ejecutamos el query de la consulta
                if( $stmt -> execute() ){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si ya hay un registro
                    if( $stmt -> num_rows == 1 ){
                        $nombre_err = "Esta subcategoria ya ha sido registrada";
                    }else{
                        $nombre = $con -> real_escape_string(trim($_POST['editNombreSubcategoria']));
                    }
                }else{
                    $error = "Algo salio mal, intentalo de nuevo.";
                }
            }
            $stmt -> close();
        }

        
        if( empty($nombre_err)){
            // Preparamos nuestro query
            $sql = "UPDATE subcategoria SET nombre=?, categoria_id=? WHERE id_subcat=?";
            
            if( $stmt = $con -> prepare($sql) ){
                $stmt -> bind_param("ssi", $param_nombre, $param_cat, $param_id);

                $param_nombre = $nombre;
                $param_cat = $_POST['selectSubcat'];
                $param_id = $_POST['id'];

                if( $stmt -> execute() ){
                    echo json_encode(["status" => "1", "mensaje" => "Se actualizo correctamente", "nombre" => $nombre]);
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