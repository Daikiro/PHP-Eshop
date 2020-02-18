<?php
 
    if(isset($_POST["export"]))
    {   
    
       require("./tfpdf/tfpdf.php");
        
        $connect = mysqli_connect("localhost","jirka01","52564310","jirka01");
        mysqli_set_charset($connect, "utf8");
        
        
        $tabulka = $_POST["tabulka"];
        $soubor = $_POST["soubor"];
        
        if(isset($_POST["oznaceni_faktury"]))
        {
          $oznaceni = $_POST["export"];
          $query = "SELECT * FROM " . $tabulka . " WHERE Id_faktury = '" .$oznaceni."'";
        }
        else
        {
          $query = "SELECT * FROM " . $tabulka ;
        }
        
        
        
        $result = mysqli_query($connect, $query);
                 
        $pdf = new tFPDF();
        $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
        $pdf->AddFont('DejaVuBold','','DejaVuSans-Bold.ttf',true);
        $pdf->SetFont('DejaVu','',13);
        $pdf->AddPage();
        $pdf->Image('../Images/Logo.png',10,5,-300);
        
        switch ($tabulka)
        {
        
        /*
        case "KNIHA":
            $pdf->Write(8,"# || Název || Autor || Kategorie || Jazyk || Cena || Vazba || Rok vydání || Vydal || Stav");
	       	$pdf->Ln();
            $pdf->Ln(); 
		
    	    while($radek=mysqli_fetch_row($result))
	       { 
            $pdf->Write(8,$radek[0] ." || ". $radek[1] ." || ". $radek[2] ." || ". $radek[3] ." || ". $radek[4] ." || ". $radek[5] ." || ". $radek[6] ." || ". $radek[7] ." || ". $radek[8] ." || ". $radek[9]);
            
    		$pdf->Ln();
            $pdf->Ln();
	       }
        break;
        */
        case "FINANCE":	
    	    while($radek=mysqli_fetch_row($result))
	       { 
             $pdf->SetXY(115, 0);            
            $pdf->Write(20,"FAKTURA číslo ". $radek[0] ." - DAŇOVÝ DOKLAD"); 
            
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
            $pdf->Write(8,"pobočka Jihlava"); 
            $pdf->Ln();
            
            $pdf->SetXY(20, 43);
            $pdf->Write(8,"Tolstého 1556/16, 586 01 Jihlava"); 
            $pdf->Ln();
            
            $pdf->SetXY(20, 48);
            $pdf->Write(8,"IČ: XXXXXXXX, DIČ: CZXXXXXXXX"); 
            $pdf->Ln();
            $pdf->Ln();
            
            $pdf->Write(5,"Datum vystavení:         " . date('d.m.Y', strtotime($radek[6])));
            $pdf->Ln();
            $pdf->Write(5,"Datum zdanit. plnění:   " . date('d.m.Y', strtotime($radek[6])));
            $pdf->Ln();
            $pdf->Write(5,"Splatnost:                     " . date('d.m.Y', strtotime(''.$radek[6].' + 14 days')));
    
    
            // Pravá strana vršek
    
            $pdf->SetXY(110, 33);
            $pdf->Write(8,"Banka:                                     Soukromá Banka Kč"); 
            $pdf->SetXY(110, 38);
            $pdf->Write(8,"Číslo účtu:                                    03050103/ 0XXX"); 
            $pdf->SetXY(110, 43);
            $pdf->Write(8,"Variabilní symbol:                                            " . $radek[0]);
            $pdf->SetXY(110, 48);
            $pdf->Write(8,"Konstantní symbol:                                         0008");
            
            
            // Příkaz pro vyhledání pravého jména zadavatele
                          
            $sql_login = "SELECT Jmeno FROM ZAMESTNANEC NATURAL JOIN UCET WHERE Login = '$radek[7]' limit 1"; 
            $result_login = mysqli_query($connect,$sql_login);
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
            
            
            $sql_kniha = "SELECT Nazev,Stav FROM KNIHA WHERE Id = '$radek[1]' limit 1"; 
            $result_kniha = mysqli_query($connect,$sql_kniha);
            $value_kniha = mysqli_fetch_object($result_kniha);
            $Nazev_kniha =  $value_kniha->Nazev;
            $Stav_kniha = $value_kniha->Stav;
            
            $pdf->Cell(65,10,'Název produktu',1,0,C,true,'');
            $pdf->Cell(20,10,'Počet',1,0,C,true,'');
            $pdf->Cell(35,10,'Cena bez DPH',1,0,C,true,'');
            $pdf->Cell(30,10,'DPH',1,0,C,true,'');
            $pdf->Cell(30,10,'Celkem',1,0,C,true,'');
            $pdf->Ln();
            
            $pdf->SetLineWidth(0.2);
            $pdf->SetFont('DejaVu','',9);
            $pdf->Cell(65,10,$Nazev_kniha . " - "  . $Stav_kniha ,1,0,C,true,'');
            $pdf->Cell(20,10,1,1,0,C,true,'');
            $pdf->Cell(35,10,$radek[3],1,0,C,true,'');
            $pdf->Cell(30,10,$radek[5],1,0,C,true,'');
            $pdf->Cell(30,10,$radek[4],1,0,C,true,'');
            
            
            $pdf->SetLineWidth(0);
            $pdf->SetFont('DejaVuBold','',10);
            
            $pdf->SetXY(10, 230);
            $pdf->Cell(70,10,'Celková hodnota faktury v Kč:',1,0,L,true,'');
            $pdf->Cell(40,10,$radek[4],1,0,R,true,'');
            $pdf->Ln();
            
            $pdf->SetFont('DejaVu','',10);
            $pdf->Cell(70,10,'Již zaplaceno:',1,0,L,true,'');
            $pdf->Cell(40,10,'0',1,0,R,true,'');
            $pdf->Ln();
            
            
            $pdf->SetFont('DejaVuBold','',10);
            $pdf->Cell(70,10,'Celkem k úhradě:',1,0,L,true,'');
            $pdf->Cell(40,10,$radek[4],1,0,R,true,'');
            $pdf->Ln();
           
           
           
           
           
           
           
           /*
           
            $pdf->SetXY(115, 0);            
            $pdf->Write(20,"FAKTURA číslo ". $hodnota ." - DAŇOVÝ DOKLAD"); 
            
            $pdf->Ln(); 
            $pdf->SetFont('DejaVu','',11);
            $pdf->SetXY(115, 6);
            $pdf->Write(20,"SLOUŽÍ JAKO DODACÍ A ZÁRUČNÍ LIST");
            $pdf->Ln(); 
            $pdf->Line(10, 22, 195, 22);
            $pdf->SetFont('DejaVu','',10);
            
                 
            $pdf->Write(8,"ID faktury: " . $radek[0]); 
            $pdf->Ln();
            $pdf->Ln();
    
            $pdf->Write(8,"ID knihy: " . $radek[1]); 
            $pdf->Ln();
            $pdf->Ln();
    
            if ($radek[2] == 1)
                $pdf->Write(8,"Druh záznamu: Prodej"); 
            else
                $pdf->Write(8,"Druh záznamu: Nákup"); 
            
            $pdf->Ln();
            $pdf->Ln();
    
            $pdf->Write(8,"Cena bez DPH: " . $radek[3] . " Kč"); 
            $pdf->Ln();
            $pdf->Ln();
    
            $radek[5] = $radek[5] * 100;
            $pdf->Write(8,"DPH: " . $radek[5] . "%"); 
            $pdf->Ln();
            $pdf->Ln();
            
            $pdf->Write(8,"Cena s DPH: " . $radek[4] . " Kč"); 
            $pdf->Ln();
            $pdf->Ln();
    
            $pdf->Write(8,"Datum: " . $radek[6]); 
            $pdf->Ln();
            $pdf->Ln();
    
            $pdf->Write(8,"Účet zadavatele: " . $radek[7]); 
            $pdf->Ln();
            $pdf->Ln();
            */
            
            
            
    		$pdf->Ln();
            $pdf->Ln();
	       }
        break;
        
        
        case "ZAMESTNANEC":
        
            $pdf->SetXY(115, 0);            
            $pdf->Write(20,"Export zaměstnanců"); 
            
            $pdf->Ln(); 
            $pdf->SetFont('DejaVu','',11);
            $pdf->SetXY(115, 6);
            $pdf->Write(20,"Všichni zaměstnanci v seznamu");
            $pdf->Ln(); 
            $pdf->Line(10, 22, 195, 22);
            $pdf->SetFont('DejaVu','',10);
            
            
            $pdf->Write(8,"RC | Jméno | Adresa | Město | Psč");
	       	$pdf->Ln();
            $pdf->Write(8,"Email | Telefon | Datum přijetí");
            $pdf->Ln(); 
		    $pdf->Ln(); 
            
    	    while($radek=mysqli_fetch_row($result))
	       { 
            $pdf->Write(8,$radek[0] ." | ". $radek[1] ." | ". $radek[2] ." | ". $radek[3] ." | ". $radek[4]);
            $pdf->Ln();
            $pdf->Write(8,$radek[5] ." | ". $radek[6] ." | ". $radek[7]);
            
    		$pdf->Ln();
            $pdf->Ln();
	       }
        break;
        
        case "OBJEKT":
        {
        
            $pdf->SetXY(115, 0);            
            $pdf->Write(20,"Záloha objektu"); 
            
            $pdf->Ln(); 
            $pdf->Line(10, 22, 195, 22);
            $pdf->SetFont('DejaVu','',10);
            
            $pdf->SetXY(10, 24);
            $pdf->Write(8,"# | Název | Druh majetku | Záruční doba (roky) | Cena (Kč) | Datum pořízení/vyřazení | Počet (ks) | Vyřazeno | Prodejce");
	       	
            $pdf->Ln();
            $pdf->Ln(); 
		
    	    while($radek=mysqli_fetch_row($result))
	       { 
            
            
            
            $pdf->Write(8,$radek[0] ." | ". $radek[1] ." | ");
           
            if ($radek[2] == 0)
            $pdf->Write(8,"Nehmotný | ");
            else
            $pdf->Write(8,"Hmotný | ");
           
            $pdf->Write(8,$radek[3] ." | ". $radek[4] ." | ". $radek[5] ."/". $radek[6] ." | ". $radek[8] ." | ");
           
            if ($radek[7] == 0)
            $pdf->Write(8,"Nevyřazeno | ");
            else
            $pdf->Write(8,"Vyřazeno | ");
            $pdf->Ln();
            $pdf->Write(8,$radek[9]);
            
            
    		$pdf->Ln();
            $pdf->Ln();
	       }
        }
        break;
        }
        
         
        $filename = "Export_". $soubor . "_" . date('d_m_Y') . ".pdf";
	    $pdf->Output($filename,D);
             
    }  
?>








