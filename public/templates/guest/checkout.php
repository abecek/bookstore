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
                            <div class="woocommerce-info">Masz już konto? <a class="showlogin" data-toggle="collapse" href="#login-form-wrap" aria-expanded="false" aria-controls="login-form-wrap">Zaloguj się</a>
                            </div>

                            <form id="login-form-wrap" class="login collapse" method="post">
                                <input type="hidden" name="action" value="login">
                                <p>Jeśli posiadasz konto zaloguj się. Jeśli jesteś nowym klientem załóż konto klikając na zakładkę "Rejestracja".</p>

                                <p class="form-row form-row-first">
                                    <label for="username">E-mail <span class="required">*</span>
                                    </label>
                                    <input type="text" id="username" name="email" class="input-text">
                                </p>
                                <p class="form-row form-row-last">
                                    <label for="password">Hasło <span class="required">*</span>
                                    </label>
                                    <input type="password" id="password" name="password" class="input-text">
                                </p>
                                <div class="clear"></div>


                                <p class="form-row">
                                    <input type="submit" value="Zaloguj się" name="login" class="button">
                                    <label class="inline" for="rememberme"><input type="checkbox" value="forever" id="rememberme" name="rememberme"> Zapamiętaj dane </label>
                                </p>
                                <p class="lost_password">
                                    <a href="#">Zapomniałeś hasła?</a>
                                </p>

                                <div class="clear"></div>
                            </form>

                            <div class="woocommerce-info">Posiadasz kupon rabatowy? <a class="showcoupon" data-toggle="collapse" href="#coupon-collapse-wrap" aria-expanded="false" aria-controls="coupon-collapse-wrap">Wprowadź go</a>
                            </div>

                            <form id="coupon-collapse-wrap" method="post" class="checkout_coupon collapse">

                                <p class="form-row form-row-first">
                                    <input type="text" value="" id="coupon_code" placeholder="kod kuponu" class="input-text" name="coupon_code">
                                </p>

                                <p class="form-row form-row-last">
                                    <input type="submit" value="Prześlij kupon" name="apply_coupon" class="button">
                                </p>

                                <div class="clear"></div>
                            </form>

                            <form action="" class="register-form" method="post" name="checkout">

                                <div id="customer_details" class="col2-set">
                                    <div class="col-1">
                                        <div class="woocommerce-billing-fields">
                                            <h3>Dane do wysyłki</h3>
                                                <input type="hidden" name="action" value="checkout_with_registration"> 
                                                
                                                <div>
                                                    <label style="width: 150px;" for="email">Email: </label>
                                                    <input type="email" name="email" required/>
                                                </div>
                                                <div>
                                                    <label style="width: 150px;" for="password">Hasło: </label>
                                                    <input type="password" required pattern="^\w{6,}$"  name="password1"/>
                                                </div>
                                                <div>
                                                    <label style="width: 150px;" for="password">Powtórz hasło: </label>
                                                    <input type="password" required name="password2"/>
                                                </div>
                                                <hr>

                                                <div>
                                                    <label style="width: 150px;" for="imie">Imie: </label>
                                                    <input type="text" required pattern="^[A-Za-zĄĘĆŁŃÓŚŻŹąęćłńóśżź]{3,15}$" name="imie"/>
                                                </div>
                                                <div>
                                                    <label style="width: 150px;" for="nazwisko">Nazwisko: </label>
                                                    <input type="text" required pattern="^[A-Za-zĄĘĆŁŃÓŚŻŹąęćłńóśżź]{3,35}$" name="nazwisko"/>
                                                </div>
                                                <div>
                                                    <label style="width: 150px;" for="telefon">Telefon: </label>
                                                    <input type="text" required pattern="^[0-9]{9}$"  name="telefon"/>
                                                </div>
                                                <div>
                                                    <label style="width: 150px;" for="ulica">Ulica: </label>
                                                    <input type="text" required pattern="^[A-Za-zĄĘĆŁŃÓŚŻŹąęćłńóśżź]{3,30}$" name="ulica"/>
                                                </div>
                                                <div>
                                                    <label style="width: 150px;" for="nr_domu">Nr domu: </label>
                                                    <input type="text" required pattern="^[0-9]{1,3}$|^[0-9]{1,3}+[a-zA-Z]$" name="nr_domu"/>
                                                </div>
                                                <div>
                                                    <label style="width: 150px;" for="nr_lokalu">Nr lokalu: </label>
                                                    <input type="text" pattern="^[0-9]{1,3}$|^[0-9]{1,3}+[a-zA-Z]$" name="nr_lokalu"/>
                                                </div>
                                                <div>
                                                    <label style="width: 150px;" for="kod_poczt">Kod pocztowy: </label>
                                                    <input type="text" required pattern="^[0-9]{2}-[0-9]{3}$" name="kod_poczt"/>
                                                </div>
                                                <div>
                                                    <label style="width: 150px;" for="miejscowosc">Miejscowość </label>
                                                    <input type="text" required pattern="^[A-Za-zĄĘĆŁŃÓŚŻŹąęćłńóśżź]{3,50}$|^[A-Za-zĄĘĆŁŃÓŚŻŹąęćłńóśżź]+[A-Za-zĄĘĆŁŃÓŚŻŹąęćłńóśżź0-9\s\-]+[A-Za-zĄĘĆŁŃÓŚŻŹąęćłńóśżź0-9]{1,50}$" name="miejscowosc"/>
                                                </div>
                                               
                                            
                                   

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
                                        
                                    </table>
                                    
                                    <div>
                                        By zrealizować zamówienie musisz być zarejestrowanym i zalogowanym użytkownikiem.
                                    </div>
                                    <div id="payment">
                                        

                                        <div class="form-row place-order">

                                            <input type="submit" value="Zarejestruj się" id="place_order" name="checkout_order" class="button alt">

                                        </div>

                                        <div class="clear"></div>

                                    </div>
                                </div>
                            </form>
                    
                </div>
            </div>
        </div>
    </div>


