<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=2" />
</HEAD>

<?php
require("../../../connect.php");


$sql = "INSERT INTO AUTOR (Jmeno,Cele_jmeno) values('$_POST[jmeno_autor]','$_POST[cele_jmeno_autor]')";

mysqli_query($spojeni, $sql);

mysqli_close($spojeni);
?>