  
    <div class="slider-area">
        	<!-- Slider -->
			<div class="block-slider block-slider4">
				<ul class="" id="bxslider-home4">
					<?php
                                            $zap = $pdo->prepare("select count(id) from ksiazki");
                                            $zap->execute();
                                            $wynik = $zap->fetch(PDO::FETCH_NUM);


                                            $los = rand(1,$wynik[0]);

                                            if($los + 2 > $wynik[0]) $los = $wynik[0] - 2;
                                            
                                            for($i = $los; $i <= $los + 2; $i++){
                                                $book = new Book($pdo, $i);
                                                $book->displaySliderItem();
                                            }
                                        ?>
				</ul>
			</div>
			<!-- ./Slider -->
    </div> <!-- End slider area -->
    
    <div class="promo-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo1">
                        <i class="fa fa-refresh"></i>
                        <p>30 dni na zwrot!</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo2">
                        <i class="fa fa-truck"></i>
                        <p>Darmowa dostawa</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo3">
                        <i class="fa fa-lock"></i>
                        <p>Darmowa dostawa</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo4">
                        <i class="fa fa-gift"></i>
                        <p>Nowości</p>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End promo area -->
    
    <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="latest-product">
                        <h2 class="section-title">Nowości</h2>
                        <div class="product-carousel">
                            <!--
                            <div class="single-product">
                                <div class="product-f-image">
                                    <img src="../books/public/img/product-1.jpg" alt="">
                                    <div class="product-hover">
                                        <a href="#" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                        <a href="single-product.html" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                                    </div>
                                </div>
                                
                                <h2><a href="single-product.html">Samsung Galaxy s5- 2015</a></h2>
                                
                                <div class="product-carousel-price">
                                    <ins>$700.00</ins> <del>$100.00</del>
                                </div> 
                            </div>
                            -->
                            <?php
                                    $zap = $pdo->prepare("select id from ksiazki order by id desc limit 1");
                                    $zap->execute();
                                    $wynik = $zap->fetch(PDO::FETCH_NUM);
                                    $liczba_ksiazek = $wynik[0];
                                    for($i = 1; $i <= $liczba_ksiazek; $i++){
                                        $book = new Book($pdo, $i);
                                        $book->displayCarouselItem();
                                    }
                                ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End main content area -->

    <div class="product-widget-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Popularne</h2><br>
                        <a href="#" class="wid-view-more">Zobacz</a>
                        <?php
                            $zap = $pdo->prepare("select count(id) from ksiazki");
                            $zap->execute();
                            $wynik = $zap->fetch(PDO::FETCH_NUM);
                            
                            
                            $los = rand(1,$wynik[0]);
                            
                            if($los + 2 > $wynik[0]) $los = $wynik[0] - 2;
                            for($i = $los; $i <= $los + 2; $i++){
                                $book = new Book($pdo, $i);
                                $book->displayProductMini();
                            }
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Polecane</h2><br>
                        <a href="#" class="wid-view-more">Zobacz</a>
                        <?php
                            $zap = $pdo->prepare("select count(id) from ksiazki");
                            $zap->execute();
                            $wynik = $zap->fetch(PDO::FETCH_NUM);
                            
                            
                            $los = rand(1,$wynik[0]);
                            
                            if($los + 2 > $wynik[0]) $los = $wynik[0] - 2;
                            for($i = $los; $i <= $los + 2; $i++){
                                $book = new Book($pdo, $i);
                                $book->displayProductMini();
                            }
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Najnowsze</h2><br>
                        <a href="#" class="wid-view-more">Zobacz</a>
                        <?php
                            $zap = $pdo->prepare("select count(id) from ksiazki");
                            $zap->execute();
                            $wynik = $zap->fetch(PDO::FETCH_NUM);
                            
                            
                            $los = rand(1,$wynik[0]);
                            
                            if($los + 2 > $wynik[0]) $los = $wynik[0] - 2;
                            for($i = $los; $i <= $los + 2; $i++){
                                $book = new Book($pdo, $i);
                                $book->displayProductMini();
                            }
                        ?>
                    </div>
                </div>   
            </div>
        </div>
    </div> <!-- End product widget area -->