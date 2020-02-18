<?php
 require("../../connect.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Intra - kniha</title>    
        <meta http-equiv="content-type" content="text/html; charset=UTF8"/>
        <meta lang="cs" name="author" content="Lukas Jirka">
        <meta name="description" content="Ukazka"/>
        <meta name="keywords" content="Ukazka">
        <link rel="shortcut icon" href="../Sources/Images/Ico.ico"/>
        <?php include("../Sources/Bootstrap/bootstrap.php")?>
        <script type="text/javascript" src="../Sources/Scripty/typeahead.js"></script>
        <link href="../Sources/Style/style.css" rel="stylesheet" type="text/css" />
        
        
        <script>
        //Našeptávač pro autory
        $(document).ready(function () 
        {
            $('#autor_sept').typeahead({
                source: function (query, result) 
                    {
                    $.ajax({
                        url: "typehead_autor.php",
					   data: {query: query},          
                        dataType: "json",
                        type: "POST",
                        success: function (data) 
                        {
					       result($.map(data, function (item) 
                            {
						      return item;
                            }));
                        }
                        });
                    }
            });
        });
     
        //Našeptávač pro knihu       
        $(document).ready(function () 
        {
            $('#kniha_sept').typeahead({
                source: function (query, result) {
                    $.ajax({
                    url: "typehead.php",
					data: {query: query},
                    //data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) 
                        {
						  result($.map(data, function (item) {
							return item;
                            }));
                        }
                    });
                }
            });
        });
        </script>
        
    </head>



    <body>  
        <div class="text-center nadpis">
            <h1>Správa knih</h1>
        </div>


        <!-- Postranní panel -->
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <?php echo "<h4>Uživatel: <b>".$_SESSION["user"]."</b></h4>";?>
            <a href="index.php?a=1">Menu</a>
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
            <a href="../../logout.php">Odhlášení</a>
        </div>

        <span style="position:fixed">
            <span id="postranni_menu" style="font-size:30px;cursor:pointer;" onclick="openNav()">&#9776; Rozcestník
            </span>
            <br>
            <br>
            <br>  
        </span>

        
        
        <!-- Vyhledávání podle autora a knihy -->
        
        <?php
        echo "
        <div class='finder'>
            <h3>Vyhledávání knihy</h3>
            <div class='ui-widget'>
                <form method='post' action='index.php?a=2'>
                <input name='hledani_kniha' id='kniha_sept' class='typeahead'  style='width:90%;'/>   
                <br>
                <input type='submit' class='btn btn-info' value='Potvrdit'/>
                </form>
            </div>
            
            
            <h3>Vyhledávání autora</h3>
            <div class='ui-widget'>
                <form method='post' action='index.php?a=2'>
                <input name='hledani_autor' id='autor_sept' class='typeahead' style='width:90%;'/>
                <br>
                <input type='submit' class='btn btn-info' value='Potvrdit'/>
                </form>
                

                &nbsp;<A href='#myModalAutor' type='button' class='AddAutorDialog btn btn-primary btn-warning' data-toggle='modal'>Přidat autora</a>
                <br> &nbsp;
                
                
                
            </div>    
        </div>";
        ?>



        <!-- Obsah stránky -->
        <div class="container-fluid">

            <?php

            // Sloupec podle kterého řadím
            if (!IsSet($_POST["sloupec"])) 
                $sloupec_razeni="";
            else 
                $sloupec_razeni=$_POST["sloupec"];
                
            // Směr kterým řadíme                      
            if (!IsSet($_POST["razeni"])) 
                $smer_razeni="";
            else 
                $smer_razeni = $_POST["razeni"];
            
            // Ochrana proti prázdnému sloupci
            if($sloupec_razeni!="")
                $Orderby = "ORDER BY $sloupec_razeni ".$smer_razeni;
            else
                $Orderby = "ORDER BY Id ".$smer_razeni;
            
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
                    $sql = "SELECT * FROM KNIHA WHERE Prodano = 0 AND Id <= '".$zvysena_value."' AND Id >= '".$poradi_value."' ".$Orderby."";
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

            // Export všech knih - Na radu vedoucího práce odebráno
            /*
            <form method='post' action='../Sources/Scripty/export.php'>
                <input type='submit' name='export' class='btn btn-primary' value='Export'>  
                <input type='hidden' name='soubor' value='Kniha'>
                <input type='hidden' name='tabulka' value='KNIHA'>
            </form> 
            */

            // Tabulka pro data
            echo "<TABLE class = 'table table-hover'>

                    <TR class='hlavicka_tabulky'>
                        <TH>Prodej</TH>\n
                        <TH>#</TH>\n
                        <TH>Název</TH>\n
                        <TH>Autor</TH>\n
                        <TH>Kategorie</TH>\n
                        <TH>Jazyk</TH>\n
                        <TH>Cena (Kč)</TH>\n
                        <TH>Vazba</TH>\n
                        <TH>Rok vydání</TH>\n
                        <TH>Akce</TH>
                    </TR>

                    <TD COLSPAN = '9'>
                    <fieldset>
                        <form method='post' action='index.php?a=2'>
	                       <div id='razeni_box'>
                            <label for='razeni_box'>Řazení&nbsp;&nbsp;&nbsp;</label>
                       
		                    <select required id='sloupec' name='sloupec'>
			                 <option value='Id'>ID</option>
			                 <option value='Nazev'>Název</option>
			                 <option value='Autor'>Autor</option>
			                 <option value='Kategorie'>Kategorie</option>
			                 <option value='Jazyk'>Jazyk</option>
			                 <option value='Cena'>Cena</option>
			                 <option value='Vazba'>Vazba</option>
                             <option value='Rok_vydani'>Rok vydání</option>
		                    </select>
                       
                            &nbsp;                       
		                    <label for='razeni_ASC'>Vzestupně</label>
		                    <input required type='radio' name='razeni' id='razeni_ASC' value='ASC'>
                            &nbsp;
		                    <label for='razeni_DESC'>Sestupně</label>
		                    <input required type='radio' name='razeni' id='razeni_DESC' value='DESC'>
                            &nbsp;                       
		                    <button class='btn btn-dark'>Potvrdit</button>
	                       </div>
                        </form>
                    </fieldset>
                  </TD> 
                  
                  <TD align = right>
                    <A href='#myModaladd' type='button' class='AddBookDialog btn btn-primary glyphicon glyphicon-plus' data-toggle='modal'>
                    </A>
                  </TD>";
                   
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
                            
                            $oc=$radek["Id"];
                                
                            // Je zde náhled pro zobrazení informací
                            echo "
                            <TD  align = 'center'>
                                <form method='post' action='../Sources/Scripty/sale.php' target='_blank' onsubmit='setTimeout(function(){window.location.reload();},2)'>
                                    
                                    <button class='btn btn-primary glyphicon glyphicon-piggy-bank' type='submit' name='idcko' value=".$radek["Id"]."></button>
                                    <input type='hidden' name='prodejni_cena' value=".$radek["Cena"].">
                                    <input type='hidden' name='typ_prikazu' value='potvrdit_nakup'>
                                    <input type='hidden' name='zadavatel' value=".$_SESSION['user'].">
                                </form>
                                </TD>
                            <TD  align = 'center'>".$radek["Id"]. "</TD>
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
                            <TD  align = 'center'>".$radek["Cena"]. "</TD>
                            <TD  align = 'center'>".$radek["Vazba"]. "</TD>
                            <TD  align = 'center'>".$radek["Rok_vydani"]. "</TD>";
        
                            echo "<TD align = 'right'>"."
                            <a href='#myModalupdate' type='button' data-id='$oc' class='open-UpdateBookDialog btn btn-primary glyphicon glyphicon-cog' data-toggle='modal' name='edit'></a>          
                            &nbsp;&nbsp;
                            <A href='#myModaldelete' type='button' data-id='$oc' class='open-DeleteBookDialog btn btn-primary glyphicon glyphicon-trash' data-toggle='modal'></A></TD>";

                                    $i=$i+1;


                        endwhile;
	               }
                   
                   else
                   {
                        echo "<TR><TD ALIGN=center COLSPAN=10> 0 nalezených knih</TD></TR>";
                    }
            
            // Select pro vybírání indexu zobrazovaných dat
            echo "<TR><TD ALIGN=left COLSPAN=2> Zobrazuji knihy podle ID:
            <form method='post' action='index.php?a=2'>
            <select id='poradove_cislo' name='poradove_cislo' class='form-control' onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                <option value='1'>001-050</option>
                <option value='51'>051-100</option>
                <option value='101'>101-150</option>
                <option value='151'>151-200</option>
                <option value='201'>201-250</option>
                <option value='251'>251-300</option>
                <option value='301'>301-350</option>
                <option value='351'>351-400</option>
                <option value='401'>401-450</option>
                <option value='451'>451-500</option>
                <option value='501'>501-550</option>
                <option value='551'>551-600</option>
                <option value='601'>601-650</option>
                <option value='651'>651-700</option>
                <option value='701'>701-750</option>
                <option value='751'>751-800</option>
                <option value='801'>801-850</option>
                <option value='851'>851-900</option>
                <option value='901'>901-950</option>
                <option value='951'>951-1000</option>
                <option value='1001'>1001-1050</option> 
            </select>
            <br>
            <input type='submit' class='btn btn-info' value='Potvrdit'>
            </form>
            </TD>
            </TR>";        
            echo"</TABLE>";

            
            mysqli_close($spojeni);
            ?>
                     
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
                <input id=zdroj type=hidden name=zdroj value='kniha'>     
                <input type='submit' class='btn btn-danger' value='Smazat'>
                <button type='button' class='btn btn-info' data-dismiss='modal'>Zrušit</button>
                </form>
                <br>
                
				                                                                                                                                     
			</div>
		</div>
	</div>
