<?php
  session_start();
  if ((!IsSet($_SESSION["user_is_logged"])) || $_SESSION["user_is_logged"] != 1)
    {
      header('Location: ../../login.php');
      exit();
    }
    
    /*
   if($_SESSION["alert"] == 0)
   {
   echo '<script> alert("Přihlášen uživatel: '.$_SESSION['user'].'")</script>';
   $_SESSION["alert"] += 1;
   }
    */
?>


<?php
  session_start();

  if(isset($_GET['a']))
  {
    $_SESSION["menu"]=$_GET['a'];
  }
  

  if ($_SESSION["menu"] == 1 || !isset($_SESSION["menu"]))
  {
    include("../Sources/Pages/Intra/menu.php");
  }
  if ($_SESSION["menu"] == 2)
  {
    include("../Sources/Pages/Intra/kniha.php");
  }
  if ($_SESSION["menu"] == 3)
  {
     include("../Sources/Pages/Intra/predmet.php");
  }
  if ($_SESSION["menu"] == 4)
  {
     include("../Sources/Pages/Intra/ucetnictvi.php");
  }
  if ($_SESSION["menu"] == 5)
  {
     include("../Sources/Pages/Intra/users.php");
  }
  if ($_SESSION["menu"] == 6)
  {
     $file="index_front.php";

      session_start();
      $_SESSION = array();
      session_destroy();
        if ($_SESSION["user_is_logged"])
        {
            echo "Kriticka chyba!";
        }
        else
        {
            header("Location: ".$file);
        }
   }
   if ($_SESSION["menu"] == 7)
  {
     include("../Sources/Pages/Intra/accounts.php");
  }
    if ($_SESSION["menu"] == 8)
  {
     include("../Sources/Pages/Intra/news.php");
  }



?>
