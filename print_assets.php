<?php
require('fpdf/fpdf.php');

// Function to generate PDF and print immediately
function generatePDFAndPrint($logoPath, $assetTags)
{
    // Create PDF object
    $pdf = new FPDF();
    
    // Add a new page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('Arial', '', 12);
    
    // Set logo
    $pdf->Image($logoPath, 10, 10, 30);
    
    // Set Y position for asset tags
    $yPosition = 50;
    
    // Output asset tags
    foreach ($assetTags as $assetTag) {
        $pdf->SetXY(50, $yPosition);
        $pdf->Cell(0, 10, $assetTag, 0, 1);
        $yPosition += 10; // Increase Y position for the next asset tag
    }
    
    // Output PDF
    $pdf->Output('I', 'Asset_Tags.pdf');
    
    // Initiate print immediately
    echo "<script type='text/javascript'>window.print();</script>";
}
?>