<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
    
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Koszyk</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->
    
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Szukaj</h2>
                        <form action="#">
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
                
                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            <form method="post" action="checkout">
                                <table cellspacing="0" class="shop_table cart">
                                    <thead>
                                        <tr>
                                            <th class="product-remove">&nbsp;</th>
                                            <th class="product-thumbnail">&nbsp;</th>
                                            <th class="product-name">Nazwa</th>
                                            <th class="product-price">Cena</th>
                                            <th class="product-quantity">Ilość</th>
                                            <th class="product-subtotal">Łącznie</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $cart_tab = $cart->getItemsFromCart();
                                            foreach($cart_tab as $book){
                                                $bookInCart = new Book($pdo, $book["id"], $book["quantity"]);
                                                $bookInCart->displayCartItem();
                                            }
                                        ?>
                                        <tr>
                                            <td class="actions" colspan="6">
                                                <div class="coupon">
                                                    <label for="coupon_code">Kod rabatowy:</label>
                                                    <input type="text" placeholder="Wprowadź kod" value="" id="coupon_code" class="input-text" name="coupon_code">
                                                    <input type="submit" value="Zatwierdź kod rabatowy" name="apply_coupon" class="button">
                                                </div>
                                                <input type="submit" value="Odswież koszyk" name="update_cart" class="button">
                                                <input type="submit" value="Złóż zamówienie" name="proceed" class="checkout-button button alt wc-forward">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            
                            <form method="POST" action="cart">
                                <input type="hidden" name="action" value="clearCart"> 
                                <input type="submit" value="Wyczyść koszyk" class="button">
                            </form>

                            <div class="cart-collaterals">


                            <div class="cross-sells">
                                <h2>mogą Ci się spodobać</h2>
                                <ul class="products">
                                    <li class="product">
                                        <?php
                                            $zap = $pdo->prepare("select id from ksiazki order by id desc limit 1");
                                            $zap->execute();
                                            $wynik = $zap->fetch(PDO::FETCH_NUM);
                                            $liczba_ksiazek = $wynik[0];
                                            $book = new Book($pdo, rand(1, $liczba_ksiazek));
                                            $book->displayCarouselItem();
                                        ?>
                                    </li>

                                    <li class="product">
                                        <?php
                                            $zap = $pdo->prepare("select id from ksiazki order by id desc limit 1");
                                            $zap->execute();
                                            $wynik = $zap->fetch(PDO::FETCH_NUM);
                                            $liczba_ksiazek = $wynik[0];
                                            $book = new Book($pdo, rand(1, $liczba_ksiazek));
                                            $book->displayCarouselItem();
                                        ?>
                                    </li>
                                </ul>
                            </div>


                            <div class="cart_totals ">
                                <h2>Podsumowanie</h2>

                                <table cellspacing="0">
                                    <tbody>
                                        <tr class="cart-subtotal">
                                            <th>Zawartość koszyka</th>
                                            <td><span class="amount">
                                                <?php 
                                                    echo json_encode($cart->getPrice());
                                                    echo ' zł';
                                                ?>
                                                </span></td>
                                        </tr>

                                        <tr class="shipping">
                                            <th>Dostawa</th>
                                            <td>Darmowa wysyłka</td>
                                        </tr>

                                        <tr class="order-total">
                                            <th>Łącznie</th>
                                            <td><strong><span class="amount">
                                                    <?php 
                                                        echo json_encode($cart->getPrice());
                                                        echo ' zł';
                                                    ?>
                                                    </span></strong> </td>
                                        </tr>
                                        
                                        
                                    </tbody>
                                </table>
                            </div>


                            <form method="post" action="#" class="shipping_calculator">
                                <h2><a class="shipping-calculator-button" data-toggle="collapse" href="#calcalute-shipping-wrap" aria-expanded="false" aria-controls="calcalute-shipping-wrap">Oblicz koszt dostawy</a></h2>

                                <section id="calcalute-shipping-wrap" class="shipping-calculator-form collapse">

                                

                                <p class="form-row form-row-wide"><input type="text" id="calc_shipping_state" name="calc_shipping_state" placeholder="State / county" value="" class="input-text"> </p>

                                <p class="form-row form-row-wide"><input type="text" id="calc_shipping_postcode" name="calc_shipping_postcode" placeholder="Postcode / Zip" value="" class="input-text"></p>


                                <p><button class="button" value="1" name="calc_shipping" type="submit">Update Totals</button></p>

                                </section>
                            </form>


                            </div>
                        </div>                        
                    </div>                    
                </div>
            </div>
        </div>
    </div>



