<div class="row">
    <div class="col-md-12">
        <table class="table-bordered table-hover table-striped">
            <tr>
                <th>
                    Numer Zamowienia
                </th>
                <th>
                    Status
                </th>
                <th>
                    Liczba Produktow
                </th>
                <th>
                    Cena
                </th>
                <th>
                    Data Zamowienia
                </th>
                <th>
                    Adress
                </th>
            </tr>

        <?php
            //print_r($_POST);
            
            if(!empty($_POST)){
                $adress = $_POST['imie'] .' '.$_POST['nazwisko'].' ';
                $adress .= 'ul. '.$_POST['ulica'] .' '.$_POST['nr_domu'].'/'.$_POST['nr_lokalu'].' ';
                $adress .= $_POST['kod_poczt'] .' '.$_POST['miejscowosc'].' ';
                $adress .= 'tel.'.$_POST['telefon'] .' ';
                $order = new Order($pdo, $cart, $adress);
                $order->addNew();
                
                $_SESSION['cart'] = null;
            }
            else{
                $zap = $pdo->prepare('SELECT * FROM zamowienia WHERE id_klienta=?');
                $zap->execute(array($_SESSION['user']));
                
                $wynik = $zap->fetchAll(PDO::FETCH_ASSOC);
                //$order = new Order($pdo, $cart);
                
                $order = null;
            }
            if($order == null) return;
                echo '
                <tr>
                    <td>
                        '.$order->getId().'
                    </td>
                    <td>
                        '.$order->getStatus().'
                    </td>
                    <td>
                        '.$order->getCount().'
                    </td>
                    <td>
                        '.$order->getPrice().'
                    </td>
                    <td>
                        '.$order->getDate().'
                    </td>
                    <td>
                        '.$order->getAdress().'
                    </td>
                </tr>'

           
        ?>
        </table>
        
    </div>
</div>