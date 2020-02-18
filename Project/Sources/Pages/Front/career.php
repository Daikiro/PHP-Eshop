<?php
 require("../../connect.php");
?>

<!DOCTYPE html>
<html>
 <head>
  <title>Antikvariát | Kariéra</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF8"/>
  <meta lang="cs" name="author" content="Lukas Jirka">
  <meta name="description" content="Ukazka"/>
  <meta name="keywords" content="Ukazka">
  <link rel="shortcut icon" href="../Sources/Images/Ico.ico"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../Sources/Style/style_front.css" rel="stylesheet" type="text/css" />
  <?php include("../Sources/Bootstrap/bootstrap.php")?>

</head>
<BODY onload="aktualni_cas()">

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="./index_front.php?b=1">Úvod</a></li>
        <li><a href="./index_front.php?b=2">Knihy</a></li>
        <li class="active"><a href="./index_front.php?b=3">Kariéra</a></li>
        <li><a href="./index_front.php?b=4">O nás</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../../login.php"><span class="glyphicon glyphicon-log-in"></span>  Přihlášení</a></li>
      </ul>
    </div>
  </div>
</nav>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>


    <div class="carousel-inner" role="listbox">
      <div class="item active">
         <img src="../Sources/Images/bck_front_1.png" alt="bck_front_1" style="width:100%;" height="1200" width="400">
	       <div class="carousel-caption">

        </div>
      </div>

      <div class="item">
        <img src="../Sources/Images/bck_front_2.png" alt="bck_front_2" style="width:100%;" height="1200" width="400">
	        <div class="carousel-caption">

          </div>
      </div>

	<div class="item">
        <img src="../Sources/Images/bck_front_3.png" alt="bck_front_3" style="width:100%;" height="1200" width="400">
	       <div class="carousel-caption">

        </div>
      </div>

    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>

<div class="container">
  <h1>Kariéra / Novinky</h1>
</div>
<hr>


<div class="container">
    <div class="posuvnik">
    <?php
        $sql = "SELECT * FROM NOVINKY WHERE Druh_novinek = 0 ";
        $vysledek = mysqli_query($spojeni, $sql);
        while ($radek = mysqli_fetch_assoc($vysledek)):
        $radek["Datum_vytvoreni"] = date("d-m-Y", strtotime($radek["Datum_vytvoreni"]));
        echo "
        
        <div class='row'>
            <div class='col-md-4'>
                <h3>".$radek["Nadpis"]."</h3>
            </div>
            <div class='col-md-4'>
            </div>
            <div class='col-md-4'>
                ".$radek["Datum_vytvoreni"]."
            </div>
        </div>
        <span>".$radek["Obsah"]."</span>
        <hr>";
        endwhile;
    ?>
    </div>
</div>






<br><br><br>


<footer class="container-fluid text-center">
<?php
$datum = StrFTime("Dnes je: %d. %m. %Y&nbsp;&nbsp;&nbsp;&nbsp;Čas: %H:%M", Time());
echo "<h4>$datum</h4>";
?>

</footer>


</body>
</html>
