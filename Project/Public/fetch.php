<?php
 //fetch.php
 
 require("../../connect.php");

  
 if(isset($_POST["BookId"]))
 {                                             
      $query = "SELECT * FROM KNIHA WHERE Id = '".$_POST["BookId"]."'";
      $result = mysqli_query($spojeni, $query);
      $row = mysqli_fetch_array($result);
      echo json_encode($row);
 } 
 
  if(isset($_POST["ObjectId"]))
 {                                             
      $query = "SELECT * FROM OBJEKT WHERE Id = '".$_POST["ObjectId"]."'";
      $result = mysqli_query($spojeni, $query);
      $row = mysqli_fetch_array($result);
      echo json_encode($row);
 } 
 if(isset($_POST["UserId"]))
 {                                             
      $query = "SELECT * FROM ZAMESTNANEC WHERE Rc = '".$_POST["UserId"]."'";
      $result = mysqli_query($spojeni, $query);
      $row = mysqli_fetch_array($result);
      echo json_encode($row);
 } 
 if(isset($_POST["UserIdAcc"]))
 {    
      $sql_up = "SELECT * FROM UCET NATURAL JOIN ZAMESTNANEC WHERE Rc = '".$_POST["UserIdAcc"]."'";                                         
      $result = mysqli_query($spojeni, $sql_up);
      $row = mysqli_fetch_array($result);
      echo json_encode($row);
 }
 if(isset($_POST["Login"]))
 {    
      $sql_up = "SELECT * FROM UCET WHERE Login = '".$_POST["Login"]."'";                                         
      $result = mysqli_query($spojeni, $sql_up);
      $row = mysqli_fetch_array($result);
      echo json_encode($row);
 } 
 
 
 ?>


