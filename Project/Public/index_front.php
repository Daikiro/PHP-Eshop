<?php
  if(isset($_GET['b']))
  {
    $_SESSION["menu"]=$_GET['b'];
  }


  if ($_SESSION["menu"] == 1 || !isset($_SESSION["menu"]))
  {
    include("../Sources/Pages/Front/menu.php");
  }
  if ($_SESSION["menu"] == 2)
  {
    include("../Sources/Pages/Front/kniha.php");
  }
  if ($_SESSION["menu"] == 3)
  {
    include("../Sources/Pages/Front/career.php");
  }
  if ($_SESSION["menu"] == 4)
  {
    include("../Sources/Pages/Front/about.php");
  }
?>
