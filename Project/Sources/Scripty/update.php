<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=2" />
</HEAD>
<?php
require("../../../connect.php");


if ($_POST[spoluautor] == "bez_autora" || $_POST[spoluautor] == $_POST[autor])  
    $sql = "UPDATE KNIHA SET Nazev = '$_POST[nazev]', Autor = '$_POST[autor]', Spoluautor = null, Kategorie = '$_POST[kategorie]', Jazyk = '$_POST[jazyk]', Cena = '$_POST[cena]', Vazba = '$_POST[vazba]', Rok_vydani= '$_POST[rok_vydani]', Vydal = '$_POST[vydal]', Stav = '$_POST[stav]' WHERE Id='$_POST[idcko]'";
else
    $sql = "UPDATE KNIHA SET Nazev = '$_POST[nazev]', Autor = '$_POST[autor]', Spoluautor = '$_POST[spoluautor]', Kategorie = '$_POST[kategorie]', Jazyk = '$_POST[jazyk]', Cena = '$_POST[cena]', Vazba = '$_POST[vazba]', Rok_vydani= '$_POST[rok_vydani]', Vydal = '$_POST[vydal]', Stav = '$_POST[stav]' WHERE Id='$_POST[idcko]'";  
  
  
mysqli_query($spojeni, $sql);
  
 
mysqli_close($spojeni);
$idcko = NULL;
?>



