<?php
 require("../../connect.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Antikvariát | Knihy</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF8"/>
        <meta lang="cs" name="author" content="Lukas Jirka">
        <meta name="description" content="Ukazka"/>
        <meta name="keywords" content="Ukazka">
        <link rel="shortcut icon" href="../Sources/Images/Ico.ico"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../Sources/Style/style_front.css" rel="stylesheet" type="text/css" />
        <?php include("../Sources/Bootstrap/bootstrap.php")?>
    </head>
    <body>

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
                    <li class="active"><a href="./index_front.php?b=2">Knihy</a></li>
                    <li><a href="./index_front.php?b=3">Kariéra</a></li>
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
            <h1>Seznam knih</h1>
        </div>
        <hr>

        <!-- Vyhledávání podle autora a knihy -->
        
        <?php
        echo "
        <div class='finder'>
            <h3>Vyhledávání knihy</h3>
            <div class='ui-widget'>
                <form method='post' action='index_front.php?b=2'>
                <input name='hledani_kniha' id='kniha_sept' class='typeahead'  style='width:90%;'/>   
                <br>
                <input type='submit' class='btn btn-primary btn-warning' value='Potvrdit'/>
                </form>
            </div>
            
            
            <h3>Vyhledávání autora</h3>
            <div class='ui-widget'>
                <form method='post' action='index_front.php?b=2'>
                <input name='hledani_autor' id='autor_sept' class='typeahead' style='width:90%;'/>
                <br>
                <input type='submit' class='btn btn-primary btn-warning' value='Potvrdit'/>
                </form>
    
            </div>    
        </div>";
        ?>


        <div class="container">
            <div class="posuvnik">
                <?php
    
                // Dynamické plnění autorů
                $sqlrd = "SELECT * FROM AUTOR";
           
                // Dynamické plnění kategorií
                $sqlnd = "SELECT * FROM KATEGORIE";

                // Zorazení omezeného počtu výsledků
                if(!IsSet($_POST["poradove_cislo"]))
                {
                    $_POST["poradove_cislo"] = 1;
                }
            
            
                // Normální plnění + řazení
                if((!IsSet($_POST["hledani_autor"]))&&(!IsSet($_POST["hledani_kniha"])))
                {
                    $poradi_value = $_POST["poradove_cislo"];
                    $zvysena_value = $poradi_value + 50;
            
                    if((!IsSet($_POST["sloupec"])))
                        $sql = "SELECT * FROM KNIHA WHERE Prodano = 0 ".$Orderby."";
                    else
                        $sql = "SELECT * FROM KNIHA WHERE Prodano = 0 ".$Orderby."";
                }
            
                // Hledání autora
                if((IsSet($_POST["hledani_autor"]))&&(!IsSet($_POST["hledani_kniha"])))
                {
                    $hledany_vyraz =  $_POST["hledani_autor"];
                    $sql = "SELECT Jmeno FROM AUTOR WHERE Cele_jmeno = '$hledany_vyraz'";
                    $vysledek = mysqli_query($spojeni, $sql);
                    $radek = mysqli_fetch_assoc($vysledek);
                    $sql = "SELECT * FROM KNIHA WHERE Autor = '".$radek["Jmeno"]."' AND Prodano='0' OR Spoluautor = '".$radek["Jmeno"]."' AND Prodano='0'";
                }
            
            
                // Hledání knihy
                if ((!IsSet($_POST["hledani_autor"]))&&(IsSet($_POST["hledani_kniha"])))
                {
                    $hledany_vyraz =  $_POST["hledani_kniha"];  
                    $sql = "SELECT * FROM KNIHA WHERE Nazev = '$hledany_vyraz' AND Prodano='0'";
                }
            
                // Plnění tabulky
                $vysledek = mysqli_query($spojeni, $sql);


                // Tabulka pro data
                echo "<TABLE  class = 'table table-hover'>

                <TR class='hlavicka_tabulky'>
                    <TH>Název</TH>
                    <TH>Autor</TH>
                    <TH>Kategorie</TH>
                    <TH>Jazyk</TH>
                    <TH>Cena (Kč)</TH>
                </TR>";
                   
                if (mysqli_num_rows($vysledek) > 0)
                {
                    while ($radek = mysqli_fetch_assoc($vysledek)):
                        // Barvení řádků
                        if (($i%2)==1)
                        {
                            echo "<TR class='sude_radky'>";
                        }
                        else
                            echo "<TR>";

                        // Je zde náhled pro zobrazení informací
                        echo "
                        <TD  align = 'center'>".$radek["Nazev"]. "</TD>";                    
      
                        // Plnění select boxů
                        $vysledekrd = mysqli_query($spojeni, $sqlrd);
                        $vysledekth = mysqli_query($spojeni, $sqlrd); 
                                 
                        while ($radekrd = mysqli_fetch_assoc($vysledekrd)):
                            if ($radekrd['Jmeno'] == $radek['Autor'])
                                if($radek['Spoluautor'] != NULL)
                                {
                                    while ($radekth = mysqli_fetch_assoc($vysledekth)):
                                        if ($radekth['Jmeno'] == $radek['Spoluautor'])
                                            echo "<TD  align = 'center'>".$radekrd['Cele_jmeno'] ." & " .$radekth['Cele_jmeno']." </TD>";
                                    endwhile;
                                }
                                else
                                    echo "<TD  align = 'center'>".$radekrd['Cele_jmeno'] ."</TD>";
                        endwhile;
      
                        $vysledeknd = mysqli_query($spojeni, $sqlnd); 
                                   
                        while ($radeknd = mysqli_fetch_assoc($vysledeknd)):
                            if ($radeknd['Id_kategorie'] == $radek['Kategorie'])
                                echo "<TD  align = 'center'>".$radeknd['Kategorie'] ."</TD>";
                        endwhile;
        
                        echo "<TD  align = 'center'>".$radek["Jazyk"]. "</TD>
                        <TD  align = 'center'>".$radek["Cena"]. "</TD>";
                        $i=$i+1;
                        endwhile;
	            }
                else
                {
                    echo "<TR><TD ALIGN=center COLSPAN=8> 0 nalezených knih</TD></TR>";
                }
                echo"</TABLE>";

                mysqli_close($spojeni);?>
            </div>
        </div>
        <br>
        <br>
        <br>

        <footer class="container-fluid text-center">
            <?php
            $datum = StrFTime("Dnes je: %d. %m. %Y&nbsp;&nbsp;&nbsp;&nbsp;Čas: %H:%M", Time());
            echo "<h4>$datum</h4>";
            ?>
        </footer>
    </body>
</html>
