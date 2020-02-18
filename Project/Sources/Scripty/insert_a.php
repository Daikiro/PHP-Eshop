<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=7" />
</HEAD>

<?php
require("../../../connect.php");

//$salt = "asd44153413sa4d6a";
//$password = $_POST['heslo'].$salt;
//$password = hash('sha256', $_POST['heslo']);
$password = hash('sha512', $_POST['heslo']);


$sql = "INSERT INTO UCET (Login,Heslo,Opravneni,Zalozeni) values ('$_POST[login]','$password','$_POST[opravneni]','$_POST[zalozeni]')";

mysqli_query($spojeni, $sql);

mysqli_close($spojeni);

?>












