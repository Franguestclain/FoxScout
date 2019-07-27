<?php

    include("../../conexion.php");

    $lista = "SELECT * FROM direccion WHERE tienda_id = ?";

    if( $stmt = $con -> prepare($lista) ){
        $stmt -> bind_param("s", $param_id);

        $param_id = $_GET['id'];

        if( $stmt -> execute() ){
            $res = $stmt -> get_result();

            if( $res -> num_rows > 0 ){
                $arr = [];
                while($registro = $res->fetch_assoc()){
                    array_push($arr, $registro);
                }
                echo json_encode(["status" => "1", "registros" => $arr]);

            }else{
                echo json_encode(["status" => "0", "mensaje" => "No hay sucursales de esta tienda."]);
            }

        }else{
            echo "no se pudo";
        }

    }
    $stmt -> close();