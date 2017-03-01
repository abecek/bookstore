<?php
if(array_key_exists('action', $_POST)){
    if($_POST['action'] == 'addbook'){
        if($book = new Book($pdo,$_POST)){
                $book->insert();
                $book->displayEdit();
            }  
    }
}
    $zap = $pdo->prepare("select count(id) from ksiazki");
    $zap->execute();
    $wynik = $zap->fetch(PDO::FETCH_NUM);
?>

<div class="single-product-area">
        <div class="zigzag-bottom">
	</div>
        <div class="container">
            <div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img src="http://localhost/books/public/covers/<?php print_r($wynik[0] + 1); ?>.jpg" style="width: 300px;" alt="">
                                    </div>
                                </div>             
                            </div>
                            <div class="col-sm-6">
                                <div class="product-inner">
                
            <form action="" method="POST">
            <input type="hidden" name="action" value="addbook">
                <table> 
                        <tr>
                        <td>ID:</td>
                        <td>
                            <?php print_r($wynik[0] + 1); ?>
                        </td>
                        </tr>
         		<tr>
                        <td>Tytuł</td><td>
				<input type="text" name="title" value="">	
						</td>
					</tr>
					<tr>
                        <td>ID Wydawnictwa</td><td>
                            <input type="text" name="publication_id" value="">		
						</td>
					</tr>
					<tr>
                        <td>Rok wydania</td><td>
                            <input type="text" name="publication_date" value="">		
						</td>
					</tr>
					<tr>
                        <td>Książek na stanie</td><td>
                            <input type="text" name="count" value="">		
						</td>
					</tr>
					<tr>
                        <td>Cena</td><td>
				<input type="text" name="price" value="">		
						</td>
                                        </tr>
                                        <tr>
                        <td>Okładka</td><td>
				<input type="text" name="is_hard" value="">		
						</td>
					</tr>
					<tr>
                        <td>Strony</td><td>
				<input type="text" name="pages" value="">		
						</td>
					</tr>
					<tr>
                        <td>Obniżka</td><td>
				<input type="text" name="reduction" value="">		
						</td>
					</tr>
					<tr>
                        <td>ISBN</td><td>
				<input type="text" name="isbn" value="">		
			</td>
                                        </tr>
                                        <tr>
                        <td>Opis</td><td>
				<input type="text" name="description" value="">		
			</td>
                    </tr>
		</table>
                <hr>
                <input type="submit" value="Zatwierdź" />
            </form>

                </div>
            </div>
        </div>
    </div>
</div>

