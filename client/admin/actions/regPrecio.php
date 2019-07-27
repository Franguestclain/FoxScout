<?php
    include("../../conexion.php");

    // function checarNombreDeImagen($nombre){
    //     return (bool) ( (preg_match("`^[-0-9A-Z_\.]+$`i",$nombre)) ? true : false );
    // }

    // function checarTamañoDeLaImagen($nombre){
    //     return (bool) ((mb_strlen($nombre,"UTF-8") > 225) ? true : false);
    // }


    $precio = "";
    $precio_err=$error="";

    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        // Validar si el nombre de la tienda esta vacio
        if( empty(trim($_POST['addPrecio'])) ){
            $precio_err = "Introduce el precio del producto";
        }else{
            
        }

        
        if( empty($precio_err) ){
            // Preparamos nuestro query
            $sql = "INSERT INTO precioxtienda (precio,prod_id,direccion_id) VALUES (?,?,?)";
            
            if( $stmt = $con -> prepare($sql) ){
                $stmt -> bind_param("sss", $param_precio,$param_productoid,$param_direccion);

                $param_precio = $con -> real_escape_string(trim($_POST['addPrecio']));
                $param_productoid = $_POST["addProducto"];
                $param_direccion = $_POST["addSucursal"];
                

                if( $stmt -> execute() ){
                    // Obtenemos el ID maximo para actualizar la tabla en el frontend
                    $maxSql = "SELECT max(id_PxTienda) maximus FROM precioxtienda";
                    $resQuery = $con -> query($maxSql);
                    $res = $resQuery -> fetch_assoc();
                    echo json_encode(["status" => "1", "id" => $res['maximus'], "precio" => $param_precio, "producto" => $param_productoid, "sucursal" => $param_direccion]);
                   
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error en el registro de la subcategoria"]);
                }

            }
            $stmt -> close();
            
        }else{
            $cadenaReturn = "";
            $errores = [$precio_err, $error];
            foreach($errores as $error){
                if(!empty($error)){
                    $cadenaReturn = $cadenaReturn."<li>{$error}</li>";
                }
            }
            echo json_encode(["status" => "0", "mensaje" => $cadenaReturn]);
        }


        $con->close();
    }