<?php
 require("../../connect.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Intra - předmět</title>
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
            <h1>Správa předmětů</h1>
        </div>

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <?php echo "<h4>Uživatel: <b>".$_SESSION["user"]."</b></h4>";?>
            <a href="index.php?a=1">Menu</a>
            <br>
            <a href="index.php?a=2">Správa knih</a>
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
                <a href='index.php?a=8'>Novinky</a>";?>
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

            <?php
            $sql = "SELECT * FROM OBJEKT";
            $vysledek = mysqli_query($spojeni, $sql);

            echo "<TABLE class = 'table table-hover'>
                <TR class='hlavicka_tabulky'>
                    <TH>#</TH>\n
                    <TH>Název</TH>\n
                    <TH>Záruční doba</TH>\n
                    <TH>Cena (Kč)</TH>\n
                    <TH>Datum pořízení</TH>\n
                    <TH>Datum vyřazení</TH>\n
                    <TH>Počet kusů</TH>\n
                    <TH>Prodejce</TH>\n";
                    
                    if ($_SESSION["level"] == 1)
                    echo "<TH>Akce</TH>";
                
                echo "</TR>
                <TR>
                    <TD COLSPAN = 2>
                        <form method='post' action='../Sources/Scripty/export.php'>
                            <input type='submit' name='export' class='btn btn-primary' value='Export'>
                            <input type='hidden' name='soubor' value='Objekt'>
                            <input type='hidden' name='tabulka' value='OBJEKT'>
                        </form>
                    </TD>
                    <TD COLSPAN = 6>
                        &nbsp;
                    </TD>";
                    if ($_SESSION["level"] == 1)
                    echo "<TD align = right>
                        <A href='#myModaladd' type='button' class='AddBookDialog btn btn-primary glyphicon glyphicon-plus' data-toggle='modal'></A>
                    </TD>";
                echo "</TR>";      


            if (mysqli_num_rows($vysledek) > 0)
            {
                while ($radek = mysqli_fetch_assoc($vysledek)):

                    if (($i%2)==1)
                    {
                        echo "<TR class='sude_radky'>";
                    }
                    else
                        echo "<TR>";
                        
                    $oc=$radek["Id"];

                    echo "<TD align = 'center'>".$radek["Id"]. "</TD>
                    <TD align = 'center'>".$radek["Nazev"]. "</TD>
                    <TD align = 'center'>".$radek["Zarucni_doba"]. "</TD>
                    <TD align = 'center'>".$radek["Cena"]. "</TD>
                    <TD align = 'center'>".$radek["Datum_porizeni"]. "</TD>";

                    if ($radek["Datum_vyrazeni"] == NULL)
                        echo "<TD align = 'center'>Nevyřazeno</TD>";
                    else      
                        echo "<TD align = 'center'>".$radek["Datum_vyrazeni"]. "</TD>";

                    echo "<TD align = 'center'>".$radek["Pocet_kusu"]. "</TD>
                    <TD align = 'center'>".$radek["Prodejce"]. "</TD>";
                    
                    if ($_SESSION["level"] == 1)
                    echo "
                    <TD align = 'right'>
                    <a href='#myModalupdate' type='button' data-id='$oc' name='edit' class='open-UpdateObjectDialog btn btn-primary glyphicon glyphicon-cog' data-toggle='modal'></a>        
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <A href='#myModaldelete' type='button' data-id='$oc' class='open-DeleteObjectDialog btn btn-primary glyphicon glyphicon-trash' data-toggle='modal'></A></TD>";


                    $i=$i+1;

                endwhile;
            }
            else
            {
                echo "<TR><TD ALIGN=center COLSPAN=10> 0 nalezených objektů</TD></TR>";
            }
            echo"</TABLE>";


            mysqli_close($spojeni);?>

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
                    <form ACTION=../Sources/Scripty/delete_o.php method=POST>
                        <input id=skryteid type=hidden name=idcko value=$idcko>
                        <input type='submit' class='btn btn-danger' value='Smazat'>
                        <button type='button' class='btn btn-info' data-dismiss='modal'>Zrušit</button>
                    </form>
                    <br>                                                                                                                                 
			     </div>
		      </div>
	       </div>
        </div>";?>


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
				    <h4 class='modal-title'>Přidat předmět</h4>	
			     </div>
			     
                 <div class='modal-body'>
                    <form action='../Sources/Scripty/insert_o.php' method='post'>
                        <table>
                            <TR><TD class='levy_sloupec'>Název:<TD>                                             <INPUT required NAME=nazev             PLACEHOLDER='  Název objektu  '>
                            <TR><TD class='levy_sloupec'>Druh majetku:<TD>      <label class='radion-inline'>   <INPUT type='radio' required NAME=druh_majetku value='0'>Nehmotný</label>&nbsp;&nbsp;&nbsp;
                                                                                <label class='radion-inline'>   <INPUT type='radio' required NAME=druh_majetku value='1'>Hmotný</label>
                            <TR><TD class='levy_sloupec'>Záruční doba:<TD>                                      <INPUT required NAME=zarucni_doba      PLACEHOLDER='  Zadejte počet let  '>
                            <TR><TD class='levy_sloupec'>Cena (Kč):<TD>                                         <INPUT required NAME=cena              PLACEHOLDER='  Cena za kus  '> 
                            <TR><TD class='levy_sloupec'>Datum pořízení:<TD>                                    <INPUT type='date' required NAME=datum_porizeni> 
                            <TR><TD class='levy_sloupec'>Datum vyřazení:<TD>                                    <INPUT type='date'  NAME=datum_vyrazeni> 
                            <TR><TD class='levy_sloupec'>Vyřazeno:<TD>          <label class='radion-inline'>   <INPUT type='radio' required NAME=vyrazeno value='0'>Nevyřazeno</label>&nbsp;&nbsp;&nbsp;
                                                                                <label class='radion-inline'>   <INPUT type='radio' required NAME=vyrazeno value='1'>Vyřazeno</label>
                            <TR><TD class='levy_sloupec'>Počet kusů:<TD>                                        <INPUT required NAME=pocet_kusu        PLACEHOLDER='  Počet kusů  '> 
                            <TR><TD class='levy_sloupec'>Prodejce<TD>                                           <INPUT required NAME=prodejce          PLACEHOLDER='  Prodejce objektu  '>  
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
        </div>";?>







        <!-- Modal update -->
        <?php                                                     
        echo "
        <div id='myModalupdate' class='modal fade'>
	       <div class='modal-dialog modal-confirm modal-update'>
		      <div class='modal-content'>
			     <div class='modal-header'>
				    <div class='icon-box'>
					   <i class='glyphicon glyphicon-cog'></i>
				    </div>				
				    <h4 class='modal-title'>Upravte hodnoty položky</h4>	
                
			     </div>
			
                 <div class='modal-body'>
			         <form method ='post' action='../Sources/Scripty/update_o.php'>
             
                    <table align='center'>                                                   
                        <TR><TD class='levy_sloupec'>Název:<TD>                                          <INPUT required NAME='nazev' id='nazev' class='form-control'/>
                        <TR><TD class='levy_sloupec'>Druh majetku:<TD>      <label class='radion-inline'><INPUT type='radio' required NAME='druh_majetku' id='druh_majetku_no' value='0'/>Nehmotný</label>&nbsp;&nbsp;&nbsp;
                                                                            <label class='radion-inline'><INPUT type='radio' required NAME='druh_majetku' id='druh_majetku_yes' value='1'/>Hmotný</label>
                        <TR><TD class='levy_sloupec'>Záruční doba:<TD>                                   <INPUT required NAME='zarucni_doba' id='zarucni_doba' class='form-control'/>
                        <TR><TD class='levy_sloupec'>Cena (Kč):<TD>                                      <INPUT required NAME='cena' id='cena' class='form-control'/> 
                        <TR><TD class='levy_sloupec'>Datum pořízení:<TD>                                 <INPUT type='date' required NAME='datum_porizeni' id='datum_porizeni' class='form-control'/> 
                        <TR><TD class='levy_sloupec'>Datum vyřazení:<TD>                                 <INPUT type='date'  NAME='datum_vyrazeni' id='datum_vyrazeni' class='form-control'/> 
                        <TR><TD class='levy_sloupec'>Vyřazeno:<TD>          <label class='radion-inline'><INPUT type='radio' required NAME='vyrazeno' id='vyrazeno_no' value='0' />Nevyřazeno</label>&nbsp;&nbsp;&nbsp;
                                                                            <label class='radion-inline'><INPUT type='radio' required NAME='vyrazeno' id='vyrazeno_yes' value='1' />Vyřazeno</label>
                        <TR><TD class='levy_sloupec'>Počet kusů:<TD>                                     <INPUT required NAME='pocet_kusu' id='pocet_kusu' class='form-control'/> 
                        <TR><TD class='levy_sloupec'>Prodejce<TD>                                        <INPUT required NAME='prodejce' id='prodejce' class='form-control'/>  
                     
                         <input type='hidden'  name=idcko id=idcko>
                     </table>

                 </div>
			     
                 <div class='modal-footer'>
                        <input id='submit_upadte' type='submit' class='btn btn-info' value='Upravit'>
                        <button type='button' class='btn' data-dismiss='modal'>Zrušit</button>
                    </form>
                    <br>                                                                                                                                           
			     </div>
		      </div>
	       </div>
        </div>";?>

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

// Kontrola datum
$(document).on('click', '#submit_upadte', function()
{
    var startDate = document.getElementById("datum_porizeni").value;
    var endDate = document.getElementById("datum_vyrazeni").value;

    if ((Date.parse(startDate) > Date.parse(endDate))) 
    {
        alert("Datum odebrání musí být vyšší než datum přidání");
        $('#datum_vyrazeni').val(startDate);
        document.getElementById("EndDate").value = "";

    }
});

// Dialogové okno pro mazání objektů
$(document).on("click", ".open-DeleteObjectDialog", function (){
    var ObjectId = $(this).data('id');
    $(".modal-footer #skryteid").val( ObjectId );
});

// Dialogové okno pro update knihy
$(document).on('click', '.open-UpdateObjectDialog', function()
{
    var ObjectId = $(this).attr('data-id');
    
    $.ajax({
        url:"fetch.php", //korenovy adresar dovoluje odkazovat pouze do stejne slozky
        method:"POST",
        data: {ObjectId: ObjectId},
        dataType:"json",
        success:function(data)
        { 
            $('#idcko').val(data.Id);
            $('#nazev').val(data.Nazev);
                    
            if (data.Druh_majetku == 0)
                $("#druh_majetku_no").attr('checked', true);
            else
                $("#druh_majetku_yes").attr('checked', true);
                      
                $('#zarucni_doba').val(data.Zarucni_doba);
                $('#cena').val(data.Cena);
                $('#datum_porizeni').val(data.Datum_porizeni);
                $('#datum_vyrazeni').val(data.Datum_vyrazeni);
    
                if (data.Vyrazeno == 0)
                    $("#vyrazeno_no").attr('checked', true);
                else
                    $("#vyrazeno_yes").attr('checked', true);
                    
                $('#pocet_kusu').val(data.Pocet_kusu);
                $('#prodejce').val(data.Prodejce);
                $('#myModalupdate').modal('show'); 

                     
                }/*,
                
                //Kontrolní akce
                error: function(jqXHR, textStatus, errorThrown) 
                {
                        alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                        $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                        console.log('jqXHR:');
                        console.log(jqXHR);
                        console.log('textStatus:');
                        console.log(textStatus);
                        console.log('errorThrown:');
                        console.log(errorThrown);
                }
                */     
          });
}); 

</script>