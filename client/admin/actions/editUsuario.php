<?php
    include("../../conexion.php");




    $nombre = $apellidoP = $apellidoM = $email = $privilegio = $ciudad ="";
    $nombre_err = $apellidoP_err = $apellidoM_err = $ciudad_err= $error = $email_err = "";


    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        // Validar si el nombre del usuario esta vacio
        if( empty(trim($_POST['editUsuario'])) ){
            $nombre_err = "Introduce el nombre del Usuario";
        }else{
            // Evaluamos si el email ya existe
            $sql = "SELECT id_usuario FROM usuarios WHERE email = ?";
            // Creamos el prepare Statement
            if( $stmt = $con -> prepare($sql) ){
                // Enlazamos una constante (incognita) con una variable
                $stmt -> bind_param("s", $param_email);

                // Inicializamos la variable
                $param_email = $con -> real_escape_string(trim($_POST['editUsuario']));

                // Ejecutamos el query de la consulta
                if( $stmt -> execute() ){
                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si ya hay un registro
                    if( $stmt -> num_rows == 1 ){
                        $nombre_err = "Este Usuario ya ha sido registrado";
                    }else{
                        $nombre = $con -> real_escape_string(trim($_POST['editUsuario']));
                    }
                }else{
                    $error = "Algo salio mal, intentalo de nuevo.";
                }
            }
            $stmt -> close();
        }



        
        if( empty($nombre_err)){
            // Preparamos nuestro query
            $sql = "UPDATE usuarios SET nombre=?,apellidoP=?,apellidoM=?,email=?,admin=?,ciudad_id=? WHERE id_usuario=?";
            
            if( $stmt = $con -> prepare($sql) ){
                $stmt -> bind_param("ssssssi", $param_nombre,$param_apellidoP,$param_apellidoM,$param_email,$param_admin, $param_ciudad, $param_usuarioid);

                // $param_nombre = $nombre;
                // $param_id = $_POST['id'];
                $param_nombre = $nombre;
                $param_apellidoP = $apellidoP;
                $param_apellidoM = $apellidoM;
                $param_email = $email;
                if($admin){
                    $param_admin=1;
                }else{
                    $param_admin=0;
                }
                $param_ciudad = $_POST["id_ciudad"];
                $param_usuarioid = $_POST['id'];

                if( $stmt -> execute() ){
                    $sql = "SELECT max(id_usuario) maximo FROM usuarios";
                    $res = $con -> query($sql);
                    $dato = $res -> fetch_assoc();
                    echo json_encode(["status" => "1", "mensaje" => "Se actualizo correctamente", "id" => $res['maximus'], "nombre" => $nombre, "apellidoP" => $apellidoP, "apellidoM" => $apellidoM, "email" => $email, "admin" => $param_admin ,"ciudad" => $param_ciudad ]);
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error al actualizar el usuario"]);
                }

            }
            $stmt -> close();
            // echo json_encode(["status" => "1", "nombreTienda" => $nombre, "nombreArchivo" => $nombreImagen]);
        }else{
            $cadenaReturn = "";
            $errores = [$nombre_err, $apellidoP_err, $apellidoM_err, $ciudad_err, $error, $email_err];
            foreach($errores as $error){
                if(!empty($error)){
                    $cadenaReturn = $cadenaReturn."<li>{$error}</li>";
                }
            }
            echo json_encode(["status" => "0", "mensaje" => $cadenaReturn]);
        }


        $con->close();
    }