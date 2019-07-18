<?php include("barramenu.php");?>

  
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(images/registro.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
            
            
            <div class="row justify-content-center mt-5">
              <div class="col-md-8 text-center">
                <h1>Registrate ahora</h1>
                <p class="mb-0">Queremos que seas parte de nuestra comunidad de usuarios.</p>
              </div>
            </div>

            
          </div>
        </div>
      </div>
    </div>  


    <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 mb-5"  data-aos="fade">

            <h2 class="mb-5 text-black">Registro</h2>

            <form id="fomulario_registro" action="signup.php" method="post" class="p-5 bg-white">
             
              <div class="row form-group">
                <div class="col-12">
                  <label class="text-black" for="nombre">Nombre</label> 
                  <input type="text" name="nombre" id="nombre" class="form-control">
                </div>
              </div>
              
              <div class="row form-group">
                <div class="col-12 col-md-6">
                  <label class="text-black" for="apellidoP">Apellido Paterno</label> 
                  <input type="text" name="apellidoP" id="apellidoP" class="form-control">
                </div>
                <div class="col-12 col-md-6">
                  <label class="text-black" for="apellidoM">Apellido Materno</label> 
                  <input type="text" name="apellidoM" id="apellidoM" class="form-control">
                </div>
              </div>
            
              <div class="row form-group">  
                <div class="col-md-12">
                  <label class="text-black" for="email">Email</label> 
                  <input type="email" name="correo" id="email" class="form-control">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-6">
                  <label class="text-black" for="contra1">Contraseña</label> 
                  <input type="password" name="contraseña" id="contra1" class="form-control">
                </div>
                <div class="col-12 col-md-6">
                  <label class="text-black" for="contra2">Confirma contraseña</label> 
                  <input type="password" name="contraseñaC" id="contra2" class="form-control">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12">
                  <select class="form-control" name="ciudad" id="ciudad">
                    <option value="cd1">Chihuahua</option>
                    <option value="cd2">Ciudad 2</option>
                    <option value="cd3">Ciudad 3</option>
                  </select>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12">
                  <p>¿Ya estas registrado? <a href="inicio.php">Iniciar sesión</a></p>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" name="registrar" value="Registrarme" class="btn btn-primary py-2 px-4 text-white">
                </div>
              </div>

  
            </form>
          </div>
          
        </div>
      </div>
      <div id="container_alert" class="container_alert">
        <div id="alertExito" class="alert alert-success my-4 fade"></div>
        <div id="alertError" class="alert alert-danger my-4 fade"></div>
      </div>
    </div>

    <?php include("footer.php"); ?>

  <script>
    $(document).ready(function(){
      $("#fomulario_registro").submit(function(e){
        e.preventDefault();
        let info = $(this).serialize();
        $.ajax({
          url: "signup.php",
          method: "POST",
          data: info,
          dataType: "json",
          success: function(data, status, jqXHR){
            if(data.status == 1){
              $("#alertExito").toggleClass("fade").append(data.mensaje);
              window.location.href = "inicio.php";
            }else{
              // FIXME:
              // Mostrar solo un dot si solo hay un error
              $("#alertError").toggleClass("fade").append(data.mensaje);
              setTimeout(function(){
                $("#alertError").toggleClass("fade").empty();
              }, 4000)
            }
          },
          error: function(data, status, errorl){
            if(data.status == 0){
              $("#alertError").toggleClass("fade").append(data.mensaje);
            }
          }
        });
      });

    });

  </script>

    
  </body>
</html>