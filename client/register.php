<?php include("barramenu.php");?>

  
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(images/hero_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
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

            <form action="signup.php" method="post" class="p-5 bg-white">
             
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
                  <label class="text-black" for="contra1">Password</label> 
                  <input type="password" name="contraseña" id="contra1" class="form-control">
                </div>
                <div class="col-12 col-md-6">
                  <label class="text-black" for="contra2">Re-type Password</label> 
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
                  <p>¿Ya estas registrado? <a href="login.html">Iniciar sesión</a></p>
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
    </div>

    
    <div class="newsletter bg-primary py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <h2>Newsletter</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
          </div>
          <div class="col-md-6">
            
            <form class="d-flex">
              <input type="text" class="form-control" placeholder="Email">
              <input type="submit" value="Subscribe" class="btn btn-white"> 
            </form>
          </div>
        </div>
      </div>
    </div>

    
    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-6">
                <h2 class="footer-heading mb-4">About</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident rerum unde possimus molestias dolorem fuga, illo quis fugiat!</p>
              </div>
              
              <div class="col-md-3">
                <h2 class="footer-heading mb-4">Navigations</h2>
                <ul class="list-unstyled">
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Services</a></li>
                  <li><a href="#">Testimonials</a></li>
                  <li><a href="#">Contact Us</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <h2 class="footer-heading mb-4">Follow Us</h2>
                <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <form action="#" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control border-secondary text-white bg-transparent" placeholder="Search products..." aria-label="Enter Email" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary text-white" type="button" id="button-addon2">Search</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <div class="border-top pt-5">
            <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
            </div>
          </div>
          
        </div>
      </div>
    </footer>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/rangeslider.min.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html>