</div>";
?>









<!-- Modal add -->
<?php
echo "
<div id='myModaladd' class='modal fade'>
	<div class='modal-add modal-dialog modal-confirm'>
		<div class='modal-content'>
			<div class='modal-header'>
				<div class='icon-box'>
					<i class='glyphicon glyphicon-plus'></i>
				</div>				
				<h4 class='modal-title'>Přidat knihu</h4>	
                
			</div>
			<div class='modal-body'>";
            
require("../../connect.php");
                                 
echo "<FORM ACTION='../Sources/Scripty/insert.php' METHOD='POST'>

    <table>
        <TR>
            <TD class='levy_sloupec'>Název:<TD>		     <INPUT required NAME=nazev PLACEHOLDER='  Název knihy  '>";

        //Autor
        $sql = 'SELECT * from AUTOR';
        $vysledek = mysqli_query($spojeni, $sql);

        echo "<TR><TD class='levy_sloupec'>Autor:<TD>";
        echo  "<select required size='1' name='autor'>";                                      
		  while ($autor_vyber = mysqli_fetch_assoc($vysledek)):    
            echo "<option value=".$autor_vyber['Jmeno'].">".$autor_vyber['Cele_jmeno']."</option>";
          endwhile;
        echo "</select>";
        
        //Spoluautor
        $sql = 'SELECT * from AUTOR';
        $vysledek = mysqli_query($spojeni, $sql);

        echo "<TR><TD class='levy_sloupec'>Spoluautor:<TD>";
        echo  "<select size='1' name='spoluautor'>";   
        echo "<option value='bez_autora' selected></option>";                                      
		  while ($autor_vyber = mysqli_fetch_assoc($vysledek)):    
            echo "<option value=".$autor_vyber['Jmeno'].">".$autor_vyber['Cele_jmeno']."</option>";
          endwhile;
        echo "</select>";



        //Kategorie
        $sql = 'SELECT * from KATEGORIE';
        $vysledek = mysqli_query($spojeni, $sql);

        echo "<TR><TD class='levy_sloupec'>Kategorie:<TD>";
        echo  "<select size='1' name='kategorie'>";                                      
		  while ($kategorie_vyber = mysqli_fetch_assoc($vysledek)):   
            echo "<option value=".$kategorie_vyber['Id_kategorie'].">".$kategorie_vyber['Kategorie']."</option>";
          endwhile;
        echo "</select>";

        //Jazyk
        $sql = 'SELECT * from JAZYK';
        $vysledek = mysqli_query($spojeni, $sql);
        echo "<TR><TD class='levy_sloupec'>Jazyk:       	<TD>";
        echo  "<select size='1' name='jazyk'>";                                      
		  while ($jazyk_vyber = mysqli_fetch_assoc($vysledek)):
            $tmp = $jazyk_vyber['Zkratka'];
                if ($jazyk_vyber['Zkratka'] == "cs")
                    echo "<option value=".$tmp." selected>".$jazyk_vyber['Nazev']."</option>";
                else    
                    echo "<option value=".$tmp.">".$jazyk_vyber['Nazev']."</option>";
          endwhile;
        echo "</select>";

        echo "<TR><TD class='levy_sloupec'>Cena (Kč):<TD>		       <INPUT required NAME=cena PLACEHOLDER='  Cena  '>
        <TR><TD class='levy_sloupec'>Vazba:<TD>		 <INPUT NAME=vazba PLACEHOLDER='  Druh vazby  '>
        <TR><TD class='levy_sloupec'>Rok vydání:<TD>		 <INPUT NAME=rok_vydani PLACEHOLDER='  Rok vydání  '>
        <TR><TD class='levy_sloupec'>Nakladatelství:<TD>		 <INPUT NAME=vydal PLACEHOLDER='  Nakladatelství  '>
        <TR><TD class='levy_sloupec'>Stav knihy:<TD>		 <INPUT NAME=stav PLACEHOLDER='  Stav '>
    </table>";

    mysqli_close($spojeni);

    echo "
    </div>
    <div class='modal-footer'>
        <input type='submit' class='btn btn-success' value='Přidat'> 
        <button type='button' class='btn btn-info' data-dismiss='modal'>Zrušit</button>
        </FORM><br>                                                                                                                                                   
	</div>
	</div>
	</div>
