<?php
    include("../../conexion.php");

    $nombre = $apellidoP = $apellidoM = $email = $privilegio = $ciudad ="";
    $nombre_err = $apellidoP_err = $apellidoM_err = $ciudad_err= $error = $email_err = "";
    $admin=false; 

    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        
        if($_POST["addAdmin"]=="1"){
            $admin=true;
        }

        // Evaluar si el nombre esta vacio
        if( empty($_POST['addNombre']) ){
            $nombre_err = "Por favor introduce tu nombre";
        }else{
            $nombre = $con -> real_escape_string(trim($_POST['addNombre']));
        }

        // Evaluar si el apellido paterno esta vacio
        if( empty($_POST['addApellidoP']) ){
            $apellidoP_err = "Por favor introduce tu apellido paterno";
        }else{
            $apellidoP = $con -> real_escape_string(trim($_POST['addApellidoP']));
        }

        // Validar si el apellido materno esta vacio
        if( empty(trim($_POST['addApellidoM'])) ){
            $apellidoM_err = "Por favor introduce tu apellido materno";
        }else{
            $apellidoM = $con -> real_escape_string(trim ($_POST['addApellidoM']));
        }

        // Validar si el email esta vacio
        if( empty(trim($_POST['addEmail'])) ){
            $email_err = "Introduce tu email";
        }else{
            $existe = "SELECT id_usuario FROM usuarios WHERE email = ?";

            // Evaluamos si podemos preparar la consulta
            if( $stmt = $con -> prepare($existe) ){
                $stmt -> bind_param("s", $param_nombre);

                // Inicializamos la variable
                $param_nombre = $con -> real_escape_string(trim($_POST['addEmail']));

                // Verificamos si podemos ejecutar el query
                if( $stmt -> execute() ){

                    // Guardamos el resultado
                    $stmt -> store_result();
                    // Evaluamos si nos regresa algun registro
                    if( $stmt -> num_rows == 1 ){
                        $email_err = "Este email ya existe";
                    }else{
                        $email = $con -> real_escape_string(trim($_POST['addEmail']));
                    }
                }else{
                    $error = "Hubo un error. Intentalo de nuevo.";
                }

            }
            $stmt -> close();
        
        if( empty($nombre_err) && empty($apellidoP_err) && empty($apellidoM_err) && empty($email_err) && empty($ciudad_err) && empty($error) ){
            // Preparamos nuestro query
            $sql = "INSERT INTO usuarios (nombre,apellidoP,apellidoM,email,admin,ciudad_id) VALUES (?,?,?,?,?,?)";
            
            if( $stmt = $con -> prepare($sql) ){
                $stmt -> bind_param("ssssss", $param_nombre,$param_apellidoP,$param_apellidoM,$param_email,$param_admin, $param_ciudad);

                $param_nombre = $nombre;
                $param_apellidoP = $apellidoP;
                $param_apellidoM = $apellidoM;
                $param_email = $email;
                if($admin){
                    $param_admin = 1;
                }else{
                    $param_admin = 0;
                }
                $param_ciudad = $_POST["addCiudad"];
                
                if( $stmt -> execute() ){
                    // Obtenemos el ID maximo para actualizar la tabla en el frontend
                    $maxSql = "SELECT max(id_usuario) maximus FROM usuarios";
                    $resQuery = $con -> query($maxSql);
                    $res = $resQuery -> fetch_assoc();
                    echo json_encode(["status" => "1", "id" => $res['maximus'], "nombre" => $nombre, "apellidoP" => $apellidoP, "apellidoM" => $apellidoM, "email" => $email, "admin" => $param_admin ,"ciudad" => $param_ciudad]);
                }else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error en el registro del usuario"]);
                }

            }
            $stmt -> close();
            
        }else{
            $cadenaReturn = "";
            $errores = [$nombre_err, $error, $apellidoP_err, $apellidoM_err, $ciudad_err];
            foreach($errores as $error){
                if(!empty($error)){
                    $cadenaReturn = $cadenaReturn."<li>{$error}</li>";
                }
            }
            echo json_encode(["status" => "0", "mensaje" => $cadenaReturn]);
        }


        $con->close();
    }
}