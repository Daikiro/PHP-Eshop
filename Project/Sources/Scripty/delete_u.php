<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=5" />
</HEAD>
<?php
require("../../../connect.php");

        // Vybere úèet, kterému je pøiøazen daný zamìstnanec
        $sql_up = "SELECT Login FROM UCET NATURAL JOIN ZAMESTNANEC WHERE Rc = '$_POST[rccko]'";
        $vysledek = mysqli_query($spojeni, $sql_up);
        $radek = mysqli_fetch_assoc($vysledek);
        
        // Nahradí rodné èíslo hodnotou NULL aby se rc mohlo pøepsat
        $sql_up = "UPDATE UCET SET Rc = NULL WHERE Login ='$radek[Login]'";
        $vysledek = mysqli_query($spojeni, $sql_up); 

        $sql = "DELETE FROM ZAMESTNANEC WHERE Rc='$_POST[rccko]'";
        mysqli_query($spojeni, $sql);

        mysqli_close($spojeni);
?>