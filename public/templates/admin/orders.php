<div class="container">
    
    <row>
            <div class="col-md-12">
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>ID</th>
                        <th>ID KLIENTA</th>
                        <th>KLIENT</th>
                        <th>ADRES</th>
                        <th>ID STATUSU</th>
                        <th>STATUS</th>
                        <th>DATA</th>
                        <th>CENA CAŁKOWITWA</th>
                        <th>KSIAZKI</th>
                    </tr>
                    
                    <?php
                   
                        $zap = $pdo->prepare("select z.id, z.id_klienta, z.id_statusu, s.nazwa, o.id_adresu, z.data_zakupu, z.cena from zamowienia z left join osoby o on z.id_klienta = o.id left join statusy s on z.id_statusu = s.id");
                        $zap->execute();
                        $wynik = $zap->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach($wynik as $order){
                            $zap2 = $pdo->prepare("select * from adres where id = ?");
                            $zap2->execute(array($order['id_adresu']));
                            $wynik2 = $zap2->fetch(PDO::FETCH_ASSOC);
                            
                            
                            $zap3 = $pdo->prepare("select * from ksiazki_w_zamowieniach where id_zamowienia = ?");
                            $zap3->execute(array($order['id']));
                            $wynik3 = $zap3->fetchAll(PDO::FETCH_ASSOC);
                            
                            
                            
                            echo '<tr>
                                    <td>'.$order['id'].'</td>
                                    <td>'.$order['id_klienta'].'</td>
                                    <td>'.$wynik2['imie'].' '.$wynik2['nazwisko'].'</td>
                                    <td>'.$wynik2['miejscowosc'].' '.$wynik2['kod_poczt'].' '.$wynik2['ulica'].' '.$wynik2['nr_domu'].' '.$wynik2['nr_lokalu'].' '.$wynik2['telefon'].'</td>
                                    <td>'.$order['id_statusu'].'</td>
                                    <td>'.$order['nazwa'].'</td>
                                    <td>'.$order['data_zakupu'].'</td>
                                    <td>'.$order['cena'].'</td>
                                    <td>';
                            
                                    foreach($wynik3 as $book){
                                        echo 'ID Ksiazki: '.$book['id_ksiazki'].' , ilosc: '.$book['liczba_ksiazek'].' , cena jednostkowa: '.$book['cena'].' <br>';
                                    }
                                    echo '</td>
                                </tr>';
                        }
                    ?>
                </table>
                
            </div>
    </row>
</div>