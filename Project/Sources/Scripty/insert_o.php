<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=3" />
</HEAD>

<?php
require("../../../connect.php");

$sql = "SELECT Id FROM OBJEKT ORDER BY Id ASC";
    $counter = 1;
    $vysledek = mysqli_query($spojeni, $sql);
    while ($radek = mysqli_fetch_assoc($vysledek)):
    {
        if ($radek['Id'] != $counter)
        break;
        $counter ++;
    }
    endwhile;


if ($_POST[vyrazeno] == 0)
    $sql = "INSERT INTO OBJEKT (Id,Nazev,Druh_majetku,Zarucni_doba,Cena,Datum_porizeni,Datum_vyrazeni,Vyrazeno,Pocet_kusu,Prodejce) values('$counter','$_POST[nazev]','$_POST[druh_majetku]','$_POST[zarucni_doba]','$_POST[cena]','$_POST[datum_porizeni]',NULL,'$_POST[vyrazeno]','$_POST[pocet_kusu]','$_POST[prodejce]')";
else if ($_POST[vyrazeno] == 1 && $_POST[datum_vyrazeni] == "") 
    $sql = "INSERT INTO OBJEKT (Id,Nazev,Druh_majetku,Zarucni_doba,Cena,Datum_porizeni,Datum_vyrazeni,Vyrazeno,Pocet_kusu,Prodejce) values('$counter','$_POST[nazev]','$_POST[druh_majetku]','$_POST[zarucni_doba]','$_POST[cena]','$_POST[datum_porizeni]','".date('Y-m-d')."','$_POST[vyrazeno]','$_POST[pocet_kusu]','$_POST[prodejce]')";
else
    $sql = "INSERT INTO OBJEKT (Id,Nazev,Druh_majetku,Zarucni_doba,Cena,Datum_porizeni,Datum_vyrazeni,Vyrazeno,Pocet_kusu,Prodejce) values('$counter','$_POST[nazev]','$_POST[druh_majetku]','$_POST[zarucni_doba]','$_POST[cena]','$_POST[datum_porizeni]','$_POST[datum_vyrazeni]','$_POST[vyrazeno]','$_POST[pocet_kusu]','$_POST[prodejce]')";

mysqli_query($spojeni, $sql);

mysqli_close($spojeni);

?>












