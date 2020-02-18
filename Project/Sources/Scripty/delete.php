<?php
require("../../../connect.php");

    if ($_POST[zdroj] == "ucetnictvi")
    {
     // Vybere id faktury, které je pøiøazena daná kniha
     $sql_up = "SELECT Id_faktury FROM FINANCE WHERE Id_knihy = '$_POST[idcko]'";
     $vysledek = mysqli_query($spojeni, $sql_up);
     $radek = mysqli_fetch_assoc($vysledek);
    
     // Smazání pøiøazené faktury
     $sql = "DELETE FROM FINANCE WHERE Id_faktury='$radek[Id_faktury]'";
     $vysledek = mysqli_query($spojeni, $sql); 
     }


     $sql = "DELETE FROM KNIHA WHERE Id='$_POST[idcko]'";
     mysqli_query($spojeni, $sql);

     mysqli_close($spojeni);



     if ($_POST[zdroj] == "kniha")
        header("Location: ../../Public/index.php?a=2");
     if ($_POST[zdroj] == "ucetnictvi")
        header("Location: ../../Public/index.php?a=4");
        
?>                              