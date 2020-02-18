<?php
 require("../../connect.php");

 if (!IsSet($cislo)) $cislo="";
if (!IsSet($orderby)) $orderby="";
?>

<!DOCTYPE html>
<html>
 <head>
   <title>Intra - index</title>
   <meta http-equiv="content-type" content="text/html; charset=UTF8"/>
   <meta lang="cs" name="author" content="Lukas Jirka">
    <meta name="description" content="Ukazka"/>
    <meta name="keywords" content="Ukazka">
    <link rel="shortcut icon" href="../Sources/Images/Ico.ico"/>
  <?php include("../Sources/Bootstrap/bootstrap.php")?>
  <link href="../Sources/Style/style.css" rel="stylesheet" type="text/css" />
  </head>

<body>

<div class="nadpis text-center">
  <h1>Navigační menu</h1>
</div>

 <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php echo "<h4>Uživatel: <b>".$_SESSION["user"]."</b></h4>";?>
  <a href="index.php?a=2">Správa knih</a>
  <br>
  <a href="index.php?a=3">Správa předmětů</a>
  <br>
  <?php
  session_start();

  if($_SESSION["level"] == 1)
  echo "<a href='index.php?a=4'>Účetnictví</a>
  <br>
  <a href='index.php?a=5'>Administrace</a>
  <br>
  <a href='index.php?a=7'>Správa účtů</a>
  <br>
  <a href='index.php?a=8'>Novinky</a>";
  ?>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <a href="../../logout.php">Odhlášení</a>
</div>

<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Rozcestník</span>

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>

 <div class="container">
 <hr>
  <div class="row">
    <br>
    
    <div class="col-sm-4">
       
    </div>
    <div class="col-sm-4">
       <?php
       $datum = StrFTime("Dnes je: %d. %m. %Y&nbsp;&nbsp;&nbsp;&nbsp;Čas: %H:%M", Time());
        echo "<h4>$datum</h4>";
        ?>
    </div>
    <div class="col-sm-4">
    </div> 
  </div>
  <h3 style="text-align:center">Nyní jste přihlášen/a v systému antikvariátu. Rozklikávací menu na levé straně obrazovky Vás dovede k cíli, který hledáte.</h3>
  </div>
<br>
<hr>
<br>

    </body>
</html>