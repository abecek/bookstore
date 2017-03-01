
<div class="container">
    <row>
        <div class="col-md-12">
            <h2><legend>Logowanie</legend></h2>
                            <form id="login-form" class="login" method="POST">
                                <input type="hidden" name="action" value="login">    
                                <p>Jeśli posiadasz konto zaloguj się za pomocą adresu e-mail oraz hasła. Jeśli nie posiadasz jeszcze konta przejdź do zakładki "Rejestracja".</p>

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
                                    <label class="inline" for="rememberme"><input type="checkbox" value="forever" id="rememberme" name="rememberme"> Zapamiętaj mnie </label>
                                </p>
                                <p class="lost_password">
                                    <a href="#">Zapomniałeś hasła?</a>
                                </p>

                                <div class="clear"></div>
                            </form>
        </div>
    </row>
</div>