<?php

    include("../../conexion.php");

    if(isset($_POST['ids'])){
        $arr = $_POST['ids'];
        foreach($arr as $item){
            $con -> query("DELETE FROM tienda WHERE id_tienda = {$item}");
        }
        echo json_encode(["status" => "1", "arr" => $arr]);
    }else{
        echo json_encode(["status" => "0", "mensaje" => "No pus no"]);
    }
