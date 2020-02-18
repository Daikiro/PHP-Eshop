<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=8" />
</HEAD>

<?php
require("../../../connect.php");

// Vkládání nového èlánku
if ($_POST[identifikace_clanku] == "novy")
{
   $sql = "SELECT Id_novinky FROM NOVINKY ORDER BY Id_novinky ASC";
   $counter = 1;
   $vysledek = mysqli_query($spojeni, $sql);
   while ($radek = mysqli_fetch_assoc($vysledek)):
   {
    if ($radek['Id_novinky'] != $counter)
    break;
    $counter ++;
   }
   endwhile;
   
   $sql = "INSERT INTO NOVINKY (Id_novinky,Nadpis,Obsah,Datum_vytvoreni,Druh_novinek) values('$counter', '$_POST[nadpis]','$_POST[obsah]','".date('Y-m-d')."','$_POST[druh_clanku]')";
}

// Modifikace starého èlánku
if ($_POST[identifikace_clanku] == "stary")
{   
    $sql = "UPDATE NOVINKY SET Nadpis = '$_POST[nadpis]', Obsah = '$_POST[obsah]', Druh_novinek = '$_POST[druh_clanku]' WHERE Id_novinky='$_POST[ajdcko]'";

}



mysqli_query($spojeni, $sql);

mysqli_close($spojeni);
?>












