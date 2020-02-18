<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=2" />
</HEAD>

<?php
require("../../../connect.php");


    $sql = "SELECT Id FROM KNIHA ORDER BY Id ASC";
    $counter = 1;
    $vysledek = mysqli_query($spojeni, $sql);
    while ($radek = mysqli_fetch_assoc($vysledek)):
    {
        if ($radek['Id'] != $counter)
        break;
        $counter ++;
    }
    endwhile;

if ($_POST[spoluautor] == "bez_autora" || $_POST[spoluautor] == $_POST[autor])
    $sql = "INSERT INTO KNIHA (Id,Nazev,Autor,Kategorie,Jazyk,Cena,Vazba,Rok_vydani,Vydal,Stav) values('$counter', '$_POST[nazev]','$_POST[autor]','$_POST[kategorie]','$_POST[jazyk]','$_POST[cena]','$_POST[vazba]','$_POST[rok_vydani]','$_POST[vydal]','$_POST[stav]')";
else
    $sql = "INSERT INTO KNIHA (Id,Nazev,Autor,Spoluautor,Kategorie,Jazyk,Cena,Vazba,Rok_vydani,Vydal,Stav) values('$counter','$_POST[nazev]','$_POST[autor]','$_POST[spoluautor]','$_POST[kategorie]','$_POST[jazyk]','$_POST[cena]','$_POST[vazba]','$_POST[rok_vydani]','$_POST[vydal]','$_POST[stav]')";

mysqli_query($spojeni, $sql);

mysqli_close($spojeni);
?>












