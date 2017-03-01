<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Book
 *
 * @author Michal
 */
class Book {
    //put your code here
    protected $id;
    protected $title;
    protected $publication_id;
    protected $publication_date;
    protected $count;
    protected $description;
    protected $price;
    protected $is_hard;
    protected $pages;
    protected $reduction;
    protected $isbn;
    
    protected $quantity;
    
    protected $authors;
    protected $categories;
   
    protected $comments; //to do
    
    public function __construct($pdo, $data, $quantity = null){
        $this->pdo = $pdo;
      
        if (isset($data) && is_numeric($data)){    
            $zap = $this->pdo->prepare("SELECT * FROM ksiazki WHERE id = :id");
            $zap->bindValue(":id", $data, PDO::PARAM_INT);
            $zap->execute();
            $wynik = $zap->fetch(PDO::FETCH_BOTH);
            
            if(!empty($wynik)){
                $this->id = $wynik['id'];
                $this->title = $wynik['tytul'];
                $this->publication_id = $wynik['id_wydawnictwa'];
                $this->publication_date = $wynik['rok_wyd'];
                $this->count = $wynik['liczba_ksiazek'];
                $this->description = $wynik['opis'];
                $this->price = $wynik['cena'];
                $this->is_hard = $wynik['czy_twarda'];
                $this->pages = $wynik['strony'];
                $this->reduction = $wynik['obnizka'];
                $this->isbn = $wynik['isbn'];
                
                if($quantity !=  null) $this->quantity = $quantity;
                else $this->quantity = 1;

                $zap2 = $this->pdo->prepare("SELECT a.id, a.nazwa 
                                            from autorzy a left join autorzy_ksiazek ak on a.id = ak.id_autora
                                            WHERE ak.id_ksiazki = ?
                                            order by 2 asc");
		$zap2->execute(array($this->id));
                $this->authors = $zap2->fetchAll(PDO::FETCH_ASSOC);
                
                $zap3 = $this->pdo->prepare("select k.id, k.nazwa 
                                            from kategorie k join kategorie_ksiazek kk on k.id = kk.id_kategorii 
                                            where kk.id_ksiazki = ?
                                            order by 1 asc;");
		$zap3->execute(array($this->id));
                $this->categories = $zap3->fetchAll(PDO::FETCH_ASSOC);
                
                $zap4 = $this->pdo->prepare("select * from user_rating where id_ksiazki=?");
                $zap4->execute(array($this->id));
                $this->comments = $zap4->fetchAll(PDO::FETCH_ASSOC);
                
                return true;
            }
            else{
                return false;
            }
        }
        elseif(is_array($data)){
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->publication_id = $data['publication_id'];
            $this->publication_date = $data['publication_date'];
            $this->count = $data['count'];
            $this->description = $data['description'];
            $this->price = $data['price'];
            $this->is_hard = $data['is_hard'];
            $this->pages = $data['pages'];
            $this->reduction = $data['reduction'];
            $this->isbn = $data['isbn'];
            $this->quantity = $data['quantity'];
            
            $this->authors = $data['authors'];
            $this->categories = $data['categories'];
            
            $this->comments = $data['comments'];
            
            return true;
        }
        return false;
    }
    
    public function update(){
        $zap = $this->pdo->prepare('UPDATE ksiazki SET tytul=?, id_wydawnictwa=?, rok_wyd=?, liczba_ksiazek=?, opis=?, cena=?, czy_twarda=?, strony=?, obnizka=?, isbn=? WHERE id=?');
	$zap->execute(array(
            $this->title, 
            $this->publication_id, 
            $this->publication_date,
            $this->count,
            $this->description,
            $this->price,
            $this->is_hard,
            $this->pages,
            $this->reduction,
            $this->isbn,
            $this->id));
    }
    
    public function insert(){
        $zap = $this->pdo->prepare('INSERT INTO ksiazki(tytul, id_wydawnictwa, rok_wyd, liczba_ksiazek, opis, cena, czy_twarda, strony, obnizka, isbn) VALUES(?,?,?,?,?,?,?,?,?,?)');
	$zap->execute(array(
            $this->title, 
            $this->publication_id, 
            $this->publication_date,
            $this->count,
            $this->description,
            $this->price,
            $this->is_hard,
            $this->pages,
            $this->reduction,
            $this->isbn,
                ));
    }
    
    public function delete(){
        $zap = $this->pdo->prepare('DELETE FROM ksiazki WHERE id=?');
	$zap->execute(array($this->id));   
    }
    
    public function isBoughtByUser(){
        $zap = $this->pdo->prepare("select k.id_ksiazki from ksiazki_w_zamowieniach k join zamowienia z on k.id_zamowienia = z.id where z.id_klienta = ?");
        $zap->execute(array($_SESSION['user']));
        $wynik = $zap->fetchAll(PDO::FETCH_ASSOC);
        $flag = false;
        
        foreach($wynik as $book){
            if($this->id == $book['id_ksiazki']){
                $flag = true;
            }
        }
        
        if($flag) return true;
        else return false;
    }
    
    public function hasUserOpinion(){
        if($this->isBoughtByUser()){
            $zap = $this->pdo->prepare("select id from user_rating where id_osoby=? and id_ksiazki=?");
            $zap->execute(array($_SESSION['user'], $this->id));
            $wynik = $zap->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($wynik) > 0 ) return true;
            else return false;
        }
        else return false;
    }
    
    public function addOpinion($data){
        if($data['ocena'] == 0) $data['ocena'] = 1;
        if(!$this->hasUserOpinion()){
            $zap = $this->pdo->prepare('INSERT INTO `user_rating` (`id_osoby`, `id_ksiazki`, `ocena`, `komentarz`, `name`) VALUES (?, ?, ?, ?,?)');
                $zap->execute(array(
                    $_SESSION['user'],
                    $this->id,
                    $data['ocena'],
                    $data['opinia'],
                    $data['pseudonim']             
            ));
        }
    }
    
    public function editOpinion($data){
        if($data['ocena'] == 0) $data['ocena'] += 1;
        $zap = $this->pdo->prepare('UPDATE user_rating SET ocena=?, komentarz=?, name=? WHERE id_osoby=? AND id_ksiazki=?');
	$zap->execute(array(
            $data['ocena'],
            $data['opinia'],
            $data['pseudonim'],
            $_SESSION['user'],
            $this->id));
    }
    
    public function getUserOpinion($id){
        $zap = $this->pdo->prepare("select * from user_rating where id_osoby=? and id_ksiazki=?");
        $zap->execute(array($_SESSION['user'], $this->id));
        $wynik = $zap->fetch(PDO::FETCH_ASSOC);
        
        return $wynik;
    }
    
    public function displayProduct(){
    //SCIEZKA
    echo '    
    <div class="single-product-area">
        <div class="zigzag-bottom">
		</div>
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="product-breadcroumb">
        
        <a href="http://localhost/books/categories">Kategorie</a>';
                          // <a href="">Category Name</a> 
                    echo '  <a href="http://localhost/books/product/'.$this->id.'">'.$this->title.'</a>
                    </div>';
        //OKLADKA         
        echo '<div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="http://localhost/books/public/covers/'.
                                        $this->id
                                        .'.jpg" style="width: 400px; height: 550px" alt="">
                                    </div>
                                </div>
                            </div>';
        
        echo '
                            <div class="col-sm-6">
                                <div class="product-inner">
                                    <h2 class="product-name">'.$this->title.'</h2>
                                    <div class="product-inner-price">
                                        <h3><ins>'.$this->price.' zł</ins></h3>
                                    </div>    
                                    ';
        echo '
                                    <form method="POST" class="cart">
                                        <input type="hidden" name="action" value="addToCart"> 
                                        <input type="hidden" name="id" value="'.$this->id.'">
                                        <input type="hidden" name="price" value="'.$this->price.'"> 
                                        <div class="quantity">
                                            <input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="quantity" min="1" step="1">
                                        </div>
                                        <button class="add_to_cart_button" type="submit">Dodaj do koszyka</button>
                                    </form>   
                                    ';
        echo 'Dostępność: '; 
        if($this->quantity > 0){
            echo 'Na stanie.';
        }
        else{
            echo 'Brak.';
        }
        echo '
                                    <div class="product-inner-category">
                                        <p>Kategoria: ';
                
                $i = 0;
                while(array_key_exists($i, $this->categories)){
                    echo '<a href="http://localhost/books/categories/'.$this->categories[$i]['id'].'">'.$this->categories[$i]['nazwa'].'</a>  &nbsp';
                    $i++ ;
                }
                
        echo                            '. 
                                    </div> 
                                    ';
        echo '
                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active">
                                            <a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                                            Opis
                                            </a>
                                            </li>';
        //if(!empty($this->comments)){
          echo '  
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Opinie</a></li>
               ';
        //}
        echo '             
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                <h2>Opis książki</h2>  
                                                <p>
                                                '.$this->description.'
                                                </p>
                                        </div>';
            
        
        echo '
                                            <div role="tabpanel" class="tab-pane fade" id="profile">
                ';   
        foreach($this->comments as $opinia){                
                echo '<div>
                        
                                <div class="rating-wrap-post" style="float: left;">
                                '.$opinia['name'].'  ';


                                for($i = 1 ; $i <= 5; $i++){
                                    if( $i <= $opinia['ocena']) echo '<i class="fa fa-star" style="color: yellow"></i>';
                                    else echo '<i class="fa fa-star" style="color: darkgrey"></i>';                               
                                } 
                    echo    '
                                </div>
                            
                                <div style="float: right; right: 0;">
                                    '.$opinia['czas'].'
                                </div>
                    </div>
                            <div style="clear:both;">
                                '.$opinia['komentarz'].'
                            </div>
                        ';
                echo '<hr>';
            }
        
        if(isLoggedIn()){   
            if($this->isBoughtByUser()){
                if(!$this->hasUserOpinion()){
                    echo '
                                                        <h2>Dodaj opinie</h2>
                                                            <div class="submit-review">
                                                                <form id="update_form" action="" method="POST">
                                                                    <input type="hidden" name="action" value="addOpinion"> 
                                                                    <input type="hidden" name="id_ksiazki" value="'.$this->id.'"> 
                                                                    <p><label for="name">Podpis</label> 
                                                                    <input name="pseudonim" type="text"></p>

                                                                    <div class="rating-chooser">
                                                                    <input id="ocena" type="hidden" name="ocena" value="0"> 
                                                                        <p>Ocena</p>
                                                                        <div class="rating-wrap-post">
                                                                            <i class="fa fa-star pierwsza" onclick="wystawOcene(1);" id="star1"></i>
                                                                            <i class="fa fa-star druga" onclick="wystawOcene(2);" id="star2"></i>
                                                                            <i class="fa fa-star trzecia" onclick="wystawOcene(3);" id="star3"></i>
                                                                            <i class="fa fa-star czwarta" onclick="wystawOcene(4);" id="star4"></i>
                                                                            <i class="fa fa-star piata" onclick="wystawOcene(5);" id="star5"></i>
                                                                        </div>
                                                                    </div>
                                                                    <p><label for="opinia">Opinia</label>
                                                                    <span id="liczba_znakow" style="color: green;">255</span>
                                                                    <textarea name="opinia" id="opinia" cols="30" rows="10" onkeyup="StringCount(255,`opinia`,`liczba_znakow`);"></textarea></p>
                                                                    <p><input type="submit" value="Wyślij"></p>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                </div>                    
                            </div>
                        </div>
                    </div>
                    </div>
                    ';
                }
                else{
                    $opinia = $this->getUserOpinion($_SESSION['user']);
                    echo '<h2>Edytuj swoją opinie</h2>
                                                            <div class="submit-review">
                                                                <form id="update_form" action="" method="POST">
                                                                    <input type="hidden" name="action" value="editOpinion"> 
                                                                    <input type="hidden" name="id_ksiazki" value="'.$this->id.'"> 
                                                                    <p><label for="name">Podpis</label> 
                                                                    <input name="pseudonim" type="text" value="'.$opinia['name'].'"></p>

                                                                    <div class="rating-chooser">
                                                                    <input id="ocena" type="hidden" name="ocena" value="'.$opinia['ocena'].'"> 
                                                                        <p>Ocena</p>
                                                                        <div class="rating-wrap-post">        
                            ';
                            for($i = 1; $i <= 5; $i++){
                                if($i <= $opinia['ocena']) echo '<i class="fa fa-star" onclick="wystawOcene('.$i.');" style="color:yellow;" id="star'.$i.'"></i>';
                                else echo '<i class="fa fa-star" onclick="wystawOcene('.$i.');" id="star'.$i.'"></i>';  
                            }
                    echo '
                            </div>
                                                                    </div>
                                                                    <p><label for="opinia">Opinia</label>
                                                                    <span id="liczba_znakow" style="color: green;"></span>
                                                                    <textarea name="opinia" id="opinia" cols="30" rows="10" onkeyup="StringCount(255,`opinia`,`liczba_znakow`);">'.$opinia['komentarz'].'</textarea></p>
                                                                    <p><input type="submit" value="Wyślij"></p>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                </div>                    
                            </div>
                        </div>
                    </div>
                    </div>';
                }
            }
            else{
                echo 'Żeby móc wystawić opinie, musisz wcześniej zakupić powyższą ksiażke. </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    </div>
                            </div>                    
                        </div>
                    </div>
                </div>
                </div>
                ';
            }
        }
        else{
            echo 'By móc dodać opinie, musisz być zalogowany i kupić daną książke.</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    </div>
                            </div>                    
                        </div>
                    </div>
                </div>
                </div>
                ';
        }
    }
    
    public function displayProductSmall(){
        echo '
            <div class="col-md-3 col-sm-6">
                        <div class="single-shop-product">
                            <div class="product-upper">
                                <img src="http://localhost/books/public/covers/'.$this->id.'.jpg" style="width: 250px; height: 350px" alt="cover">
                            </div>
                            <h2><a href="http://localhost/books/product/'.$this->id.'">'.$this->title.'</a></h2>
                            <div class="product-carousel-price">
                                <ins>'.$this->price.' zł</ins>
                            </div>  

                            <div class="product-option-shop">
                                <a class="add_to_cart_button" onclick="addItem('.$this->id.', '.$this->quantity.', '.$this->price.')" rel="nofollow" href="">Dodaj do koszyka</a>
                            </div>                       
                        </div>
            </div>
        ';
    }
    
    public function displayProductMini(){
            echo '
                        <div class="single-wid-product">
                            <a href="single-product.html"><img src="http://localhost/books/public/covers/'.$this->id.'.jpg" alt="" class="product-thumb"></a>
                            <h2><a href="http://localhost/books/product/'.$this->id.'">'.$this->title.'</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>'.$this->price.' zł</ins>
                            </div>                            
                        </div>
                        ';
    }
    
    public function displayEdit(){
        echo '
        
        <div class="container">
            <row>
                <div class="col-md-12">
                    <h1>Edycja</h1>
                    <hr>
                </div>
            </row>
            <row>
            <div class="col-md-6">
            <h2>Zdjęcie</h2>
            <img src="http://localhost/books/public/covers/'.
                $this->id
                .'.jpg" style="width: 350px;" alt="">
            </div>
            <div class="col-md-6">
            <h2>Dane</h2>
            <form action="" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="'.$this->id.'">
                <table> 
                        <tr>
                        <td>ID:</td>
                        <td>'.$this->id.'</td>
                        </tr>
         		<tr>
                        <td>Tytuł</td><td>
                                <textarea name="title" style="width:350px;">'.$this->title.'</textarea>
						</td>
					</tr>
					<tr>
                        <td>ID Wydawnictwa</td><td>
                            <input type="text" name="publication_id" value="'.$this->publication_id.'">		
						</td>
					</tr>
					<tr>
                        <td>Rok wydania</td><td>
                            <input type="text" name="publication_date" value="'.$this->publication_date.'">		
						</td>
					</tr>
					<tr>
                        <td>Książek na stanie</td><td>
                            <input type="text" name="count" value="'.$this->count.'">		
						</td>
					</tr>
					<tr>
                        <td>Cena</td><td>
				<input type="text" name="price" value="'.$this->price.'">		
						</td>
                                        </tr>
                                        <tr>
                        <td>Okładka</td><td>
				<input type="text" name="is_hard" value="'.$this->is_hard.'">		
						</td>
					</tr>
					<tr>
                        <td>Strony</td><td>
				<input type="text" name="pages" value="'.$this->pages.'">		
						</td>
					</tr>
					<tr>
                        <td>Obniżka</td><td>
				<input type="text" name="reduction" value="'.$this->reduction.'">		
						</td>
					</tr>
					<tr>
                        <td>ISBN</td><td>
				<input type="text" name="isbn" value="'.$this->isbn.'">		
			</td>
                                        </tr>
                                        <tr>
                        <td>Opis</td><td>
                                <textarea name="description" style="width:350px;height:200px;">'.$this->description.'</textarea>
			</td>
                    </tr>
		</table>
                <hr>
                <input type="submit" value="Zatwierdź" />
            </form>
            
            <form action="http://localhost/books/products" method="POST">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="'.$this->id.'">
                <input type="submit" value="Usuń" />
            </form>
            
            </div
            </row>
        </div>
                ';

    }
    
    public function displayProductList(){
        echo '<tr>
                <td>
                '.$this->id.'
                </td>
                <td>
                '.$this->title.'
                </td>
                <td style="width: 150px;">
                <img src="http://localhost/books/public/covers/'.
                                        $this->id
                                        .'.jpg" style="width: 200px;" alt="">
                </td>
                <td>
                '.$this->publication_id.'
                </td>
                <td>
                '.$this->publication_date.'
                </td>
                <td>
                '.$this->count.'
                </td>
                <td>
                '.$this->price.'
                </td>
                <td>
                '.$this->is_hard.'
                </td>
                <td>
                '.$this->pages.'
                </td>
                <td>
                '.$this->reduction.'
                </td>
                <td>
                '.$this->isbn.'
                </td>
                <td>
                <a href="http://localhost/books/edit/'.$this->id.'">
                    Edytuj
                </a>
                </td>
            </tr>
        ';
    }
    
    public function displayCarouselItem(){
            echo '
                             <div class="single-product">
                                <div class="product-f-image">
                                    <img src="http://localhost/books/public/covers/'.$this->id.'.jpg" style="width:215px; height:265px" alt="">
                                    <div class="product-hover">
                                        <a href="http://localhost/books/cart/" onclick="addItem('.$this->id.', '.$this->quantity.', '.$this->price.')" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Dodaj do koszyka</a>
                                        
                                        <a href="http://localhost/books/product/'.$this->id.'" class="view-details-link"><i class="fa fa-link"></i> Sprawdź!</a>
                                    </div>
                                </div>
                                
                                <h2><a href="http://localhost/books/product/'.$this->id.'">'.$this->title.'</a></h2>
                                
                                <div class="product-carousel-price">
                                    <ins>'.$this->price.' zł</ins>
                                </div> 
                            </div>
                    ';
    }
    
    public function displayCartItem(){
        echo '<tr class="cart_item">
                                            <td class="product-remove">
                                                <a title="Usuń z koszyka" class="deleteItemFromCart" onclick="deleteItem('.$this->id.')" rel="nofollow" href="">×</a> 
                                            </td>

                                            <td class="product-thumbnail">
                                                <a href="http://localhost/books/product/'.$this->id.'"><img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="http://localhost/books/public/covers/'.$this->id.'.jpg"></a>
                                            </td>

                                            <td class="product-name">
                                                <a href="http://localhost/books/product/'.$this->id.'">'.$this->title.'</a> 
                                            </td>

                                            <td class="product-price">
                                                <span class="amount">'.$this->price.' zł</span> 
                                            </td>

                                            <td class="product-quantity">
                                                <div class="quantity buttons_added">
                                                    <input type="button" class="minus" onclick="minus('.$this->id.', '.$this->quantity.')" value="-">
                                                    <div id="'.$this->id.'"> 
                                                        '.$this->quantity.'
                                                    </div>
                                                    <input type="button" class="plus" onclick="plus('.$this->id.', '.$this->quantity.')" value="+">
                                                </div>
                                            </td>

                                            <td class="product-subtotal">
                                                <span class="amount">'.$this->price * $this->quantity.' zł</span> 
                                            </td>
                                        </tr>';
    }
    
    public function displayCartItemSmall(){
        echo '<tr class="cart_item">
                                                <td class="product-name">
                                                    '.$this->title.' <strong class="product-quantity">× '.$this->quantity.'</strong> </td>
                                                <td class="product-total">
                                                    <span class="amount">'.$this->price * $this->quantity.' zł</span> </td>
                                            </tr>';
    }
    
    public function displaySliderItem(){
        echo '
                                        <li>
                                            <div style="width:1163px; height:365px">
                                                <div style="position: relative; left: 150px; width:290px; height:365px">
						<img src="http://localhost/books/public/covers/'.$this->id.'.jpg" style="width:290px; height:365px" alt="Slide">
						</div>
                                                <div class="caption-group" style="float:right; width:290px; height:365px">
							<h4 class="caption title">
								'.$this->title.'
							</h4>
							<h5 class="caption subtitle">'.$this->price.'</h5>
							<a class="caption button-radius" href="http://localhost/books/product/'.$this->id.'"><span class="icon"></span>Kup teraz!</a>
						</div>
                                            </div>
					</li>
            ';
    }
    
    public function displayMini(){
                    echo '<div class="thubmnail-recent">
                            <img src="http://localhost/books/public/covers/'.$this->id.'.jpg" class="recent-thumb" alt="">
                            <h2><a href="single-product.html">'.$this->title.'5</a></h2>
                            <div class="product-sidebar-price">
                                <ins>'.$this->price.' zł</ins>
                            </div>                             
                        </div>';
    }
    
    public function displayOneLine(){
         echo '<li><a href="http://localhost/books/public/product/'.$this->id.'">'.$this->title.'</a></li>';
    }
    
}
