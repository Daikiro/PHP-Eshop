<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=8" />
</HEAD>

<?php
require("../../../connect.php");

     $sql = "DELETE FROM NOVINKY WHERE Id_novinky='$_POST[idcko]'";
     mysqli_query($spojeni, $sql);

     mysqli_close($spojeni);
        
?>                              