
<div class="container">
    <row>
        <div class="col-md-12">
            
            <h2><legend>Rejestracja</legend></h2>
            
            <form class="register-form" action="home" method="POST">
            <input type="hidden" name="action" value="register"> 
            
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
            
            <input type="submit" value="Wyślij" />
        </form>
        </div>
    </row>
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
        