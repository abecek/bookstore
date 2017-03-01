<?php
    if(array_key_exists('action', $_POST)){
        if($_POST['action'] == 'editpublisher'){
            $zap = $pdo->prepare('UPDATE wydawnictwa SET nazwa=? WHERE id=?');
            $zap->execute(array($_POST['name'],$_POST['id']));
        }
    }
?>   

    <div class="container">
        <row>
            <div class="col-md-12">
                <div class="user-menu">
                    <ul>
                        <li><a href="http://localhost/books/newpublisher"><i class="fa"></i>Nowe wydawnictwo</a></li>
                    </ul>
                </div>
            </div>
        </row>
        <row>
            <?php
            if (isset($_GET['s2']) && is_numeric($_GET['s2'])) { 
                $zap = $pdo->prepare("select * from wydawnictwa where id=?");
                $zap->execute(array($_GET['s2']));
                $wynik = $zap->fetch(PDO::FETCH_ASSOC);
                echo '<form action="" method="POST">
                    <input type="hidden" name="action" value="editpublisher">
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

                            $zap = $pdo->prepare("select * from wydawnictwa order by id desc");
                            $zap->execute();
                            $wynik = $zap->fetchAll(PDO::FETCH_ASSOC);
                            foreach($wynik as $wyd){
                                echo '<tr>
                                    <td>'.$wyd['id'].'</td>
                                    <td>'.$wyd['nazwa'].'</td>
                                    <td>
                                    <a href="http://localhost/books/publishers/'.$wyd['id'].'">
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
