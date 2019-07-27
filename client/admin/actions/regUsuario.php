<?php
    include("../../conexion.php");

    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        if(isset($_POST['ids'])){
            $arr = $_POST['ids'];
            foreach($arr as $item){
                $con -> query("UPDATE usuarios SET admin = 1 WHERE id_usuario = {$item}");
            }
            echo json_encode(["status" => "1", "arr" => $arr]);
        }else{
            echo json_encode(["status" => "0", "mensaje" => "No pus no"]);
        }
        $con -> close();
    }