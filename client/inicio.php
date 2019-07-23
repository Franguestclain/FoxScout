<?php 
  session_start();

  if( isset($_SESSION['log']) && $_SESSION['log'] === true ){
      header("location: index.php");
      exit;
  }

include("barramenu.php");

?>

  
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(images/hero_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
            
            
            <div class="row justify-content-center mt-5">
              <div class="col-md-8 text-center">
                <h1>Log In</h1>
                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
              </div>
            </div>

            
          </div>
        </div>
      </div>
    </div>  


    <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 mb-5"  data-aos="fade" >

            <h2 class="mb-5 text-black">Log In</h2>

            <form id="formLogin" action="login.php" method="POST" class="p-5 bg-white">
             
              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black" for="email">Email</label> 
                  <input type="email" name="correo" id="email" class="form-control">
                </div>
              </div>

              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black" for="subject">Contraseña</label> 
                  <input type="password" name="contraseña" id="subject" class="form-control">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12">
                  <p>¿Aun no tienes cuenta? <a href="register.php">Registrate</a></p>
                </div>
              </div>

            
              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Sign In" class="btn btn-primary py-2 px-4 text-white">
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
      $("#formLogin").submit(function(e){
        // Cancelando submit
        e.preventDefault();
        console.log("Entramos al submit cancelado");
        let info = $(this).serialize();
        $.ajax({
          url: "login.php",
          method: "POST",
          data: info,
          dataType: "json",
          success: function(data, status, jqXHR){
            if(data.status == 1){
              (data.permiso) ? window.location.href = "./admin/" :
                                      window.location.href = "index.php";
            }else{
              $("#alertError").toggleClass("fade").append(data.mensaje);
              setTimeout(function(){
                $("#alertError").toggleClass("fade").empty();
              }, 4000);
            }
          },
          error: function(data,status, error){
            if(data.status == 0){
              $("#alertError").toggleClass("fade").append(data.mensaje);
            }
          }
        });
      });
    </script>
  </body>
</html>