    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Produkty</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
               <?php                   
                    $zap = $pdo->prepare("select count(id) from ksiazki");
                    $zap->execute();
                    $wynik = $zap->fetch(PDO::FETCH_NUM);
                    
                    $limit = 40; 
                    $allpages = ceil($wynik[0] / $limit);
                    
                    if(isset($_GET['s2']) && is_numeric($_GET['s2'])){
                        $page = $_GET['s2'] - 1;
                    }
                    else{
                        $page = 0;
                    }
                    $from = $page * $limit;
                    
                    $zap2 = $pdo->prepare("select id from ksiazki ORDER by 1 asc limit :page,:lim");
                    $zap2->bindValue(":page", $from, PDO::PARAM_INT);
                    $zap2->bindValue(":lim", $limit, PDO::PARAM_INT);
                    $zap2->execute();
                    
                    while($row = $zap2->fetch(PDO::FETCH_ASSOC)){
                        $book = new Book($pdo, $row['id']);
                        $book->displayProductSmall();
                    }
                ?>
                
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="product-pagination text-center">
                        <nav>
                          <ul class="pagination">
                            <li>
                              <a href="<?php 
                                $new = $_GET['s2'] - 1;
                                if ($new <= 0) $new = 1;
                                echo 'http://localhost/books/shop/'.$new;
                              ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                              </a>
                            </li>
                            <?php
                                for($page = 1; $page <= $allpages; $page++){
                                    echo '<li><a href="http://localhost/books/shop/'.$page.'">'.$page.'</a></li>';
                                }
                            ?>
                            <li>
                              <a href="
                                 <?php 
                                 $new = $_GET['s2'] + 1;
                                 if ($new >= $allpages) $new = $allpages;
                                echo 'http://localhost/books/shop/'.$new;
                              ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                              </a>
                            </li>
                          </ul>
                        </nav>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
