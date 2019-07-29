<?php

    include("../../conexion.php");

    if( $_SERVER["REQUEST_METHOD"] == "GET" ){
        $sql = "SELECT * FROM tienda WHERE id_tienda=(
            SELECT tienda_id
            FROM direccion
            WHERE id_direccion = {$_GET['id']}
        )";

        if( $res = $con -> query($sql) ){
            if( $res -> num_rows == 1 ){
                $fila = $res ->fetch_assoc();
                echo json_encode(["status" => "1", "nombre" => $fila['nombre'], "id" => $fila['id_tienda']]);
            }else{
                echo json_encode(["status" => "0", "mensaje" => "No hay registros"]);
            }
        }else{
            echo json_encode(["status" => "1", "mensaje" => "No se pudo ejecutar la consulta"]);
        }

    }