</div>";?> 










<!-- Modal update -->

<?php                                                     
echo "
<div id='myModalupdate' class='modal fade'>
	<div class='modal-dialog modal-confirm modal-update'>
		<div class='modal-content'>
			<div class='modal-header'>
				<div class='icon-box'>
					<i class='glyphicon glyphicon glyphicon-cog'></i>
				</div>				
				<h4 class='modal-title'>Upravte hodnoty položky</h4>	
                
			</div>
			<div class='modal-body'>
		           
        	<form method ='post' action='../Sources/Scripty/update.php'>";
 
                require("../../connect.php");
                
                echo "<TABLE ALIGN='CENTER'>";
                echo "<label id='sfix'>";
                                                                          
                echo "<TR><TD class='levy_sloupec'>Název:	      <TD><input name='nazev' id='nazev' class='form-control' size='30' />";
                    
                //Autor
                $sql = 'SELECT * from AUTOR';
                $vysledek = mysqli_query($spojeni, $sql);

                echo "<TR><TD class='levy_sloupec'>Autor:<TD>";
                echo  "<select size='1' name='autor' id='autor'>";                                      

                while ($autor_vyber = mysqli_fetch_assoc($vysledek)):    
                    echo "<option value=".$autor_vyber['Jmeno'].">".$autor_vyber['Cele_jmeno']."</option>";
                endwhile;
                
                echo "</select>";
                
                //Spoluautor
                $sql = 'SELECT * from AUTOR';
                $vysledek = mysqli_query($spojeni, $sql);

                echo "<TR><TD class='levy_sloupec'>Spoluautor:<TD>";
                echo  "<select size='1' name='spoluautor' id='spoluautor'>";                                      
		        echo "<option value='bez_autora'>Bez autora</option>";
                while ($autor_vyber = mysqli_fetch_assoc($vysledek)):    
                    echo "<option value=".$autor_vyber['Jmeno'].">".$autor_vyber['Cele_jmeno']."</option>";
                endwhile;
                
                echo "</select>";
                   
                echo "<TR><TD class='levy_sloupec'>Kategorie:<TD>
                           <select size='1' name='kategorie' id='kategorie' class='form-control'/>;                                      
		                        <option value='1'>Báje&nbsp;a&nbsp;pověsti</option>
                                <option value='2'>Cestopisy</option>
                                <option value='3'>Detektivka</option>
                                <option value='4'>Dívčí román</option>
                                <option value='5'>Drama</option>
                                <option value='6'>Erotika</option>
                                <option value='7'>Fantasy</option>
                                <option value='8'>Horor</option>
                                <option value='9'>Humor a Satira</option>
                                <option value='10'>Komiks</option>
                                <option value='11'>Poezie</option>
                                <option value='12'>Povídka</option>
                                <option value='13'>Pro mládež</option>
                                <option value='14'>Próza</option>
                                <option value='15'>Publicistika</option>
                                <option value='16'>Román pro ženy</option>
                                <option value='17'>Romány</option>
                                <option value='18'>Sci-fi</option>
                           </select>";


                echo "<TR><TD class='levy_sloupec'>Jazyk:       	<TD>";
                echo  "<select size='1' name='jazyk' id='jazyk' class='form-control'/>
                                <option value='ar'>arabština</option>
                                <option value='bg'>bulharština</option>
                                <option value='ca'>katalánština</option>
                                <option value='ceb'>cebuánština</option>
                                <option value='cs'>čeština</option>
                                <option value='da'>dánština</option>
                                <option value='de'>němčina</option>
                                <option value='en'>angličtina</option>
                                <option value='eo'>esperanto</option>
                                <option value='es'>španělština</option>
                                <option value='eu'>baskičtina</option>
                                <option value='fa'>perština</option>
                                <option value='fi'>finština</option>
                                <option value='fr'>francouzština</option>
                                <option value='he'>hebrejština</option>
                                <option value='hu'>maďarština</option>
                                <option value='hy'>arménština</option>
                                <option value='id'>indonéština</option>
                                <option value='it'>italština</option>
                                <option value='ja'>japonština</option>
                                <option value='kk'>kazaština</option>
                                <option value='ko'>korejština</option>
                                <option value='lt'>litevština</option>
                                <option value='min'>minangkabauština</option>
                                <option value='ms'>malajština</option>
                           </select>";

                    

                echo "<TR><TD class='levy_sloupec'>Cena (Kč):       <TD><INPUT NAME='cena' id='cena' SIZE=30 class='form-control'/>
                    <TR><TD class='levy_sloupec' >Vazba:          <TD><INPUT NAME='vazba' id='vazba' SIZE=30 class='form-control'/>
                    <TR><TD class='levy_sloupec'>Rok vydání:      <TD><INPUT NAME='rok_vydani' id='rok_vydani' SIZE=30 class='form-control'/>
                    <TR><TD class='levy_sloupec'>Vydal:      <TD><INPUT NAME='vydal' id='vydal' SIZE=30 class='form-control'/>
                    <TR><TD class='levy_sloupec'>Stav:      <TD><INPUT NAME='stav' id='stav' SIZE=30 class='form-control'/>
                     
                    <input type='hidden'  name='idcko' id='idcko'>
                    </TABLE>";
                mysqli_close($spojeni);
                
                echo "</div>
			     <div class='modal-footer'>
                    <input type='submit' class='btn btn-info' value='Upravit'>
                    <button type='button' class='btn' data-dismiss='modal'>Zrušit</button>
                    </form>
                    <br>                                                                                                                                           
			</div>
		</div>
	</div>
