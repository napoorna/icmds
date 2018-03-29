<?php
require 'fpdf/fpdf.php';
class PDF extends FPDF{
  function Header(){

        $this->Image('ticket.png', 0, 0, 180, 122);

        $this->SetFont('Arial','',11);
        $this->Cell(25,23,'',0,1);
        $this->Cell(25,6,'',0,0);
        $this->Cell(25,6,'2017180210001',0,1);
        $this->Cell(25,3,'',0,1);
        $this->Cell(25,6,'',0,0);
        $this->Cell(25,5,'Dance Competition Kolkata',0,1);
        $this->Cell(25,5,'',0,0);
        $this->Cell(25,5,'Salt Lake Mall, Kolkata',0,1);
        $this->Cell(25,5,'',0,0);
        $this->Cell(25,5,'Wednesday 29 March 2018 - 13:30',0,1);
        $this->Cell(25,5,'',0,0);
        $this->Cell(25,5,'Shouvik Mohanta',0,1);
        $this->Cell(25,5,'',0,0);
        $this->Cell(25,5,'connectshouvik@gmail.com',0,1);
        $this->Cell(25,3,'',0,1);
        $this->Cell(25,6,'',0,0);
        $this->Cell(25,5,'$ 640',0,1);
        $this->Cell(25,6,'',0,0);
        $this->Cell(25,5,'6',0,1);


        $this->Cell(9,10,'',0,1);


        $this->Cell(10,5,'',0,0);
        $this->Cell(70,5,'First Class',0,0);
        $this->Cell(10,5,'x 3',0,0);
        $this->Cell(33,5,'',0,0);
        $this->Cell(37,5,'$ 300',0,1);

        $this->Cell(10,5,'',0,0);
        $this->Cell(70,5,'Second Class',0,0);
        $this->Cell(10,5,'x 2',0,0);
        $this->Cell(33,5,'',0,0);
        $this->Cell(37,5,'$ 140',0,1);

        $this->Cell(10,5,'',0,0);
        $this->Cell(70,5,'Third Class',0,0);
        $this->Cell(10,5,'x 4',0,0);
        $this->Cell(33,5,'',0,0);
        $this->Cell(37,5,'$ 200',0,1);

  }
}

        $pdf = new PDF('L','mm',array(180,122));
        $pdf->AddPage();

        $pdf->Output("folder/hello.pdf","F");

  ?>
