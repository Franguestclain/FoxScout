<?php
    session_start();
?>



<?php include("barramenu.php");?>

  
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(images/contacto.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
            
            
            <div class="row justify-content-center mt-5">
              <div class="col-md-8 text-center">
                <h1>Contacto</h1>
                <p class="mb-0">Nos gusta escuchar a nuestros usuarios</p>
              </div>
            </div>

            
          </div>
        </div>
      </div>
    </div>  


    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-7 mb-5"  data-aos="fade">

            

            <form action="admin/actions/enviar.php" method="POST" class="p-5 bg-white">
             

              <div class="row form-group">
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black" for="name">Nombre</label>
                  <input type="text" id="name" class="form-control">
                </div>
                <div class="col-md-6">
                  <label class="text-black" for="Apellido">Apellido</label>
                  <input type="text" id="Apellido" class="form-control">
                </div>
              </div>

              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black" for="email">Correo</label> 
                  <input type="email" id="email" class="form-control">
                </div>
              </div>

              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black" for="Asunto">Asunto</label> 
                  <input type="Asunto" id="Asunto" class="form-control">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="Mensaje">Mensaje</label> 
                  <textarea name="Mensaje" id="Mensaje" cols="30" rows="7" class="form-control" placeholder="Escribe aquí tu mensaje…"></textarea>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Enviar Mensaje" class="btn btn-primary py-2 px-4 text-white">
                </div>
              </div>

  
            </form>
          </div>
          <div class="col-md-5"  data-aos="fade" data-aos-delay="100">
            
            <div class="p-4 mb-3 bg-white">
              <p class="mb-0 font-weight-bold">Dirección</p>
              <p class="mb-4">Av. Montes Americanos, No. 9501, Sector 35, C.P. 31216, Chihuahua, Chihuahua, México.</p>

              <p class="mb-0 font-weight-bold">Teléfono</p>
              <p class="mb-4"><a href="#">+1 232 3235 324</a></p>

              <p class="mb-0 font-weight-bold">Email</p>
              <p class="mb-0"><a href="#">FoxScoutTeam@gmail.com</a></p>

              <p class="mb-0 font-weight-bold">Página de Facebook</p>
              <p class="mb-0"><a href="https://www.facebook.com/FoxScout-855591458153815/"><img src="images/f_logo_RGB-Hex-Blue_512.png" width="40" height="40" alt="fb"></a></p>

            </div>
            
            <div class="p-4 mb-3 bg-white">
              <h3 class="h5 text-black mb-3">Mas Información:</h3>
              <p>Nos dedicamos al desarrollo de software multiplataforma para crear soluciones tanto para empresas pequeñas como para empresas de una mayor escala.
En este momento somos una micro empresa, nos ubicamos en la Universidad Tecnológica de Chihuahua.
</p>
              <p><a href="#" class="btn btn-primary px-4 py-2 text-white">Learn More</a></p>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center border-primary">
            <h2 class="font-weight-light text-primary">Preguntas frecuentes</h2>
            <!-- <p class="color-black-opacity-5">Lorem Ipsum Dolor Sit Amet</p> -->
          </div>
        </div>


        <div class="row justify-content-center">
          <div class="col-8">
            <div class="border p-3 rounded mb-2">
              <a data-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1" class="accordion-item h5 d-block mb-0">¿Se puede comprar en la página FoxScout?</a>

              <div class="collapse" id="collapse-1">
                <div class="pt-2">
                  <p class="mb-0">FoxScout solo es una página para búsqueda y comparativa de productos.</p>
                </div>
              </div>
            </div>

            <div class="border p-3 rounded mb-2">
              <a data-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4" class="accordion-item h5 d-block mb-0">¿Está disponible en mi país?</a>

              <div class="collapse" id="collapse-4">
                <div class="pt-2">
                  <p class="mb-0">Fox Scout actualmente solo funciona en México.</p>
                </div>
              </div>
            </div>

            <div class="border p-3 rounded mb-2">
              <a data-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2" class="accordion-item h5 d-block mb-0">¿Es gratis? </a>

              <div class="collapse" id="collapse-2">
                <div class="pt-2">
                  <p class="mb-0">Si, La consulta de productos y comparativas de productos es completamente gratis, así como el registro a la página. Próximamente los pequeños, medianos y grandes comercios se podrán suscribir en nuestra página para publicar sus productos (Esto si tendrá un costo). </p>
                </div>
              </div>
            </div>

            <div class="border p-3 rounded mb-2">
              <a data-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3" class="accordion-item h5 d-block mb-0">¿Cómo funciona la página?</a>

              <div class="collapse" id="collapse-3">
                <div class="pt-2">
                  <p class="mb-0"> El uso de FoxScout es realmente fácil, solo hay que buscar un producto y nos mostrara en que tiendas está disponible, así como los precios de cada una. Además, en la pestaña de comparativas se puede realizar comparativas entre productos o tiendas. 
</p>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
    
    
    <?php include("footer.php"); ?>
    
  </body>
</html>