</div>";?>





<?php
echo "
<div id='myModalAutor' class='modal fade'>
	<div class='modal-dialog modal-confirm modal-info'>
		<div class='modal-content'>
			<div class='modal-header'>
				<div class='icon-box'>
					<i class='glyphicon glyphicon-user'></i>
				</div>				
				<h4 class='modal-title'>Přidejte autora</h4>	
                
			</div>
			<div class='modal-body'>
				<p>Dávejte pozor při zadávání!</p>
                <form ACTION=../Sources/Scripty/insert_autor.php method=POST>
                <table class = 'table borderless'>
                <TR><TD class='levy_sloupec'>Zkratka: <TD>		       <INPUT required NAME=jmeno_autor PLACEHOLDER='  bozenanemcova  '>
                <TR><TD class='levy_sloupec'>Jméno: <TD>		       <INPUT required NAME=cele_jmeno_autor PLACEHOLDER='  Božena Němcová  '>
                </table>
			</div>
			<div class='modal-footer'>
                     
                <input type='submit' class='btn btn-success' value='Přidat'>
                <button type='button' class='btn btn-info' data-dismiss='modal'>Zrušit</button>
                
                </form>
                <br>   	                                                                                                                                     
			</div>
		</div>
	</div>
</div>";
?>


        <br>
        <hr>
        <br>
    </body>
