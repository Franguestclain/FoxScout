<?php
    include("conexion.php");

    $correo = $contraseña = $contraseña_confirmada = "";
    $correo_err = $contraseña_err = $contraseña_confirmada_err = "";

    // Verificamos el metodo de peticion al servidor
    if( $_SERVER["REQUEST_METHOD"] == "POST" ){
        /**
         * FIXME:
         * Evaluar si los inputs de nombre y apellidos estan vacios
         */
        // Inicializamos variables con los valores de los inputs sin caracteres especiales ni espacios en blanco
        $nombre = $con -> real_escape_string(trim($_POST['nombre']));
        $apellidoP = $con -> real_escape_string(trim($_POST['apellidoP']));
        $apellidoM = $con -> real_escape_string(trim($_POST['apellidoM']));
        // $ciudad = $con -> real_escape_string(trim($_POST['ciudad']));

        // Evaluamos si el input del correo esta vacio y mandamos mensaje de error en dado caso
        if(empty(trim($_POST['correo']))){ 
            $correo_err = "Introduce tu correo electronico, por favor.";
        }else{
            // Evaluamos si el correo es un correo valido, gracias a la constante FILTER_VALIDATE_EMAIL y la funcion filter_var()
            if(!filter_var($_POST["correo"],FILTER_VALIDATE_EMAIL)){
                $correo_err = "Por favor introduce un email valido";
            }else{
                // Creamos nuestra consulta sql con parametro incognita
                $sql = "SELECT id_usuario FROM usuarios WHERE email = ?";
                
                // Creamos la consulta preparada
                if($stmt = $con->prepare($sql)){
                    // Enlazamos una constante (incognita) a una variable que mas tarde tendra un valor
                    $stmt -> bind_param("s", $param_correo);
                    
                    // Inicializamos la variable enlazada
                    $param_correo = trim($_POST['correo']);

                    // Ejecutamos el query o consulta
                    if($stmt->execute()){
                        // Guardamos el resultado de la consulta
                        $stmt->store_result();
                        // Evaluamos si ese resultado nos trae un registro, en dado caso, el correo ya existe y mandamos mensaje de error
                        if($stmt->num_rows == 1){
                            $correo_err = "Este correo ya ha sido registrado";
                        }else{
                            // Si no existe creamos nuestra variable correo para despues insertarla en la tabla
                            $correo = trim($_POST["correo"]);
                        }
                    }else{
                        // Ya si de plano la ejecucion de la consulta falla (por motivos del servidos o base de datos), mandamos mensaje de error
                        echo "¡Oops! Algo fallo. Intentalo de nuevo mas tarde.";
                    }
                }
                $stmt ->close(); //Cerramos nuestra consulta preparada
            }
        }

        // Evaluamos si la contraseña esta vacia
        if(empty(trim($_POST["contraseña"]))){
            $contraseña_err = "Introduce una contraseña. Por favor.";
            // Si no esta vacia evaluamos si es menos de 8 caracteres   
        } elseif(strlen(trim($_POST["contraseña"])) < 8){
            $contraseña_err = "La contraseña debe tener al menos 8 caracteres.";
        } else{
            // Si no hay ningun error, tenemos nuestra constraseña
            $contraseña = trim($_POST["contraseña"]);
        }
        
        // Evaluamos la confirmacion de la contraseña
        // Evaluamos si esta vacia
        if(empty(trim($_POST["contraseñaC"]))){
            $contraseña_confirmada_err = "Porfavor confirma la contraseña.";     
        } else{
            // Si no esta vacia le damos valor a nuestra variable
            $contraseña_confirmada = trim($_POST["contraseñaC"]);
            // Evaluamos si tenemos error y si las contraseñas son diferentes
            if(empty($contraseña_err) && ($contraseña != $contraseña_confirmada)){
                $contraseña_confirmada_err = "Las contraseñas no son iguales.";
            }
        }

        // Evaluamos si no hemos tenido errores
        if(empty($correo_err) && empty($contraseña_err) && empty($contraseña_confirmada_err)){
        
            // Preparamos el insert
            $sql = "INSERT INTO usuarios (nombre, apellidoP, apellidoM, email, contra, ciudad_id) VALUES (?, ?, ?, ?, ?, ?)";
            
            if($stmt = $con->prepare($sql)){
                // Enlazamos variables a las constantes preparadas (incognitas)
                $stmt->bind_param("ssssss",$param_nombre,$param_apellidoP,
                    $param_apellidoM,$param_correo,$param_password, $param_ciudad);
    
                $param_nombre = $nombre;
                $param_apellidoP = $apellidoP;
                $param_apellidoM = $apellidoM;
                $param_correo = $correo;
                $param_password = password_hash($contraseña, PASSWORD_DEFAULT);
                $param_ciudad = 1;
                
                // Intentamos ejecutar la consulta
                if($stmt->execute()){
                    // Mandamos un JSON
                    echo json_encode(["status" => "1", "mensaje" => "Se registro exitosamente"]);
                } else{
                    echo json_encode(["status" => "0", "mensaje" => "Hubo un error en el registro"]);
                }
            }
             
            // Cerramos consulta preparada
            $stmt->close();
        }else{
            //FIXME:
            // Evaluar si hay algun o todos los errores para mostrar, porque puede que muestre cadena vacia
            $cadenaReturn = "";
            $errores = [$correo_err,$contraseña_err,$contraseña_confirmada_err];
            foreach($errores as $error){
                if(!empty($error)){
                    $cadenaReturn = $cadenaReturn."<li>{$error}</li>";
                }
            }
            echo json_encode(["status" => "0", "mensaje" => $cadenaReturn]);
        }
        
        // Close conection
        $con->close();


    }