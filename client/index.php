<?php
    session_start();
?>

  
  <?php include("barramenu.php");?>
  

    <div class="site-blocks-cover overlay" style="background-image: url(images/banter-snaps-kKEBaGVUwXY-unsplash.jpg" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-12">
            
            
            <div class="row justify-content-center mb-4">
              <div class="col-md-8 text-center">
                <?php
                  if(isset($_SESSION['admin']) && $_SESSION['admin'] === true){
                ?>
                <h1 class="" data-aos="fade-up">Bienvenidos a FoxScout admins</h1>
                <?php
                  }else{
                ?>
                  <h1 class="" data-aos="fade-up">Bienvenidos a FoxScout</h1>
                <?php
                  }
                ?>
                  <p data-aos="fade-up" data-aos-delay="100">El mejor buscador de productos locales.</p>
              </div>
            </div>

            <div class="form-search-wrap mb-3" data-aos="fade-up" data-aos-delay="200">
              <form method="post">
                <div class="row align-items-center">
                  <div class="col-lg-12 mb-4 mb-xl-0 col-xl-4">
                    <input type="text" class="form-control rounded" placeholder="¿Qué estás buscando?">
                  </div>
                  <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                    <div class="wrap-icon">
                      <span class="icon icon-room"></span>
                      <input type="text" class="form-control rounded" placeholder="Localidad">
                    </div>
                    
                  </div>
                  <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                    <div class="select-wrap">
                      <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                      <select class="form-control rounded" name="" id="">
                        <option value="">Todas las categorías</option>
                        <option value="">Línea Blanca</option>
                        <option value="">Libros &amp;  Revistas</option>
                        <option value="">Electrónicos</option>
                        <option value="">Herramienta para el hogar</option>
                        <option value="">Automóviles  &amp; Accesorios</option>
                        <option value="">Otros</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-12 col-xl-2 ml-auto text-right">
                    <input type="submit" class="btn btn-primary btn-block rounded" value="Buscar">
                  </div>
                  
                </div>
              </form>
            </div>

            <div class="row text-left trending-search" data-aos="fade-up"  data-aos-delay="300">
              <div class="col-12">
                <h2 class="d-inline-block">Búsquedas populares:</h2>
                <a href="#">iPhone xs</a>
                <a href="#">Samsung s9</a>
                <a href="#">Laptop asus</a>
                <a href="#">xbox</a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>  

    <div class="site-section bg-light">
      <div class="container">
        
        
        <div class="row">
          <div class="col-12">
            <h2 class="h5 mb-4 text-black">Featured Ads</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-12  block-13">
            <div class="owl-carousel nonloop-block-13">
              
              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_1.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Real Estate</span>
                  <!-- aqui es el cocoro -->

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <?php } ?>

                  <h3><a href="listings-single.html">Own New House</a></h3>
                  <address>Don St, Brooklyn, New York</address>

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>                  
                  <?php } ?>

                </div>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_2.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Real Estate</span>
                  <!-- aqui es el cocoro -->

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <?php } ?>

                  <h3><a href="listings-single.html">Own New House</a></h3>
                  <address>Don St, Brooklyn, New York</address>

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>                  
                  <?php } ?>

                </div>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_3.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Real Estate</span>
                  <!-- aqui es el cocoro -->

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <?php } ?>

                  <h3><a href="listings-single.html">Own New House</a></h3>
                  <address>Don St, Brooklyn, New York</address>

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>                  
                  <?php } ?>

                </div>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_4.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Real Estate</span>
                  <!-- aqui es el cocoro -->

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <?php } ?>

                  <h3><a href="listings-single.html">Own New House</a></h3>
                  <address>Don St, Brooklyn, New York</address>

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>                  
                  <?php } ?>

                </div>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_1.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Real Estate</span>
                  <!-- aqui es el cocoro -->

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <?php } ?>

                  <h3><a href="listings-single.html">Own New House</a></h3>
                  <address>Don St, Brooklyn, New York</address>

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>                  
                  <?php } ?>

                </div>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_2.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Real Estate</span>
                  <!-- aqui es el cocoro -->

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <?php } ?>

                  <h3><a href="listings-single.html">Own New House</a></h3>
                  <address>Don St, Brooklyn, New York</address>

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>                  
                  <?php } ?>

                </div>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_3.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Real Estate</span>
                  <!-- aqui es el cocoro -->

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <?php } ?>

                  <h3><a href="listings-single.html">Own New House</a></h3>
                  <address>Don St, Brooklyn, New York</address>

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>                  
                  <?php } ?>

                </div>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_4.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Real Estate</span>
                  <!-- aqui es el cocoro -->

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <?php } ?>

                  <h3><a href="listings-single.html">Own New House</a></h3>
                  <address>Don St, Brooklyn, New York</address>

                  <?php if(isset($_SESSION['log']) && $_SESSION['log'] === true){ ?>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>                  
                  <?php } ?>

                </div>
              </div>

            </div>
          </div>


        </div>
      </div>
    </div>
    
    <div class="site-section" data-aos="fade">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center border-primary">
            <h2 class="font-weight-light text-primary">Popular Categories</h2>
            <p class="color-black-opacity-5">Lorem Ipsum Dolor Sit Amet</p>
          </div>
        </div>
        <div class="overlap-category mb-5">
          <div class="row align-items-stretch no-gutters">
            <div class="col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
              <a href="#" class="popular-category h-100">
                <span class="icon"><span class="flaticon-car"></span></span>
                <span class="caption mb-2 d-block">Cars &amp; Vehicles</span>
                <span class="number">1,921</span>
              </a>
            </div>

            <div class="col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
              <a href="#" class="popular-category h-100">
                <span class="icon"><span class="flaticon-closet"></span></span>
                <span class="caption mb-2 d-block">Furniture</span>
                <span class="number">2,339</span>
              </a>
            </div>

            <div class="col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
              <a href="#" class="popular-category h-100">
                <span class="icon"><span class="flaticon-home"></span></span>
                <span class="caption mb-2 d-block">Real Estate</span>
                <span class="number">4,398</span>
              </a>
            </div>
            <div class="col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
              <a href="#" class="popular-category h-100">
                <span class="icon"><span class="flaticon-open-book"></span></span>
                <span class="caption mb-2 d-block">Books &amp; Magazines</span>
                <span class="number">3,298</span>
              </a>
            </div>
            
            <div class="col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
              <a href="#" class="popular-category h-100">
                <span class="icon"><span class="flaticon-tv"></span></span>
                <span class="caption mb-2 d-block">Electronics</span>
                <span class="number">`2,932</span>
              </a>
            </div>
            
            <div class="col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
              <a href="#" class="popular-category h-100">
                <span class="icon"><span class="flaticon-pizza"></span></span>
                <span class="caption mb-2 d-block">Other</span>
                <span class="number">183</span>
              </a>
            </div>
          </div>
        </div>
        
        
      </div>
    </div>


    <div class="site-section bg-light">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-7 text-left border-primary">
            <h2 class="font-weight-light text-primary">Trending Today</h2>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-lg-6">

            <div class="d-block d-md-flex listing">
              <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_2.jpg')"></a>
              <div class="lh-content">
                <span class="category">Real Estate</span>
                <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                <h3><a href="listings-single.html">Own New House</a></h3>
                <address>Don St, Brooklyn, New York</address>
                <p class="mb-0">
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-secondary"></span>
                  <span class="review">(3 Reviews)</span>
                </p>
              </div>
            </div>
            <div class="d-block d-md-flex listing">
                <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_3.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Furniture</span>
                  <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <h3><a href="listings-single.html">Wooden Chair &amp; Table</a></h3>
                  <address>Don St, Brooklyn, New York</address>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>
                </div>
              </div>

              <div class="d-block d-md-flex listing">
                <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_4.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Electronics</span>
                  <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <h3><a href="listings-single.html">iPhone X gray</a></h3>
                  <address>Don St, Brooklyn, New York</address>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>
                </div>
              </div>

             

          </div>
          <div class="col-lg-6">

            <div class="d-block d-md-flex listing">
              <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_1.jpg')"></a>
              <div class="lh-content">
                <span class="category">Cars &amp; Vehicles</span>
                <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                <h3><a href="listings-single.html">New Black Car</a></h3>
                <address>Don St, Brooklyn, New York</address>
                <p class="mb-0">
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-secondary"></span>
                  <span class="review">(3 Reviews)</span>
                </p>
              </div>
            </div>

            <div class="d-block d-md-flex listing">
              <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_2.jpg')"></a>
              <div class="lh-content">
                <span class="category">Real Estate</span>
                <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                <h3><a href="listings-single.html">Own New House</a></h3>
                <address>Don St, Brooklyn, New York</address>
                <p class="mb-0">
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-secondary"></span>
                  <span class="review">(3 Reviews)</span>
                </p>
              </div>
            </div>
            <div class="d-block d-md-flex listing">
                <a href="listings-single.html" class="img d-block" style="background-image: url('images/img_3.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Furniture</span>
                  <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <h3><a href="listings-single.html">Wooden Chair &amp; Table</a></h3>
                  <address>Don St, Brooklyn, New York</address>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>
                </div>
              </div>

          </div>
        </div>
      </div>
    </div>
    
    <div class="site-section bg-white">
      <div class="container">

        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center border-primary">
            <h2 class="font-weight-light text-primary">Testimonials</h2>
          </div>
        </div>

        <div class="slide-one-item home-slider owl-carousel">
          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_3.jpg" alt="Image" class="img-fluid mb-3">
                <p>John Smith</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>
          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_2.jpg" alt="Image" class="img-fluid mb-3">
                <p>Christine Aguilar</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>

          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_4.jpg" alt="Image" class="img-fluid mb-3">
                <p>Robert Spears</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>

          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_5.jpg" alt="Image" class="img-fluid mb-3">
                <p>Bruce Rogers</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>

        </div>
      </div>
    </div>



    <!-- <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center border-primary">
            <h2 class="font-weight-light text-primary">Our Blog</h2>
            <p class="color-black-opacity-5">See Our Daily News &amp; Updates</p>
          </div>
        </div>
        <div class="row mb-3 align-items-stretch">
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
            <div class="h-entry">
              <img src="images/img_1.jpg" alt="Image" class="img-fluid rounded">
              <h2 class="font-size-regular"><a href="#" class="text-black">Many People Selling Online</a></h2>
              <div class="meta mb-3">by Mark Spiker<span class="mx-1">&bullet;</span> Jan 18, 2019 <span class="mx-1">&bullet;</span> <a href="#">News</a></div>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus eligendi nobis ea maiores sapiente veritatis reprehenderit suscipit quaerat rerum voluptatibus a eius.</p>
            </div> 
          </div>
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
            <div class="h-entry">
              <img src="images/img_2.jpg" alt="Image" class="img-fluid rounded">
              <h2 class="font-size-regular"><a href="#" class="text-black">Many People Selling Online</a></h2>
              <div class="meta mb-3">by Mark Spiker<span class="mx-1">&bullet;</span> Jan 18, 2019 <span class="mx-1">&bullet;</span> <a href="#">News</a></div>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus eligendi nobis ea maiores sapiente veritatis reprehenderit suscipit quaerat rerum voluptatibus a eius.</p>
            </div> 
          </div>
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
            <div class="h-entry">
              <img src="images/img_3.jpg" alt="Image" class="img-fluid rounded">
              <h2 class="font-size-regular"><a href="#" class="text-black">Many People Selling Online</a></h2>
              <div class="meta mb-3">by Mark Spiker<span class="mx-1">&bullet;</span> Jan 18, 2019 <span class="mx-1">&bullet;</span> <a href="#">News</a></div>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus eligendi nobis ea maiores sapiente veritatis reprehenderit suscipit quaerat rerum voluptatibus a eius.</p>
            </div>
          </div>

          <div class="col-12 text-center mt-4">
            <a href="#" class="btn btn-primary rounded py-2 px-4 text-white">View All Posts</a>
          </div>
        </div>
      </div>
    </div> -->
  
    
    <?php
    include("footer.php"); 
    ?>
    
  </body>
</html>

<?php
  exit;
?>