<?php
$dane = $user->getAdress();
//print_r($user);
?>
    
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Złóż zamówienie</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Szukaj</h2>
                        <form action="">
                            <input type="text" placeholder="Wyszukaj książki...">
                            <input type="submit" value="Znajdź">
                        </form>
                    </div>
                    
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Książki</h2>
                        <?php
                            $zap = $pdo->prepare("select count(id) from ksiazki");
                            $zap->execute();
                            $wynik = $zap->fetch(PDO::FETCH_NUM);

                            $los = rand(1,$wynik[0]);

                            $book = new Book($pdo, $los);
                            $book->displayMini();
                        ?>
                    </div>
                    
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Nowości</h2>
                        <ul>
                            <?php
                                $zap = $pdo->prepare("select id from ksiazki order by id desc limit 1");
                                $zap->execute();
                                $wynik = $zap->fetch(PDO::FETCH_NUM);

                                $book = new Book($pdo,  $wynik[0]);
                                $book->displayOneLine();
                            ?>                    
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            
                            <div class="woocommerce-info">Posiadasz kupon rabatowy? <a class="showcoupon" data-toggle="collapse" href="#coupon-collapse-wrap" aria-expanded="false" aria-controls="coupon-collapse-wrap">Wprowadź go</a>
                            </div>

                            <form id="coupon-collapse-wrap" method="post" class="checkout_coupon collapse">

                                <p class="form-row form-row-first">
                                    <input type="text" value="" id="coupon_code" placeholder="Coupon code" class="input-text" name="coupon_code">
                                </p>

                                <p class="form-row form-row-last">
                                    <input type="submit" value="Apply Coupon" name="apply_coupon" class="button">
                                </p>

                                <div class="clear"></div>
                            </form>

                            <form action="completion" class="checkout" method="post" name="http://localhost/books/completion">

                                <div id="customer_details" class="col2-set">
                                    <div class="col-1">
                                        <div class="woocommerce-billing-fields">
                                            <h3>Dane do wysyłki</h3>
                                            <input type="hidden" name="action" value="checkout"> 
                                            <input type="hidden" name="id_user" value="<?php echo $user->getId(); ?>">
                                            <div>
                                                <label for="telefon">Imie: </label><br />
                                                <input type="text" name="imie" value="<?php echo $dane['imie']; ?>"/>

                                            </div>
                                            <div>
                                                <label for="telefon">Nazwisko: </label><br />
                                                <input type="text" name="nazwisko" value="<?php echo $dane['nazwisko']; ?>"/>
                                            </div>
                                            <div>
                                                <label for="telefon">Telefon: </label><br />
                                                <input type="text" name="telefon" value="<?php echo $dane['telefon']; ?>"/>
                                            </div>
                                                        <div>
                                                <label for="ulica">Ulica: </label><br />
                                                <input type="text" name="ulica" value="<?php echo $dane['ulica']; ?>"/>
                                            </div>
                                                        <div>
                                                <label for="nr_domu">Nr domu: </label><br />
                                                <input type="text" name="nr_domu" value="<?php echo $dane['nr_domu']; ?>"/>
                                            </div>
                                                        <div>
                                                <label for="nr_lokalu">Nr lokalu: </label><br />
                                                <input type="text" name="nr_lokalu" value="<?php echo $dane['nr_lokalu']; ?>"/>
                                            </div>
                                                        <div>
                                                <label for="kod_poczt">Kod pocztowy: </label><br />
                                                <input type="text" name="kod_poczt" value="<?php echo $dane['kod_poczt']; ?>"/>
                                            </div>
                                                        <div>
                                                <label for="miejscowosc">Miejscowość </label><br />
                                                <input type="text" name="miejscowosc" value="<?php echo $dane['miejscowosc']; ?>"/>
                                            </div>

                                            
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                        </div>                       
                    </div>                    
                </div>
                <div class="col-md-4">
                    <h3 id="order_review_heading">Twoje zamówienie</h3>

                                <div id="order_review" style="position: relative;">
                                    <table class="shop_table">
                                        <thead>
                                            <tr>
                                                <th class="product-name">Nazwa</th>
                                                <th class="product-total">Łącznie</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $cart_tab = $cart->getItemsFromCart();
                                                foreach($cart_tab as $book){
                                                    $bookInCart = new Book($pdo, $book["id"], $book["quantity"]);
                                                    $bookInCart->displayCartItemSmall();
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>

                                            <tr class="cart-subtotal">
                                                <th>Zawartość koszyka</th>
                                                <td><span class="amount"><?php 
                                                    echo $cart->getPrice();
                                                    echo ' zł';
                                                    ?></span>
                                                </td>
                                            </tr>

                                            <tr class="shipping">
                                                <th>Dostawa</th>
                                                <td>

                                                    <select required="required" name="shipping_method">
                                                        <option value="darmowa">Darmowa wysyłka</option>
                                                        <option value="kurier">Kurier</option>
                                                        <option value="odbior">Odbiór osobisty</option>
                                                    </select>
                                                
                                                </td>
                                            </tr>


                                            <tr class="order-total">
                                                <th>Łącznie</th>
                                                <td><strong><span class="amount"><?php 
                                                    echo $cart->getPrice();
                                                    echo ' zł';
                                                    ?></span></strong> </td>
                                            </tr>

                                        </tfoot>
                                    </table>


                                    <div id="payment">
                                        <ul class="payment_methods methods">
                                            <li class="payment_method_bacs">
                                                <input type="radio" data-order_button_text="" checked="checked" value="bacs" name="payment_method" class="input-radio" id="payment_method_bacs">
                                                <label for="payment_method_bacs">Przelew bankowy </label>
                                                <div class="payment_box payment_method_bacs">
                                                    <p>Przelej łączną kwote na nasze konto bankowe, w tytule podając numer zamówienia.</p>
                                                </div>
                                            </li>
											
                                 <!--           <li class="payment_method_cheque">
                                                <input type="radio" data-order_button_text="" value="cheque" name="payment_method" class="input-radio" id="payment_method_cheque">
                                                <label for="payment_method_cheque">Cheque Payment </label>
                                                <div style="display:none;" class="payment_box payment_method_cheque">
                                                    <p>Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                                </div>
                                            </li>
									
									-->
											
                                            <li class="payment_method_paypal">
                                                <input type="radio" data-order_button_text="Proceed to PayPal" value="paypal" name="payment_method" class="input-radio" id="payment_method_paypal">
                                                <label for="payment_method_paypal">PayPal <img alt="PayPal Acceptance Mark" src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_mc_vs_ms_ae_UK.png"><a title="Czym jest PayPal?" onclick="javascript:window.open('https://www.paypal.com/gb/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;" class="about_paypal" href="https://www.paypal.com/gb/webapps/mpp/paypal-popup">Czym jest PayPal?</a>
                                                </label>
                                                <div style="display:none;" class="payment_box payment_method_paypal">
                                                    <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                                                </div>
                                            </li>
                                        </ul>

                                        <div class="form-row place-order">

                                            <input type="submit" value="Złóż zamówienie" id="place_order" class="button alt">


                                        </div>

                                        <div class="clear"></div>

                                    </div>
                                </div>
                            </form>
                </div>
            </div>
        </div>
    </div>

