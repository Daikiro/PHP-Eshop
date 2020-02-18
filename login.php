<?php require("connect.php"); ?>

<?php 
   
   session_start();
        
   if($_SESSION["error"] == true)
   { 
   
     $message = "Chybně jste zadali přihlašovací údaje.\\nZkuste to znovu.";
     echo "<script type='text/javascript'>alert('$message');</script>";
    } 
?>
 
<!DOCTYPE html>
<html>
 <head>
   <title>Intra - Login</title>
   <meta http-equiv="content-type" content="text/html; charset=UTF8"/>

    <meta lang="cs" name="author" content="Lukas Jirka">
    <meta name="description" content="Eshop knihy"/>
    <meta name="keywords" content="Eshop, knihy">
    <link rel="shortcut icon" href="./Project/Sources/Images/Ico.ico"/>
   <?php include("./Project/Sources/Bootstrap/bootstrap.php") ?>
    <link href="./Project/Sources/Style/style.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<BODY>
<div class="text-center nadpis">
  <h1>Ukázka PHP Eshopu</h1>
</div>

<div class="container">


  <div class="row">
    <div class="col-sm-4">
    
    </div>
    <div class="col-sm-4">
      <form action="./Project/protection.php" method="post">
        <table">
          <tr>
            <td>
              <h2> Účet </h2>
            </td>
            <td>
              <input type="text" name="user" size=40/>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <?php echo "<hr>"; ?>
            </td>
          </tr>
          <tr>
            <td>
              <h2> Heslo </h2>
            </td>
            <td>
              <input type="password" name="passwd" size=40/>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <?php echo "<hr>"; ?>
            </td>
          </tr>
          <tr>
            <td>
              <input id="login" type="submit" value="Přihlásit"/>
            </td>
            <td>
            </td>
          </tr>

        </table>
      </form>
    </div>
    <div class="col-sm-4">

    </div>
    
  </div>
</div>





 </body>
</html>
