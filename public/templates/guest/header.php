<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ustora Demo</title>
    
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://localhost/books/public/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://localhost/books/public/css/font-awesome.min.css">
    
  
    <!-- Custom CSS -->
    <link rel="stylesheet" href="http://localhost/books/public/css/owl.carousel.css">
    <link rel="stylesheet" href="http://localhost/books/public/style.css">
    <link rel="stylesheet" href="http://localhost/books/public/css/responsive.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
    
  </head>
  <body>
        
        <div class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="user-menu">
                        <ul>
                            <li><a href="#"><i class="fa fa-user"></i> Moje konto</a></li>
                            <li><a href="http://localhost/books/cart"><i class="fa fa-user"></i> Koszyk</a></li>
                            <li><a href="http://localhost/books/checkout"><i class="fa fa-user"></i> Złóż zamówienie</a></li>
                            <li><a href="http://localhost/books/login"><i class="fa fa-user"></i> Logowanie</a></li>    
                            <li><a href="http://localhost/books/register"><i class="fa fa-user"></i> Rejestracja</a></li>    
                        </ul>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div> <!-- End header area -->
    
    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="http://localhost/books/"><img src="http://localhost/books/public/img/logo.png"></a></h1>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="shopping-item">
                        <a href="http://localhost/books/cart">Koszyk - <span class="cart-amunt"><?php 
                        echo json_encode($cart->getPrice()); 
                        ?> zł</span> <i class="fa fa-shopping-cart"></i> <span class="product-count"><?php 
                        echo json_encode($cart->count());
                        ?></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End site branding area -->
    
    <div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div> 
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="http://localhost/books/">Strona główna</a></li>
                        <li><a href="http://localhost/books/shop">Sklep</a></li>
                        <li><a href="http://localhost/books/cart">Koszyk</a></li>
                        <li><a href="http://localhost/books/checkout">Złóż zamówienie</a></li>
                        <li><a href="http://localhost/books/categories">Kategorie</a></li>
                        <li><a href="#">Inne</a></li>
                        <li><a href="#">Kontakt</a></li>
                    </ul>
                </div>   
            </div>
        </div>
    </div> <!-- End mainmenu area -->
                
			