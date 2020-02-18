<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=5" />
</HEAD>

<?php
require("../../../connect.php");

$today = date("Y-m-d");

  $sql_u = "INSERT INTO ZAMESTNANEC (Rc,Jmeno,Adresa,Mesto,Psc,Email,Telefon,Datum_prijeti) values ('$_POST[rccko]','$_POST[jmeno]','$_POST[adresa]','$_POST[mesto]','$_POST[psc]','$_POST[email]','$_POST[telefon]','$_POST[datum_prijeti]')";
  mysqli_query($spojeni, $sql_u);


mysqli_close($spojeni);

?>












