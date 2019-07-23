
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <title>Directory &mdash; Colorlib Website Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic:400,700,800" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/rangeslider.css">

    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>  
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    <header class="site-navbar container py-0 " role="banner">

      <!-- <div class="container"> -->
        <div class="row align-items-center">
          
          <div class="col-6 col-xl-2">
            <h1 class="mb-0 site-logo logo=fs"><a href="index.php" class="text-white mb-0"><img src="./images/logomamalonch.png" width="40" height="40"  alt="" srcset=""> FoxScout</a></h1>
          </div>
          <?php
            if(isset($_SESSION['admin']) && $_SESSION['admin'] === true){
          ?>
            <div class="col-12 col-md-10 d-none d-xl-block">
              <nav class="site-navigation position-relative text-right" role="navigation">

                <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                  <li class="active"><a href="index.php">Inicio</a></li>
                  <li><a href="listings.php">Tiendas</a></li>
                  <li class="">
                    <a href="comparativa.php">Comparativa</a>
                    
                  </li>
                  
                  <li class="mr-5"><a href="contact.php">Contacto</a></li>
                  <!-- <li><a class="username" href="#"></a></!-->
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nombre-s cta" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="bg-primary text-white rounded"><?php echo $_SESSION['nombre']; ?></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="./admin/">Panel de administrador</a>
                      <a class="dropdown-item" href="./admin/pages-profile.php">Mi cuenta</a>
                      <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                  </li>
                </ul>
              </nav>
            </div>
          <?php
            }else{
          ?>
            <div class="col-12 col-md-10 d-none d-xl-block">
              <nav class="site-navigation position-relative text-right" role="navigation">

                <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                  <li class="active"><a href="index.php">Inicio</a></li>
                  <li><a href="listings.php">Tiendas</a></li>
                  <li class="">
                    <a href="comparativa.php">Comparativa</a>
                    
                  </li>
                  <li class="mr-5"><a href="contact.php">Contacto</a></li>
                  <?php
                    if(isset($_SESSION['log']) && $_SESSION['log'] === true){
                  ?>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle nombre-s cta" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                      
                        <span class="bg-primary text-white rounded"><?php echo $_SESSION['nombre']; ?></span>
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Mi cuenta</a>
                        <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                    </li>
                  <?php
                    }else{
                  ?>
                    <li class="ml-xl-3 login"><a href="inicio.php"><span class="border-left pl-xl-4"></span>Iniciar sesion</a></li>
                    <li><a href="register.php" class="cta"><span class="bg-primary text-white rounded">Registro</span></a></li>
                  <?php
                    }
                  ?>
                </ul>
              </nav>
            </div>
          <?php
            }
          ?>


          <div class="d-inline-block d-xl-none ml-auto py-3 col-6 text-right" style="position: relative; top: 3px;">
            <a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a>
          </div>

        </div>
      <!-- </div> -->
      
    </header>
