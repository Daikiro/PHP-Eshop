<?php
require("../connect.php");

  $sql_comm = "SELECT * FROM UCET";
  $vysledek = mysqli_query($spojeni, $sql_comm);
  $back="../login.php";
  $protected="./Public/index.php";
  $_SESSION["error"] = false;
  
  session_start();
  
  
                             
  if (mysqli_num_rows($vysledek) > 0)
    {
      while ($radek = mysqli_fetch_assoc($vysledek)):
        
        $password = hash('sha512', $_POST['passwd']);

        if(($_POST['user']== $radek["Login"])&&($password== $radek["Heslo"])&&($radek["Rc"] != null))
          {
            header("Cache-control: public");
            $_SESSION["user_is_logged"] = 1;
		    $_SESSION["user"] = $radek["Login"];
            $_SESSION["level"] = $radek["Opravneni"];
            $_SESSION["alert"] = 0;
            $_SESSION["menu"] = 1;
            header("Location:$protected");
            exit;
          }
      endwhile;
	 }


  mysqli_close($spojeni);

  $_SESSION["error"] = true;
  header("Location:$back");
  exit;
?>