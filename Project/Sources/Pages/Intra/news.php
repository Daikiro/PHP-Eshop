<?php
 require("../../connect.php");
 session_start();
 
 if($_SESSION["level"] != 1)
    {
        $protected="./index.php?a=1";
        header("Location:$protected");
        exit;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Intra - novinky</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF8"/>
        <meta lang="cs" name="author" content="Lukas Jirka">
        <meta name="description" content="Ukazka"/>
        <meta name="keywords" content="Ukazka">
        <link rel="shortcut icon" href="../Sources/Images/Ico.ico"/>
        <?php include("../Sources/Bootstrap/bootstrap.php")?>
        <link href="../Sources/Style/style.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="text-center nadpis">
            <h1>Novinky</h1>
        </div>

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <?php echo "<h4>Uživatel: <b>".$_SESSION["user"]."</b></h4>";?>
            <a href="index.php?a=1">Menu</a>
            <br>
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
                <a href='index.php?a=7'>Správa účtů</a>";?>
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

        <span id="postranni_menu" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Rozcestník</span>

    
        <div class="container-fluid posuvnik">
        <p>Menu novinky nabízí možnost přidání a upravení novinek pro hlavní a kariérní stránku webových stránek.</p>
        <?php
        
        echo "<div class='row'>
        <div class='col-md-4 clanky'>
        <table class='table'>
        <TR class='hlavicka_tabulky'>
        <TH>ID</TH>
        <TH>Nadpis</TH>
        <TH>Akce</TH>
        </TR>"; 
        $sql = "SELECT * FROM NOVINKY";
        $vysledek = mysqli_query($spojeni, $sql);
        if (mysqli_num_rows($vysledek) > 0)
                   {
                        while ($radek = mysqli_fetch_assoc($vysledek)):

                            echo "
                            <TR>
                            <TD  align = 'center'>".$radek["Id_novinky"]. "</TD>
                            <TD  align = 'center'>".$radek["Nadpis"]. "</TD>
                            <TD  align = 'center'>
                                <form method='post' action='index.php?a=8'>
                                <button class='btn btn-warning glyphicon glyphicon-pencil' type='submit' name='idcko' value=".$radek["Id_novinky"]."></button>
                                </form>
                                &nbsp;&nbsp;&nbsp;
                                <form action=../Sources/Scripty/delete_n.php method=post>
                                <button class='btn btn-danger glyphicon glyphicon-trash' type='submit' name='idcko' value=".$radek["Id_novinky"]."></button>
                                </form>
                            </TD>
                            </TR>";
                                                
      
                        endwhile;
	               }
                   
                   else
                   {
                        echo "<TD COLSPAN=3 ALIGN=center> Žádné články k zobrazení</TD></TR>";
                   }
        
        
         
        
                
                
               echo "</table></div>
                
                
                
                <div class='col-md-8'>";
                
                // Staré příspěvky
                if (isset($_POST['idcko']))
                {
                    $sql = "SELECT * FROM NOVINKY WHERE Id_novinky = '".$_POST['idcko']."'";
                    $vysledek = mysqli_query($spojeni, $sql);
                    $radek = mysqli_fetch_assoc($vysledek);
                
            
                    echo "<form action=../Sources/Scripty/modify_n.php method=POST>
           
                    <h4>Nadpis článku</h4>
                    <input name='nadpis' value='$radek[Nadpis]' size='40' required>
                    
                    <br><br>
                    <h4>Obsah článku</h4>
                    <textarea style='width:95%; height:150px;' name='obsah' cols='40' rows='5' required>$radek[Obsah]</textarea>
                    
                    <br><br>";
                    
                    if ($radek[Druh_novinek]==1)
                    {
                        echo "
                        <label class='radion-inline'>&nbsp;&nbsp;&nbsp;<INPUT type='radio' required NAME='druh_clanku' id='druh_clanku_yes' value='1' checked='checked'/>   Hlavní   </label>&nbsp;&nbsp;&nbsp
                        <label class='radion-inline'>&nbsp;&nbsp;&nbsp;<INPUT type='radio' required NAME='druh_clanku' id='druh_clanku_no' value='0'/>   Vedlejší   </label>";
                    }
                    else
                    {
                        echo "
                        <label class='radion-inline'>&nbsp;&nbsp;&nbsp;<INPUT type='radio' required NAME='druh_clanku' value='1'/>   Hlavní   </label>&nbsp;&nbsp;&nbsp
                        <label class='radion-inline'>&nbsp;&nbsp;&nbsp;<INPUT type='radio' required NAME='druh_clanku' value='0' checked='checked'/>   Vedlejší   </label>";
                    }
                    
                    echo "
                    &nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp
                    <input style='float:right; margin-right:5%;' type='submit'>
                    <input type='hidden' name='ajdcko' value='$radek[Id_novinky]'>
                    <input type='hidden' name='identifikace_clanku' value='stary'>
                    </form>";
                }
                
                // Nové příspěvky
                else
                {
                    echo "
                
                    <form action=../Sources/Scripty/modify_n.php method=POST>

                        <h4>Nadpis článku</h4>
                        <input name='nadpis' size='40' required>
                    
                        <br><br>
                        <h4>Obsah článku</h4>
                        <textarea style='width:95%; height:150px;' name='obsah' cols='40' rows='5' required></textarea>
                    
                        <br><br>
                        <label class='radion-inline'>&nbsp;&nbsp;&nbsp;<INPUT type='radio' required NAME='druh_clanku' value='1'/>   Hlavní   </label>&nbsp;&nbsp;&nbsp
                        <label class='radion-inline'>&nbsp;&nbsp;&nbsp;<INPUT type='radio' required NAME='druh_clanku' value='0'/>   Vedlejší   </label>;
                        &nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp
                        <input style='float:right; margin-right:5%;' type='submit'>
                        <input type='hidden' name='identifikace_clanku' value='novy'>
                    </form>";
                 }?>
                </div>
            </div>

        </div>

        <br>
        <hr>
        <br>

    </body>
</html>      


<script>
// Otevřít postranní menu
function openNav() {
    document.getElementById("mySidenav").style.width = "14%";
}

// Zavřít postranní menu
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}


</script>