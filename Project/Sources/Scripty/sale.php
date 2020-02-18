<?php

  require("../../../connect.php");

  session_start();
  if ($_POST[typ_prikazu] == "zrusit_nakup")
  {
    $sql = "UPDATE KNIHA SET Prodano='0' WHERE Id='$_POST[idcko]'";  
    mysqli_query($spojeni, $sql);
    
    
     // Vybere id faktury, které je přiřazena daná kniha
     $sql_up = "SELECT Id_faktury FROM FINANCE WHERE Id_knihy = '$_POST[idcko]'";
     $vysledek = mysqli_query($spojeni, $sql_up);
     $radek = mysqli_fetch_assoc($vysledek);
    
    // Smazání faktury
     $sql = "DELETE FROM FINANCE WHERE Id_faktury='$radek[Id_faktury]'";
     $vysledek = mysqli_query($spojeni, $sql);    
     
     header("Location: ../../Public/index.php?a=4");
  }

  if ($_POST[typ_prikazu] == "potvrdit_nakup")
  {

    $sql = "UPDATE KNIHA SET Prodano='1' WHERE Id='$_POST[idcko]'";  
  
    mysqli_query($spojeni, $sql);
  
    $cena_bez_dph = $_POST[prodejni_cena];
    $cena_s_dph = $cena_bez_dph + $cena_bez_dph*0.21;
    $datum = date("Y-m-d H:i:s");
  
    // Vložení faktury do tabulky finance
    $sql = "INSERT INTO FINANCE (Id_knihy,Druh_polozky,Cena_bez_dph,Cena_s_dph,DPH,Datum,Zadavatel) values ('$_POST[idcko]','1','$cena_bez_dph','$cena_s_dph','0.21','$datum','$_POST[zadavatel]')";
    mysqli_query($spojeni, $sql);
    
    
    // Přidání hodnoty ID faktury do faktury
    $sql = "SELECT * FROM FINANCE WHERE Id_knihy = '$_POST[idcko]' limit 1"; 
    $result = mysqli_query($spojeni,$sql);
    $value = mysqli_fetch_object($result);
    $hodnota =  $value->Id_faktury;
    
    $datum = date('d.m.Y');
    
    require("./tfpdf/tfpdf.php");          
    $pdf = new tFPDF();
    $pdf->AddFont('DejaVuBold','','DejaVuSans-Bold.ttf',true);
    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    $pdf->SetFont('DejaVu','',13);
    $pdf->AddPage();
    $pdf->Image('../Images/Logo.png',10,5,-300);
  
    // Vkládání dat do faktury o knize
    $query = "SELECT * FROM KNIHA WHERE Id='$_POST[idcko]'";
    $result = mysqli_query($spojeni, $query);
  	
      	
        while($radek=mysqli_fetch_assoc($result))
        { 
            $pdf->SetXY(115, 0);            
            $pdf->Write(20,"FAKTURA číslo ". $hodnota ." - DAŇOVÝ DOKLAD"); 
            
            $pdf->Ln(); 
            $pdf->SetFont('DejaVu','',11);
            $pdf->SetXY(115, 6);
            $pdf->Write(20,"SLOUŽÍ JAKO DODACÍ A ZÁRUČNÍ LIST");
            $pdf->Ln(); 
            $pdf->Line(10, 22, 195, 22);
            $pdf->SetFont('DejaVu','',10);
             
            // Levá strana vršek
            $pdf->SetFont('DejaVuBold','',11);
            $pdf->Write(8,"Dodavatel: "); 
            $pdf->Ln();
            
            $pdf->SetFont('DejaVu','',11);
            $pdf->SetXY(20, 33);
            $pdf->Write(8,"Antikvariát LJ"); 
            $pdf->Ln();
            $pdf->SetFont('DejaVu','',10);
            
            $pdf->SetXY(20, 38);
            $pdf->Write(8,""); 
            $pdf->Ln();
            
            $pdf->SetXY(20, 43);
            $pdf->Write(8,""); 
            $pdf->Ln();
            
            $pdf->SetXY(20, 48);
            $pdf->Write(8,"IČ: XXXXXXXX, DIČ: CZXXXXXXXX"); 
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Write(5,"Datum vystavení:         " . $datum);
            $pdf->Ln();
            $pdf->Write(5,"Datum zdanit. plnění:   " . $datum);
            $pdf->Ln();
            $pdf->Write(5,"Splatnost:                     " . date('d.m.Y', strtotime(' + 14 days')));
    
    
            // Pravá strana vršek
    
            $pdf->SetXY(110, 33);
            $pdf->Write(8,"Banka:                                     Soukromá Banka Kč"); 
            $pdf->SetXY(110, 38);
            $pdf->Write(8,"Číslo účtu:                                    03050103/ 0XXX"); 
            $pdf->SetXY(110, 43);
            $pdf->Write(8,"Variabilní symbol:                                            " . $hodnota);
            $pdf->SetXY(110, 48);
            $pdf->Write(8,"Konstantní symbol:                                         0008");
    
    
            $sql_login = "SELECT Jmeno FROM ZAMESTNANEC NATURAL JOIN UCET WHERE Login = '".$_SESSION['user']."' limit 1"; 
            $result_login = mysqli_query($spojeni,$sql_login);
            $value_login = mysqli_fetch_object($result_login);
            $hodnota_login =  $value_login->Jmeno;
            
            $pdf->SetXY(110, 63);
            $pdf->Write(8,"Zadavatel: " .$hodnota_login);
    
    
            $pdf->Line(10, 81, 195, 81);
    
    
    
            $pdf->SetXY(20, 80);
            $pdf->Ln();
    
            $pdf->SetFillColor(255,255,255); // input R ,G , B 
            $pdf->SetTextColor(0,0,0);// input R , G , B 
            $pdf->SetDrawColor(0,0,0);// input R , G , B 
            $pdf->SetLineWidth(0.5);

            $pdf->SetFont('DejaVuBold','',11);
            
            
            $pdf->Cell(65,10,'Název produktu',1,0,C,true,'');
            $pdf->Cell(20,10,'Počet',1,0,C,true,'');
            $pdf->Cell(35,10,'Cena bez DPH',1,0,C,true,'');
            $pdf->Cell(30,10,'DPH',1,0,C,true,'');
            $pdf->Cell(30,10,'Celkem',1,0,C,true,'');
            $pdf->Ln();
            
            $pdf->SetLineWidth(0.2);
            $pdf->SetFont('DejaVu','',9);
            $pdf->Cell(65,10,$radek["Nazev"] . " - "  . $radek["Stav"] ,1,0,C,true,'');
            $pdf->Cell(20,10,1,1,0,C,true,'');
            $pdf->Cell(35,10,$radek["Cena"],1,0,C,true,'');
            $hodnota =  $value->DPH;
            $pdf->Cell(30,10,$hodnota,1,0,C,true,'');
            $hodnota =  $value->Cena_s_dph;
            $pdf->Cell(30,10,$hodnota,1,0,C,true,'');
            
            
            $pdf->SetLineWidth(0);
            $pdf->SetFont('DejaVuBold','',10);
            
            $pdf->SetXY(10, 230);
            $pdf->Cell(70,10,'Celková hodnota faktury v Kč:',1,0,L,true,'');
            $pdf->Cell(40,10,$hodnota,1,0,R,true,'');
            $pdf->Ln();
            
            $pdf->SetFont('DejaVu','',10);
            $pdf->Cell(70,10,'Již zaplaceno:',1,0,L,true,'');
            $pdf->Cell(40,10,'0',1,0,R,true,'');
            $pdf->Ln();
            
            
            $pdf->SetFont('DejaVuBold','',10);
            $pdf->Cell(70,10,'Celkem k úhradě:',1,0,L,true,'');
            $pdf->Cell(40,10,$hodnota,1,0,R,true,'');
            $pdf->Ln();
        }
            
    $filename = "Faktura knihy ". $_POST[idcko] . "_" . date('Y-m-d H:i:s') . ".pdf";
    $pdf->Output($filename,D);
  
  }
  
?>

