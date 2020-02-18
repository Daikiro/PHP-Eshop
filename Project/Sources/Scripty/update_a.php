<HEAD>
<meta http-equiv="refresh" content="0;url=../../Public/index.php?a=7" />
</HEAD>
<?php
require("../../../connect.php");
  
  
  
  if ($_POST[rc]=='bez_vlastnika')
  {
    if ($_POST['heslo'] == "")
        $sql = "UPDATE UCET SET Login = '$_POST[login]', Rc = null, Opravneni = '$_POST[opravneni]', Zalozeni = '$_POST[datum]' WHERE Login='$_POST[puvodni_login]'";
    else
    {
        $password = hash('sha512', $_POST['heslo']);
        $sql = "UPDATE UCET SET Login = '$_POST[login]', Heslo = '$password', Rc = null, Opravneni = '$_POST[opravneni]', Zalozeni = '$_POST[datum]' WHERE Login='$_POST[puvodni_login]'";
    }
  }
    
        
  else
  {
    if ($_POST['heslo'] == "")
        $sql = "UPDATE UCET SET Login = '$_POST[login]', Rc = '$_POST[rc]', Opravneni = '$_POST[opravneni]', Zalozeni = '$_POST[datum]' WHERE Login='$_POST[puvodni_login]'";
    else
    {
        $password = hash('sha512', $_POST['heslo']);
        $sql = "UPDATE UCET SET Login = '$_POST[login]', Heslo = '$password', Rc = '$_POST[rc]', Opravneni = '$_POST[opravneni]', Zalozeni = '$_POST[datum]' WHERE Login='$_POST[puvodni_login]'";
    }
        
  }
    
        
        
  mysqli_query($spojeni, $sql);
  
  mysqli_close($spojeni);
  $idcko = NULL;
?>



