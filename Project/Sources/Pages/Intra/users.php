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
        <title>Intra - administrace</title>
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
            <h1>Administrace</h1>
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

        <div class="container-fluid">
            <?php
            $sql = "SELECT * FROM ZAMESTNANEC";
            $vysledek = mysqli_query($spojeni, $sql);

            echo "<TABLE class = 'table table-hover'>

            <TR class='hlavicka_tabulky'>
            <TH>Rodné číslo</TH>\n
            <TH>Jméno</TH>\n
            <TH COLSPAN=3>Adresa</TH>\n
            <TH>Email</TH>\n
            <TH>Telefon</TH>\n
            <TH COLSPAN = 3> Akce</TH>
            </TR>
            <TR>
                <TD COLSPAN = 3>
                    <form method='post' action='../Sources/Scripty/export.php'>
                        <input type='submit' name='export' class='btn btn-primary' value='Export'>
                        <input type='hidden' name='soubor' value='Zamestnanec'>
                        <input type='hidden' name='tabulka' value='ZAMESTNANEC'>
                    </form> 
                </TD>
            
            
            <TD COLSPAN = 4>&nbsp;</TD>
            <TD align = right><A href='#myModaladd' type='button' class='AddUserDialog btn btn-primary glyphicon glyphicon-plus' data-toggle='modal'></A></TD>
            </TR>";
            
            if (mysqli_num_rows($vysledek) > 0)
                   {
                        while ($radek = mysqli_fetch_assoc($vysledek)):


                            if (($i%2)==1)
                            {
                                echo "<TR class='sude_radky'>";
                            }
                            else
                                echo "<TR>";
                                
                                $oc=$radek["Rc"];
                                
                                $sqlnd = "SELECT Login FROM UCET NATURAL JOIN ZAMESTNANEC WHERE Rc = '".$radek["Rc"]."'";
                                $vysledeknd = mysqli_query($spojeni, $sqlnd);
                                $radeknd = mysqli_fetch_assoc($vysledeknd);
                                //Je zde náhled pro zobrazení informací

                                echo "<TD  align = 'center'>".$radek["Rc"]. "</TD>
                                <TD  align = 'center'>".$radek["Jmeno"]. "</TD>
                                <TD  colspan ='3' align = 'center'>".$radek["Adresa"]. ", " .$radek["Mesto"]. " " .$radek["Psc"]. "</TD>
      
                                <TD  align = 'center'>".$radek["Email"]. "</TD>
                                <TD  align = 'center'>".$radek["Telefon"]. "</TD>
                                <TD align = 'right'>";
                                
                                if ($radeknd['Login'] != null)
                                    echo "<a href='#myModaldetail' type='button' data-id='$oc' name='edit' class='open-DetailUserDialog btn btn-primary glyphicon glyphicon glyphicon-eye-open' data-toggle='modal'></a>";
                                
                                echo "&nbsp;&nbsp;
                                <a href='#myModalupdate' type='button' data-id='$oc' name='edit' class='open-UpdateUserDialog btn btn-primary glyphicon glyphicon-cog' data-toggle='modal'></a>          
                                &nbsp;&nbsp;
                                <A href='#myModaldelete' type='button' data-id='$oc' class='open-DeleteUserDialog btn btn-primary glyphicon glyphicon-trash' data-toggle='modal'></A></TD>";
                                
                                $i=$i+1;


                        endwhile;
	               }
                   
                   else
                   {
                        echo "<TR><TD ALIGN=center COLSPAN=10> 0 nalezených zaměstnanců</TD></TR>";
                    }
                    
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
                <form ACTION=../Sources/Scripty/delete_u.php method=POST>
                <input id=skryterc type=hidden name=rccko value=$rccko>
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
	       			<h4 class='modal-title'>Přidat uživatele</h4>	
                
		      	 </div>
			     
                 <div class='modal-body'>
                    <form action='../Sources/Scripty/insert_u.php' method='post'>
                    <table>
                        <TR><TD class='levy_sloupec'>Rodné číslo:<TD>		   <INPUT required NAME='rccko' PLACEHOLDER='  Rodné číslo  '>
                        <TR><TD class='levy_sloupec'>Jméno:<TD>                <INPUT required NAME='jmeno' PLACEHOLDER='  Jméno a příjmení  '>
                        <TR><TD class='levy_sloupec'>Adresa:<TD>		       <INPUT required NAME='adresa' PLACEHOLDER='  Adresa  '>
                        <TR><TD class='levy_sloupec'>Město:<TD>		           <INPUT required NAME='mesto' PLACEHOLDER='  Město  '>
                        <TR><TD class='levy_sloupec'>PSČ:<TD>		           <INPUT required NAME='psc' PLACEHOLDER='  PSČ  '>
                        <TR><TD class='levy_sloupec'>Email:<TD>		           <INPUT required NAME='email' PLACEHOLDER='  Emailová adresa  '>
                        <TR><TD class='levy_sloupec'>Telefon:<TD>		       <INPUT required NAME='telefon' PLACEHOLDER='  Telefonní číslo  '>
                        <TR><TD class='levy_sloupec'>Datum přijetí:<TD>		   <INPUT required NAME='datum_prijeti' type='date' >
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
			         <form method ='post' action='../Sources/Scripty/update_u.php'>
                     
                        <table align='center'>
                            <TR><TD class='levy_sloupec'>Rodné číslo:	       <TD><input required name='rccko_new'                  id='rccko_new'          SIZE=30 class='form-control'/>
                            <TR><TD class='levy_sloupec'>Jméno:	               <TD><input required name='jmeno'                      id='jmeno'              SIZE=30 class='form-control'/>
                            <TR><TD class='levy_sloupec'>Adresa:               <TD><input required NAME='adresa'                     id='adresa'             SIZE=30 class='form-control'/>
                            <TR><TD class='levy_sloupec' >Město:               <TD><input required NAME='mesto'                      id='mesto'              SIZE=30 class='form-control'/>
                            <TR><TD class='levy_sloupec'>PSČ:                  <TD><input required NAME='psc'                        id='psc'                SIZE=30 class='form-control'/>
                            <TR><TD class='levy_sloupec'>Email:                <TD><input required NAME='email'                      id='email'              SIZE=30 class='form-control'/>
                            <TR><TD class='levy_sloupec'>Telefon:              <TD><input required NAME='telefon'                    id='telefon'            SIZE=30 class='form-control'/>
                            <TR><TD class='levy_sloupec'>Datum přijetí:        <TD><input required NAME='datum_prijeti' type='date'  id='datum_prijeti'      SIZE=30 class='form-control'/>
                     
                            <input type='hidden'  name='rccko' id='rccko'>
                        </table>

                 </div>
                 
			     <div class='modal-footer'>
                        <input type='submit' class='btn btn-info' value='Upravit'>
                        <button type='button' class='btn' data-dismiss='modal'>Zrušit</button>
                    </form>
                    <br>                                                                                                                                           
			     </div>
		      </div>
	       </div>
        </div>";?>



        <!-- Modal detail -->
        <?php                                                     
        echo "
        <div id='myModaldetail' class='modal fade'>
	       <div class='modal-dialog modal-confirm modal-info'>
		      <div class='modal-content'>
			     <div class='modal-header'>
				    <div class='icon-box'>
					   <i class='glyphicon glyphicon glyphicon glyphicon-user'></i>
				    </div>				
				    <h4 class='modal-title'>Informace o autorovi</h4>	
                 </div>
                 
			     <div class='modal-body'>
			         <form method ='post' action='../Sources/Scripty/update_u.php'>
                        <table align='center'>
                            <TR><TD class='levy_sloupec form-control'>Login:         <TD><input name='login'       id='login'      size='17'       disabled class='form-control'/>
                            <TR><TD class='levy_sloupec form-control'>Heslo:         <TD><input name='heslo'       id='heslo'      size='17'       disabled class='form-control'/>
                            <TR><TD class='levy_sloupec form-control'>Oprávnění:     <TD><input name='opravneni'   id='opravneni'  size='17'       disabled class='form-control'/>
                            <TR><TD class='levy_sloupec form-control'>Založeno:      <TD><input name='zalozeni'    id='zalozeni'   type='date'     disabled class='form-control'/>
                        </table>

                 </div>
                 
			     <div class='modal-footer'>
                    <button type='button' class='btn btn-info' data-dismiss='modal'>Zavřít</button>
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
        function openNav() 
        {
        document.getElementById("mySidenav").style.width = "14%";
        }

        // Zavřít postranní menu
        function closeNav() 
        {
        document.getElementById("mySidenav").style.width = "0";
        }
        
        // Dialogové okno pro mazání uživatelů
        $(document).on("click", ".open-DeleteUserDialog", function ()  
        {
            var myUserId = $(this).data('id');
            $(".modal-footer #skryterc").val( myUserId );
        });
        
        // Dialogové okno pro update uživatele
            $(document).on('click', '.open-UpdateUserDialog', function(){
            var UserId = $(this).attr('data-id');
           
            // Plnění dialogového okna pro update knihy
            $.ajax({
                url:"fetch.php", //Kořenový adresář umožňuje link pouze na soubory ve stejné složce
                method:"POST",
                data: {UserId: UserId},
                dataType:"json",
                success:function(data)
                { 
                     $('#rccko').val(data.Rc);
                     $('#rccko_new').val(data.Rc);
                     $('#jmeno').val(data.Jmeno);
                     $('#adresa').val(data.Adresa);
                     $('#mesto').val(data.Mesto);
                     $('#psc').val(data.Psc);
                     $('#email').val(data.Email);
                     $('#telefon').val(data.Telefon);
                     $('#datum_prijeti').val(data.Datum_prijeti);
                     $('#myModalupdate').modal('show'); 

                     
                }/*,
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
                }*/    
            });
            });
            
            
            
            
            // Dialogové okno pro detail účtu
            $(document).on('click', '.open-DetailUserDialog', function(){
            var UserId = $(this).attr('data-id');

            // Plnění dialogového okna pro update knihy
            $.ajax({
                url:"fetch.php", //Kořenový adresář umožňuje link pouze na soubory ve stejné složce
                method:"POST",
                data: {UserIdAcc: UserId},
                dataType:"json",
                success:function(data)
                { 
                     $('#login').val(data.Login);
                     $('#heslo').val(data.Heslo);
                     if (data.Opravneni == "1")
                     $('#opravneni').val("Administrátor");
                     else
                     $('#opravneni').val("Zaměstnanec");
                     $('#zalozeni').val(data.Zalozeni);
                     $('#myModaldetail').modal('show'); 

                     
                }/*,
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
                }*/     
            });
            });
 </script>