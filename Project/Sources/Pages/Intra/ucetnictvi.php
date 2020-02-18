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
        <title>Intra - účetnictví</title>
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
            <h1>Zobrazit účetnictví</h1>
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
                echo "
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

        <span id="postranni_menu" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Rozcestník</span>
        <?php 
        
        // data-toggle='collapse' data-target='#obsah_faktur'
        echo"
        <div class='container-fluid'>
            <button id='faktury_tlacitko' type='button' class='btn btn btn-dark btn-lg'>Faktury</button>
            <button id='knihy_tlacitko' type='button' class='btn btn btn-dark btn-lg'>Prodané knihy</button>
            <button id='obrat_tlacitko' type='button' class='btn btn btn-dark btn-lg'>Obrat</button>
          
            <div id='obsah_faktur'>
                <table class = 'table table-hover'>
                    <TR class='hlavicka_tabulky'>
                        <TH>#</TH>
                        <TH>ID knihy</TH>
                        <TH>Prodáno</TH>
                        <TH>Cena bez DPH</TH>
                        <TH>DPH</DPH>
                        <TH>Cena s DPH</TH>
                        <TH>Datum</TH>
                        <TH>Zadavatel</TH>
                        <TH>Export</TH>
                    </TR>";

        
                    $sql = "SELECT * FROM FINANCE";
                    $vysledek = mysqli_query($spojeni, $sql);
                    
                    if (mysqli_num_rows($vysledek) > 0)
                    {
                        while ($radek = mysqli_fetch_assoc($vysledek)): 
         
                            echo "
                            <TR>
                                <TD  align = 'center'>".$radek['Id_faktury']."</TD>
                                <TD  align = 'center'>".$radek['Id_knihy']."</TD>
                                <TD  align = 'center'>".$radek['Druh_polozky']."</TD>
                                <TD  align = 'center'>".$radek['Cena_bez_dph']."</TD>
                                <TD  align = 'center'>".$radek['DPH']."</TD>
                                <TD  align = 'center'>".$radek['Cena_s_dph']."</TD>
                                <TD  align = 'center'>".$radek['Datum']."</TD>
                                <TD  align = 'center'>".$radek['Zadavatel']."</TD>
                                <TD  align = 'center'>
                                <form method='post' action='../Sources/Scripty/export.php'>
                                    <button type='input' name='export' class='btn btn-primary glyphicon glyphicon-download-alt' value='".$radek['Id_faktury']."'></button> 
                                    
                                    <input type='hidden' name='oznaceni_faktury' value='Kniha'>
                                    <input type='hidden' name='soubor' value='Kniha'>
                                    <input type='hidden' name='tabulka' value='FINANCE'>
                                </form>
                                </TD>
                            </TR> ";
                        endwhile;
                    }
                    echo "
                    </table>  

            </div>
             
            <div id='obsah_knihy'>
                <div class='row'>
                    <div class='col-md-6'>
                        <h2>Prodané knihy</h2> 
        
                        <table class = 'table table-hover'>
                            <TR class='hlavicka_tabulky'>
                                <TH>#</TH>
                                <TH>Název</TH>
                                <TH>Cena (Kč)</TH>
                                <TH>Akce</TH>
                            </TR>";
        
                            $sql = "SELECT * FROM KNIHA WHERE Prodano='1'";
                            $vysledek = mysqli_query($spojeni, $sql);
                            if (mysqli_num_rows($vysledek) > 0)
                            {
                                while ($radek = mysqli_fetch_assoc($vysledek)): 
         
                                    echo "
                                    <TR>
                                        <TD  align = 'center'>".$radek['Id']."</TD>
                                        <TD  align = 'center'>".$radek['Nazev']."</TD>
                                        <TD  align = 'center'>".$radek['Cena']."</TD>
                                        <TD  align = 'center'>
                                        <form method='post' action='../Sources/Scripty/sale.php'>
                                            <button style='float:left;' class='btn btn-primary glyphicon glyphicon-repeat' type='submit' name='idcko' value=".$radek["Id"]."></button>
                                            <input type='hidden' name='typ_prikazu' value='zrusit_nakup'>
                                        </form>
                                        <A href='#myModaldelete' type='button' data-id='".$radek['Id']."' class='open-DeleteBookDialog btn btn-primary glyphicon glyphicon-trash' style='float:right;' data-toggle='modal'></A>
                                        </TD>
                                    </TR> ";
                                endwhile;
                            }
                            echo "
                        </table>      
            

                      
                    </div>             
                    <h2>Neprodané knihy</h2>
                
                    <div class='col-md-6'>

                    <table class = 'table table-hover'>
                        <TR class='hlavicka_tabulky'>
                            <TH>#</TH>
                            <TH>Název</TH>
                            <TH>Cena (Kč)</TH>
                        </TR>";
                     
                        $sql = "SELECT * FROM KNIHA WHERE Prodano='0'";
                        $vysledek = mysqli_query($spojeni, $sql);
                        if (mysqli_num_rows($vysledek) > 0)
                        {
                            while ($radek = mysqli_fetch_assoc($vysledek)): 
                                echo "
                                <TR>
                                    <TD  align = 'center'>".$radek['Id']."</TD>
                                    <TD  align = 'center'>".$radek['Nazev']."</TD>
                                    <TD  align = 'center'>".$radek['Cena']."</TD>
                                </TR> ";
                            endwhile;
                        }?>
                    </table> 
                    </div>
                </div>
            </div>
  
            <div id='obsah_obrat'>
                <br>
                <h3>Zadejte rozsah doby, pro kterou chcete obrat vypočítat</h3>
                <br>
                <form action='index.php?a=4' method='POST'>
                    <input type='date' name='datum_od'>
                    &nbsp;&nbsp;&nbsp;
                    <input type='date' name='datum_do'>
                    &nbsp;&nbsp;&nbsp;
                    
                    
                    <input type='submit'>      
                </form>
                
                <?php
                if (IsSet($_POST["datum_od"]) && IsSet($_POST["datum_do"]))
                {
                    $sql = "SELECT SUM(Cena_s_dph) FROM FINANCE WHERE Datum >= '".$_POST["datum_od"]."' AND Datum <= '".$_POST["datum_do"]."'";
                    $vysledek = mysqli_query($spojeni, $sql);
                    $radek = mysqli_fetch_assoc($vysledek);
    
                    $sqlnd = "SELECT SUM(Cena_bez_dph) FROM FINANCE WHERE Datum >= '".$_POST["datum_od"]."' AND Datum <= '".$_POST["datum_do"]."'";
                    $vysledeknd = mysqli_query($spojeni, $sqlnd);
                    $radeknd = mysqli_fetch_assoc($vysledeknd);

                    $vysledek_bez_dph =  round($radeknd['SUM(Cena_bez_dph)'], 2);
                    $vysledek_s_dph =  round($radek['SUM(Cena_s_dph)'], 2);
                        
                        echo "<script type='text/javascript'>alert('Za období od: ".date('d.m.Y', strtotime($_POST["datum_od"]))." do: ".date('d.m.Y', strtotime($_POST["datum_do"]))."\\nCelkový obrat je:\\n".$vysledek_bez_dph." (Kč) bez DPH\\n".$vysledek_s_dph." (Kč) s DPH');</script>";
                        
                }?>
            </div>
        </div>


        <!-- Modal delete -->
        <?php
        echo "
        <div id='myModaldelete' class='modal fade'>
	       <div class='modal-dialog modal-confirm modal-delete'>
		      <div class='modal-content'>
			     <div class='modal-header'>
				    <div class='icon-box'>
					   <i class='glyphicon glyphicon-remove-circle'></i>
				    </div>				
				    <h4 class='modal-title'>Chcete smazat tuto položku?</h4>	
			     </div>
                 
			     <div class='modal-body'>
				    <p>Tento proces nelze vrátit.</p>
			     </div>
                 
			     <div class='modal-footer'>
                    <form ACTION=../Sources/Scripty/delete.php method=POST>
                        <input id=skryteid type=hidden name=idcko value=$idcko>
                        <input id=zdroj type=hidden name=zdroj value='ucetnictvi'>
                        <input type='submit' class='btn btn-danger' value='Smazat'>
                        <button type='button' class='btn btn-info' data-dismiss='modal'>Zrušit</button>
                    </form>
                    <br>                                                                                                                
			     </div>
		      </div>
	       </div>
        </div>";?>