</html>


<script>    
                           
    // otevírání navigace
    function openNav() 
    {
        document.getElementById("mySidenav").style.width = "14%";
    }

    // zavírání naviage
    function closeNav()  
    {
        document.getElementById("mySidenav").style.width = "0";
    }

    // dialogové okno pro mazání knih
    $(document).on("click", ".open-DeleteBookDialog", function ()  
    {
        var myBookId = $(this).data('id');
        $(".modal-footer #skryteid").val( myBookId );
    });
               
    // dialogové okno pro update knihy
    $(document).on('click', '.open-UpdateBookDialog', function()
    {
        var BookId = $(this).attr('data-id');
         
        $.ajax({
            url:"fetch.php", //korenovy adresar dovoluje odkazovat pouze do stejne slozky
            method:"POST",
            data: {BookId: BookId},
            dataType:"json",
            success:function(data)
            { 
                $('#idcko').val(data.Id);
                $('#nazev').val(data.Nazev);
                $('#autor').val(data.Autor);
                
                if (data.Spoluautor == null)
                    $('#spoluautor').val("bez_autora");
                else
                    $('#spoluautor').val(data.Spoluautor);                    
                    
                $('#kategorie').val(data.Kategorie);
                $('#jazyk').val(data.Jazyk);
                $('#cena').val(data.Cena);
                $('#vazba').val(data.Vazba);
                $('#rok_vydani').val(data.Rok_vydani);
                $('#vydal').val(data.Vydal);
                $('#stav').val(data.Stav);
                $('#myModalupdate').modal('show'); 
                                   
            },
     });       
    });  
</script> 