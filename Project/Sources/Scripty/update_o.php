<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=3" />
</HEAD>

<?php
require("../../../connect.php");
 
if ($_POST[vyrazeno] == 1 && $_POST[datum_vyrazeni] == "" )  
    $sql = "UPDATE OBJEKT SET Nazev = '$_POST[nazev]', Druh_majetku = '$_POST[druh_majetku]', Zarucni_doba = '$_POST[zarucni_doba]', Cena = '$_POST[cena]', Datum_porizeni = '$_POST[datum_porizeni]', Datum_vyrazeni = '".date('Y-m-d')."', Vyrazeno = '$_POST[vyrazeno]', Pocet_kusu = '$_POST[pocet_kusu]', Prodejce = '$_POST[prodejce]' WHERE ID='$_POST[idcko]'";
else if ($_POST[vyrazeno] == 1 && $_POST[datum_vyrazeni] != null )
    $sql = "UPDATE OBJEKT SET Nazev = '$_POST[nazev]', Druh_majetku = '$_POST[druh_majetku]', Zarucni_doba = '$_POST[zarucni_doba]', Cena = '$_POST[cena]', Datum_porizeni = '$_POST[datum_porizeni]', Datum_vyrazeni = '$_POST[datum_vyrazeni]', Vyrazeno = '$_POST[vyrazeno]', Pocet_kusu = '$_POST[pocet_kusu]', Prodejce = '$_POST[prodejce]' WHERE ID='$_POST[idcko]'";
else
    $sql = "UPDATE OBJEKT SET Nazev = '$_POST[nazev]', Druh_majetku = '$_POST[druh_majetku]', Zarucni_doba = '$_POST[zarucni_doba]', Cena = '$_POST[cena]', Datum_porizeni = '$_POST[datum_porizeni]', Datum_vyrazeni = NULL, Vyrazeno = 0, Pocet_kusu = '$_POST[pocet_kusu]', Prodejce = '$_POST[prodejce]' WHERE ID='$_POST[idcko]'";

mysqli_query($spojeni, $sql);


mysqli_close($spojeni);
$idcko = NULL;
?>