<script>
    // Otevření postranního menu
    function openNav() 
    {
        document.getElementById("mySidenav").style.width = "14%";
    }

    // Zavření postranního menu
    function closeNav() 
    {
        document.getElementById("mySidenav").style.width = "0";
    }

    // Dialogové okno pro mazání knih
    $(document).on("click", ".open-DeleteBookDialog", function ()  
    {
        var myBookId = $(this).data('id');
        $(".modal-footer #skryteid").val( myBookId );
    });
    
    
    $(document).ready(function(){
        $("#obsah_knihy").hide();
        $("#obsah_obrat").hide();
        $("#faktury_tlacitko").css("background-color", "#1fc8db");
    
        $("#faktury_tlacitko").click(function(){
            $("#obsah_faktur").show();
            $("#obsah_knihy").hide();
            $("#obsah_obrat").hide();
            $("#faktury_tlacitko").css("background-color", "#1fc8db");
            $("#knihy_tlacitko").css("background-color", "");
            $("#obrat_tlacitko").css("background-color", "");
        });
        
        $("#knihy_tlacitko").click(function(){
            $("#obsah_knihy").show();
            $("#obsah_faktur").hide();
            $("#obsah_obrat").hide();
            $("#knihy_tlacitko").css("background-color", "#1fc8db");
            $("#obrat_tlacitko").css("background-color", "");
            $("#faktury_tlacitko").css("background-color", "");
        });
        
        $("#obrat_tlacitko").click(function(){
            $("#obsah_obrat").show();
            $("#obsah_knihy").hide();
            $("#obsah_faktur").hide();
            $("#obrat_tlacitko").css("background-color", "#1fc8db");
            $("#knihy_tlacitko").css("background-color", "");
            $("#faktury_tlacitko").css("background-color", "");
        });
    });
    
</script>

    <br>
    <hr>
    <br>
    </body>
</html>