<script>
var validateForm = (function() {
    var options = {};
    var classError = 'error';

    var showFieldValidation = function(input, inputIsValid) {
        if (!inputIsValid) {
            if (!input.parentNode.className || input.parentNode.className.indexOf(options.classError)==-1) {
                input.parentNode.className += ' ' + options.classError
            }
        } else {
            var regError = new RegExp('(\\s|^)'+options.classError+'(\\s|$)');
            input.parentNode.className = input.parentNode.className.replace(regError, '');
        }
    };

    var testInputText = function(input) {             
        var inputIsValid = true;
        var pattern = input.getAttribute('pattern');

        if (pattern != null) {                
            var reg = new RegExp(pattern, 'gi');
            if (!reg.test(input.value)) {
                inputIsValid = false;
            }    
        } else {
            if (input.value=='') {            
                inputIsValid = false;
            }
        }

        if (inputIsValid) {
            showFieldValidation(input, true);
            return true;
        } else {
            showFieldValidation(input, false);
            return false;
        }    
    };
        
    var testInputEmail = function(input) {
        var fieldHasError = false;
        var mailReg = new RegExp('^[0-9a-zA-Z_.-]+@[0-9a-zA-Z.-]+\.[a-zA-Z]{2,3}$', 'gi');
       
        if (!mailReg.test(input.value)) {
            showFieldValidation(input, false);
            return false;
        } else {
            showFieldValidation(input, true);
            return true;
        }    
    };
       

    var prepareElements = function() {
        var elements = options.form.querySelectorAll('input[required], textarea[required], select[required]');

        [].forEach.call(elements, function(element) {
            element.removeAttribute('required');
            element.className += ' required';

            if (element.nodeName.toUpperCase() == 'INPUT') {
                var type = element.type.toUpperCase();

                if (type == 'TEXT' || type == 'PASSWORD') {
                    element.addEventListener('keyup', function() {testInputText(element)});
                    element.addEventListener('blur', function() {testInputText(element)});
                }
                if (type == 'EMAIL') {
                    element.addEventListener('keyup', function() {testInputEmail(element)});
                    element.addEventListener('blur', function() {testInputEmail(element)});
                } 
            }
            if (element.nodeName.toUpperCase() == 'TEXTAREA') {
                element.addEventListener('keyup', function() {testInputText(element)});
                element.addEventListener('blur', function() {testInputText(element)});                    
            }
        });        
    };

    var init = function(_options) {
        //do naszego modulu bedziemy przekazywac opcje
        options = {
            form : _options.form || null,
            classError : _options.classError || 'error'
        }
        if (options.form == null || options.form == undefined || options.form.length==0) {
            console.warn('validateForm: Źle przekazany formularz');
            return false;
        }
        prepareElements();
    };

    return {
        init : init
    }
})();

document.addEventListener("DOMContentLoaded", function() {
    var form = document.querySelector('.register-form');
    validateForm.init({form : form})
});
</script>
