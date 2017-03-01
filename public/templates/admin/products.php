
<div>
    <div class="container">
        <row>
            <div class="col-md-12">
                <div class="user-menu">
                    <ul>
                        <li><a href="http://localhost/books/newproduct"><i class="fa"></i>Nowa książka</a></li>
                    </ul>
                </div>
            </div>
        </row>
        <row>
            <div class="col-md-6">
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Tytuł</th>
                        <th>Zdjęcie</th>
                        <th>ID Wydawnictwa</th>
                        <th>Rok wydania</th>
                        <th>Książek na stanie</th>
                        <th>Cena</th>
                        <th>Okładka</th>
                        <th>Strony</th>
                        <th>Obniżka</th>
                        <th colspan="2">ISBN</th>
                    </tr>
                    
                    <?php
                        $zap = $pdo->prepare("select id from ksiazki order by id desc limit 1");
                        $zap->execute();
                        $wynik = $zap->fetch(PDO::FETCH_NUM);
                        $liczba_ksiazek = $wynik[0];
                        for($i = 1; $i <= $liczba_ksiazek; $i++){
                            //print_r($book = new Book($pdo, $i));
                            if($book = new Book($pdo, $i)){
                               $book->displayProductList(); 
                            }
                        }
                    ?>
                    
                </table>
                
            </div>
            <div class="col-md-3">


            </div>
        </row>
    </div>
</div>