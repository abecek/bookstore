<?php
$dane = $user->getAdress();
//print_r($user);
?>
<div class="container">
    <row>
        <div class="col-md-12">
            
            <h2><legend>Moje dane</legend></h2>
        </div>
    </row>
    <row>
        <div class="col-md-3">
            <form id="update_form" action="home" method="POST">
                <input type="hidden" name="action" value="change_password"> 
                <input type="hidden" name="id_user" value="<?php echo $user->getId(); ?>">
                <div>
                    <label for="old_password">Stare hasło: </label><br />
                    <input type="password" name="old_password"/>
                </div>
                <div>
                    <label for="password">Nowe hasło: </label><br />
                    <input type="password" name="password1"/>
                </div>
                <div>
                    <label for="password">Powtórz hasło: </label><br />
                    <input type="password" name="password2"/>
                </div>
                <input type="submit" value="Wyślij" />
            </form>
        </div>
        <div class="col-md-9">  
            <form id="update_form" action="" method="POST">
                <input type="hidden" name="action" value="update_profile"> 
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
            
                <input type="submit" value="Wyślij" />
            </form>
        </div>
    </row>
</div>
        