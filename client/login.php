<?php 

    include("conexion.php");

    $correo = $contraseña = "";
    $correo_err = $contraseña_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Evaluamos si introdujo algo en el input
        if(empty(trim($_POST['correo']))){
            $correo_err = "Introduce un correo";
        }else {
            // Evaluamos si introdujo un correo valido
            if( !filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL) ){
                $correo_err = "Introduce un email valido";
            }else{
                $correo = $con -> real_escape_string(trim($_POST['correo']));
            }
        }

        // Evaluamos si introdujo una contraseña
        if( empty(trim($_POST['contraseña'])) ){
            $contraseña_err = "Introduce una contraseña";
        }else{
            $contraseña = $con-> real_escape_string(trim($_POST['contraseña']));
        }

        // Evaluamos si no tenemos errores y validamos credenciales
        if( empty($correo_err) && empty($contraseña_err) ){
            // Hacemos una consulta preparada
            $sql = "SELECT id_usuario, nombre, email, contra, admin FROM usuarios WHERE email = ?";

            if( $stmt = $con->prepare($sql) ){
                // Enlazamos la variable
                $stmt->bind_param("s", $param_correo);

                $param_correo = $correo;

                // Ejecutamos la consulta preparada
                if($stmt -> execute()){
                    // Almacenamos el resultado
                    $stmt -> store_result();

                    if($stmt->num_rows == 1){
                        // Enlazamos los campos seleccionados con las siguientes variables
                        $stmt->bind_result($id, $nombre, $correo, $contraseña_hasheada, $admin);
                        if($stmt-> fetch()){
                            if(password_verify($contraseña, $contraseña_hasheada)){
                                
                                /**
                                 * TODO:
                                 * Agregar por si es un admin poder rederijirlo a la interfaz
                                 */
                                session_start();

                                $_SESSION["log"] = true;
                                $_SESSION["id"]  = $id;
                                $_SESSION["correo"] = $correo;
                                $_SESSION["nombre"] = $nombre;
                                $_SESSION["admin"] = false;
                                if($admin === 1){
                                    $_SESSION["admin"] = true;
                                }

                                // header("location: index.php");
                                echo json_encode(["status" => "1", "permiso" => $_SESSION['admin']]);

                            }else{
                                $contraseña_err = "La contraseña es incorrecta";
                                echo json_encode(["status" => "0", "mensaje" => $contraseña_err]);
                            }
                        }
                    }else{
                        $correo_err = "No existe este correo";
                        echo json_encode(["status" => "0", "mensaje" => $correo_err]);                            
                    }

                }
            }
            $stmt->close();


        }else{
            $cadenaReturn = "";
            $errores = [$correo_err,$contraseña_err];
            foreach($errores as $error){
                if(!empty($error)){
                    $cadenaReturn = $cadenaReturn."<li>{$error}</li>";
                }
            }
            echo json_encode(["status" => "0", "mensaje" => $cadenaReturn]); 
        }

        $con->close();

    }