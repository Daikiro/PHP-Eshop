<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=3" />
</HEAD>
<?php
require("../../../connect.php");

$sql = "DELETE FROM OBJEKT WHERE Id='$_POST[idcko]'";
mysqli_query($spojeni, $sql);

mysqli_close($spojeni);
?>