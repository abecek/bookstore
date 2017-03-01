<!--
    <footer>
        <p>Footer niezalogowany</p>
    </footer>
-->
    <div class="footer-top-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="footer-about-us">
                        <h2>u<span>Stora</span></h2>
                        
                        
                        <p>ftp.abeceko2.ayz.pl<br>
                        user: books@abeceko2.ayz.p
                        pass: ksiegarnia16</p>
                        <div class="footer-social">
                            <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Na skróty </h2>
                        <ul>
                            <li><a href="#">Moje konto</a></li>
                            <li><a href="#">Historia zamówień</a></li>
                            <li><a href="#">Wishlist</a></li>
                            <!-- <li><a href="#">Vendor contact</a></li> -->
                            <li><a href="#">Strona główna</a></li>
                        </ul>                        
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Kategorie</h2>
                        <ul>
                            <li><a href="#">Mobile Phone</a></li>
                            <li><a href="#">Home accesseries</a></li>
                            <li><a href="#">LED TV</a></li>
                            <li><a href="#">Computer</a></li>
                            <li><a href="#">Gadets</a></li>
                        </ul>                        
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-newsletter">
                        <h2 class="footer-wid-title">Newsletter</h2>
                        <p>Zapisz się do naszego Newslettera, aby nic nie przegapić.</p>
                        <div class="newsletter-form">
                            <form action="#">
                                <input type="email" placeholder="Podaj swój e-mail">
                                <input type="submit" value="Zapisz się">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End footer top area -->
    
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="copyright">
                        <p>&copy; 2015 uCommerce. All Rights Reserved. <a href="http://www.freshdesignweb.com" target="_blank">freshDesignweb.com</a></p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="footer-card-icon">
                        <i class="fa fa-cc-discover"></i>
                        <i class="fa fa-cc-mastercard"></i>
                        <i class="fa fa-cc-paypal"></i>
                        <i class="fa fa-cc-visa"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End footer bottom area -->
    
    
   
    <!-- Latest jQuery form server -->
    <script src="https://code.jquery.com/jquery.min.js"></script>
    
    <!-- Bootstrap JS form CDN -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    
    <!-- jQuery sticky menu -->
    <script src="http://localhost/books/public/js/owl.carousel.min.js"></script>
    <script src="http://localhost/books/public/js/jquery.sticky.js"></script>
    
    <!-- jQuery easing -->
    <script src="http://localhost/books/public/js/jquery.easing.1.3.min.js"></script>
    
    <!-- Main Script -->
    <script src="http://localhost/books/public/js/main.js"></script>
    
    <!-- Slider -->
    <script type="text/javascript" src="http://localhost/books/public/js/bxslider.min.js"></script>
    <script type="text/javascript" src="http://localhost/books/public/js/script.slider.js"></script>
    
    <script>
        function deleteItem(id){
                    $.ajax({
			type: 'POST',
			url: 'cart',
                        dataType: 'json',
			data: 
			{ 
                        	'action': 'deleteItem',
                                'id'    :    id
			},
                        success : function(response){
                            //alert("Cos poszlo");
                            console.log(response);
                        }
                    });
        };
        
        function addItem(id, qty, price){
                    $.ajax({
			type: 'POST',
			url: 'cart',
                        dataType: 'json',
			data: 
			{ 
                        	'action': 'addToCart',
                                'id'    : id,
                                'quantity' : qty,
                                'price' : price
 			},
                        success: function(response){
                            //alert("Cos poszlo");
                            console.log(response);
                        }
                    });
        };
        
        function plus(id, value){
                checkQuantity(id, 1);
        };
        
        function minus(id, value){  
                checkQuantity(id, -1);
        };
        
        function checkQuantity(id, val){
            var stara = parseInt(document.getElementById(id).innerHTML);
                    stara += val;
                    if (stara > 0) {
                        $.ajax({
                            type: 'POST',
                            url: 'cart',
                            dataType: 'json',
                            data: 
                            { 
                                    'action': 'checkQuantity',
                                    'id'    : id,
                                    'quantity' : stara
                            },
                            success : function(){
                                console.log("blbelebe");
                            }
                        });
   
                        document.getElementById(id).innerHTML = stara.toString();
                    }
                location.reload();
        };
  
    </script>
    
  </body>
</html>