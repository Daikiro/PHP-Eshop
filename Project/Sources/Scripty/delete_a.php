<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=7" />
</HEAD>
<?php
require("../../../connect.php");

$sql = "DELETE FROM UCET WHERE Login='$_POST[login]'";
mysqli_query($spojeni, $sql);

mysqli_close($spojeni);
?>