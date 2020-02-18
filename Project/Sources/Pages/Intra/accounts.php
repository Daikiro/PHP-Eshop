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
        <title>Intra - účty</title>
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
            <h1>Správa účtů</h1>
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

        <div class="container-fluid">

            <?php
            $sql = "SELECT * FROM UCET";
            $vysledek = mysqli_query($spojeni, $sql);

            echo "<table class = 'table table-hover'>

            <TR class='hlavicka_tabulky'>
                <TH>Login</TH>\n
                <TH>Rodné číslo</TH>\n
                <TH>Oprávnění</TH>\n
                <TH>Datum založení</TH>\n
                <TH> Akce</TH>
            </TR>
            
            <TD COLSPAN = 4>&nbsp;</TD>
            <TD align ='center'><A href='#myModaladd' type='button' class='AddAccDialog btn btn-primary glyphicon glyphicon-plus' data-toggle='modal'></A></TD>";
            
            if (mysqli_num_rows($vysledek) > 0)
            {
                    while ($radek = mysqli_fetch_assoc($vysledek)):
                        if (($i%2)==1)
                            echo "<TR class='sude_radky'>";
                        else
                             echo "<TR>";
                        $oc=$radek["Login"];
                                
                        //Je zde náhled pro zobrazení informací

                        echo "<TD  align = 'center'>".$radek["Login"]. "</TD>";
                        
                        if ($radek["Rc"] == null)
                            echo "<TD  align = 'center'>Nepřiřazen</TD>";
                        else
                            echo "<TD  align = 'center'>".$radek["Rc"]. "</TD>";
                        
                        if ($radek["Opravneni"] == 1)
                            echo "<TD  align = 'center'>Administrátor</TD>";
                        else
                            echo "<TD  align = 'center'>Zaměstnanec</TD>";
                        
                        echo "
                        <TD  align = 'center'>".$radek["Zalozeni"]. "</TD>
                                 
                        <TD align = 'center'>"."
                        <a href='#myModalupdate' type='button' data-id='$oc' class='open-UpdateAccDialog btn btn-primary glyphicon glyphicon-cog' data-toggle='modal' name='edit'></a>          
                        &nbsp;&nbsp;
                        <A href='#myModaldelete' type='button' data-id='$oc' class='open-DeleteAccDialog btn btn-primary glyphicon glyphicon-trash' data-toggle='modal'></A></TD>";
                        
                        $i=$i+1;


                    endwhile;
	        }
            else
            {
                echo "<TR><TD ALIGN=center COLSPAN=10> 0 nalezených zaměstnanců</TD></TR>";
            }
                    
            echo"</table>";

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
				    <h4 class='modal-title'>Chcete smazat tento účet?</h4>	
                 </div>
		
                <div class='modal-body'>
				    <p>Tento proces nelze vrátit.</p>
			    </div>
			
                <div class='modal-footer'>
                <form ACTION=../Sources/Scripty/delete_a.php method=POST>
                <input id=skrytelogin type=hidden name=login value=$login>
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
	       			<h4 class='modal-title'>Přidat uživatelský účet</h4>	
                
		      	</div>
			     <div class='modal-body'>";
                                 
                echo "<FORM ACTION='../Sources/Scripty/insert_a.php' METHOD='POST'>

                <table>
                    <TR><TD class='levy_sloupec'>Login:<TD>		   <INPUT required  NAME='login'        PLACEHOLDER='  Přihlašovací jméno  '>
                    <TR><TD class='levy_sloupec'>Heslo:<TD>        <INPUT required  NAME='heslo'        type='password' PLACEHOLDER='  Přihlašovací heslo  '>
                    <TR><TD class='levy_sloupec'>Oprávnění:<TD>	   <INPUT required  NAME='opravneni'    PLACEHOLDER='  Úroveň oprávnění  '>
                    <TR><TD class='levy_sloupec'>Založení:<TD>	   <INPUT required  NAME='zalozeni'     type='date'>
                </table>";

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
					   <i class='glyphicon glyphicon-cog'></i>
				    </div>				
				    <h4 class='modal-title'>Upravte hodnoty účtu</h4>	
                
			     </div>
			
                 <div class='modal-body'>
			         <form method ='post' action='../Sources/Scripty/update_a.php'>
             
                    <table align='center'>                                                   
                        <TR><TD class='levy_sloupec'>Login:<TD>                                   <INPUT required    NAME='login'       id='login'      class='form-control'/>
                        <TR><TD class='levy_sloupec'>Heslo:<TD>                                   <INPUT NAME='heslo'       id='heslo' PLACEHOLDER='  Zadejte nové heslo  '     class='form-control'/>"; 
                       
                        require("../../connect.php");
                        //Rodne cisla
                        $sql = 'SELECT * from ZAMESTNANEC';
                        $vysledek = mysqli_query($spojeni, $sql);

                        echo "<TR><TD class='levy_sloupec'>Rodné číslo:<TD>";
                        echo "<select size='1' name='rc' id='rc'>";                                      
                        echo "<option value='bez_vlastnika'>Bez vlastníka</option>";
                        while ($vyber = mysqli_fetch_assoc($vysledek)):    
                            echo "<option value=".$vyber['Rc'].">".$vyber['Jmeno']."</option>";
                        endwhile;
                        mysqli_close($spojeni);
                        echo "</select>
                        
                        <TR><TD class='levy_sloupec'>Oprávnění:<TD>                               <INPUT required    NAME='opravneni'   id='opravneni'  class='form-control'/> 
                        <TR><TD class='levy_sloupec'>Datum založení:<TD>                          <INPUT type='date' NAME='datum'       id='datum'      class='form-control'/> 
                        <input type='hidden' name='puvodni_login' id='puvodni_login'>
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
        // Otevřít postranní okno
        function openNav() 
        {
        document.getElementById("mySidenav").style.width = "14%";
        }

        // Zavřít postranní okno
        function closeNav() 
        {
        document.getElementById("mySidenav").style.width = "0";
        }
        
        // Dialogové okno pro mazání uživatelů
        $(document).on("click", ".open-DeleteAccDialog", function ()  
        {
            var myLoginId = $(this).data('id');
            $(".modal-footer #skrytelogin").val( myLoginId );
        });
        
 
        // Dialogové okno pro update knihy
        $(document).on('click', '.open-UpdateAccDialog', function()
        {
            var Login = $(this).attr('data-id');
        
            $.ajax({
                url:"fetch.php", //korenovy adresar dovoluje odkazovat pouze do stejne slozky
                method:"POST",
                data: {Login: Login},
                dataType:"json",
                success:function(data)
                { 
                    $('#login').val(data.Login);
                    $('#puvodni_login').val(data.Login);
                    if (data.Rc == null)
                        $('#rc').val("bez_vlastnika");
                    else
                        $('#rc').val(data.Rc); 
                        
                    $('#opravneni').val(data.Opravneni);
                    $('#datum').val(data.Zalozeni);
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