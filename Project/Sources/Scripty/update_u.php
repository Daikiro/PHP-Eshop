    <HEAD>
    <meta http-equiv="refresh" content="0;url=../../Public/index.php?a=5" />
    </HEAD>

    <?php
    
    require("../../../connect.php");

    if ($_POST[rccko_new] != $_POST[rccko])
    {
    
        // Vybere ��et, kter�mu je p�i�azen dan� zam�stnanec
        $sql_up = "SELECT * FROM UCET NATURAL JOIN ZAMESTNANEC WHERE Rc = '$_POST[rccko]'";
        $vysledek = mysqli_query($spojeni, $sql_up);
        $radek = mysqli_fetch_assoc($vysledek);
    
        // Nahrad� rodn� ��slo hodnotou NULL aby se rc mohlo p�epsat
        $sql_up = "UPDATE UCET SET Rc = NULL WHERE Login ='$radek[Login]'";
        $vysledek = mysqli_query($spojeni, $sql_up);  
    
        // P�eps�n� rodn�ho ��sla
        $sql_up = "UPDATE ZAMESTNANEC SET Rc = '$_POST[rccko_new]', Jmeno = '$_POST[jmeno]', Adresa = '$_POST[adresa]', Mesto = '$_POST[mesto]', Psc = '$_POST[psc]' , Email = '$_POST[email]', Telefon = '$_POST[telefon]', Datum_prijeti ='$_POST[datum_prijeti]' WHERE Rc='$_POST[rccko]'";
        mysqli_query($spojeni, $sql_up);
    
        // Navr�cen� ��tu u�ivateli pod nov�m rodn�m ��slem
        $sql_up = "UPDATE UCET SET Rc = '$_POST[rccko_new]' WHERE Login ='$radek[Login]'";
        $vysledek = mysqli_query($spojeni, $sql_up);
    }
    else
    {    
        // Z�pis bez zm�ny rodn�ho ��sla
        $sql_u = "UPDATE ZAMESTNANEC SET Rc = '$_POST[rccko]', Jmeno = '$_POST[jmeno]', Adresa = '$_POST[adresa]', Mesto = '$_POST[mesto]', Psc = '$_POST[psc]' , Email = '$_POST[email]', Telefon = '$_POST[telefon]', Datum_prijeti ='$_POST[datum_prijeti]' WHERE Rc='$_POST[rccko]'";
        mysqli_query($spojeni, $sql_u);
    }
    
    mysqli_close($spojeni);
    ?>



