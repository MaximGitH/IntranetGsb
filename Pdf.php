<?php
function creerpdf ($etapepdf , $kmpdf , $nui , $rep , $mois , $montant , $nom , $prenom)
{
require('fpdf.php');
 
class PDF extends FPDF
{
//Page header
function Header()
    {
        //Arial bold 15
        $this->SetFont('Arial','B',15);
        //Move to the right
        $this->Cell(80);
        //Title
        $this->Ln(20);
        $this->Cell(40,10,'Recaputulatif des frais : PDF');
        //Line break
        $this->Ln(20);
    }

 
//Page footer
function Footer()
    {
        //Position at 1.5 cm from bottom
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','I',8);
        //Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

    }

}
 
//Instanciation of inherited class
    $pdf=new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->Image('images/logo2.png', 85, 2, 50, 30);

    $pdf->SetFont('Times','',15);
    $pdf->SetDrawColor(103); // Couleur du fond
    $pdf->SetFillColor(200); // Couleur des filets
    $pdf->SetTextColor(0); // Couleur du texte

    $pdf->Cell(158,8,$nom."  ".$prenom ,1,0,'L',1);
    $pdf->SetX(176); // 104 + 10
    $pdf->Cell(24,8,$mois,1,0,'C',1);
    $pdf->Ln(20); // Retour � la ligne



    $pdf->Cell(100,10,'Forfait etape',1,0,'C',1);
    $pdf->Cell(20,10,$etapepdf,1,0,'C');
    $pdf->SetX(40);
    $pdf->Ln(20);

    $pdf->Cell(100,10,'Forfait Kilometrique',1,0,'C',1);
    $pdf->Cell(20,10,$kmpdf,1,0,'C');
    $pdf->SetX(70);
    $pdf->Ln(20);

    $pdf->Cell(100,10,'Nuitee',1,0,'C',1);
    $pdf->Cell(20,10,$nui,1,0,'C');
    $pdf->SetX(100);
    $pdf->Ln(20);

    $pdf->Cell(100,10,'Forfait restaurant',1,0,'C',1);
    $pdf->Cell(20,10,$rep,1,0,'C');
    $pdf->Ln(20);


    $pdf->Cell(0,10,'montant total : '.$montant.' euro',1,0,'C',1);

        
    $pdf->Output();
    ob_end_flush();
}
?>