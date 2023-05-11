<?php

session_start();

require_once('TCPDF/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array("210", "300"), true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('教室借用申請表.pdf');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
/*if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
}*/

// ---------------------------------------------------------

// set font
$pdf->SetFont('msungstdlight', '', 20);

// add a page
$pdf->AddPage();

$pdf->Cell(180, 30, "教室借用申請表", 1, 1, 'C');

$pdf->Cell(50, 30, "借用人學號", 1, 0, true);
$pdf->Cell(130, 30, $_SESSION['借用人學號'], 1, 1, true);

$pdf->Cell(50, 30, "借用人姓名", 1, 0, true);
$pdf->Cell(130, 30, $_SESSION['借用人姓名'], 1, 1, true);

$pdf->Cell(50, 30, "借用教室編號", 1, 0, true);
$pdf->Cell(130, 30, $_SESSION['教室編號'], 1, 1, true);

$pdf->Cell(50, 30, "借用日期", 1, 0, true);
$pdf->Cell(130, 30, $_SESSION['借用日期'], 1, 1, true);

$pdf->Cell(50, 30, "借用節數", 1, 0, true);
$pdf->Cell(130, 30, $_SESSION['借用節數'], 1, 1, true);

$pdf->Cell(50, 30, "附加申請設備", 1, 0, true);
$pdf->Cell(130, 30, $_SESSION['設備'], 1, 1, 'C');

$pdf->Cell(40, 30, "借用人簽章", 1, '', 'C');
$pdf->Cell(50, 30, "", 1);
$pdf->Cell(40, 30, "系辦簽章", 1, '', 'C');
$pdf->Cell(50, 30, "", 1);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('教室借用申請表.pdf', 'I');

?>
