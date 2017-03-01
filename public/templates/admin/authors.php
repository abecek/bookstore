<?php
    if(array_key_exists('action', $_POST)){
        if($_POST['action'] == 'editauthor'){
            $zap = $pdo->prepare('UPDATE autorzy SET nazwa=? WHERE id=?');
            $zap->execute(array($_POST['name'],$_POST['id']));
        }
    }
?>   

    <div class="container">
        <row>
            <div class="col-md-12">
                <div class="user-menu">
                    <ul>
                        <li><a href="http://localhost/books/newauthor"><i class="fa"></i>Nowy autor</a></li>
                    </ul>
                </div>
            </div>
        </row>
        <row>
            <?php
            if (isset($_GET['s2']) && is_numeric($_GET['s2'])) { 
                $zap = $pdo->prepare("select * from autorzy where id=?");
                $zap->execute(array($_GET['s2']));
                $wynik = $zap->fetch(PDO::FETCH_ASSOC);
                echo '<form action="" method="POST">
                    <input type="hidden" name="action" value="editauthor">
                    <input type="hidden" name="id" value="'.$_GET['s2'].'">
                        <table> 
                                <tr>
                                <td>Nazwa: </td>
                                    <td>
                                    <input type="text" name="name" value="'.$wynik['nazwa'].'">	
                                    </td>
                                </tr>
                        </table>
                        <hr>
                        <input type="submit" value="Zatwierdź" />
                </form>';
            }
            else{
                echo '<div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>
                                ID
                            </th>
                            <th colspan="2">
                                Nazwa
                            </th>
                        </tr>';

                            $zap = $pdo->prepare("select * from autorzy order by id desc");
                            $zap->execute();
                            $wynik = $zap->fetchAll(PDO::FETCH_ASSOC);
                            foreach($wynik as $autor){
                                echo '<tr>
                                    <td>'.$autor['id'].'</td>
                                    <td>'.$autor['nazwa'].'</td>
                                    <td>
                                    <a href="http://localhost/books/authors/'.$autor['id'].'">
                                        Edytuj
                                    </a>
                                    </td>
                                </tr>';
                            }
                            
                echo '         
                    </table>
                </div>';
            }
            
            ?>
        </row>
    </div>
