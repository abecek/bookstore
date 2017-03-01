<?php
if(array_key_exists('action', $_POST)){
    if($_POST['action'] == 'addpublisher'){
        $zap = $pdo->prepare("insert into wydawnictwa(id, nazwa) values(?,?)");
        $zap->execute(array($_POST['id'], $_POST['name']));
    }
}
    $zap = $pdo->prepare("select count(id) from wydawnictwa");
    $zap->execute();
    $wynik = $zap->fetch(PDO::FETCH_NUM);
?>

<div class="single-product-area">
        <div class="container">
            <div class="row">           
                <div class="col-sm-12">
                    <form action="" method="POST">
                    <input type="hidden" name="action" value="addpublisher">
                    
                        <table> 
                                <tr>
                                <td>ID: </td>
                                    <td>
                                        <?php
                                            $id = $wynik[0] + 1;
                                            echo '<input type="hidden" name="id" value="'.$id.'">';
                                            print_r($id); 
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                <td>Nazwa: </td>
                                    <td>
                                    <input type="text" name="name" value="">	
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

