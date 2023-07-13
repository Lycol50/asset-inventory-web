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
    
    
    // Set Y position for asset tags
    $yPosition = 15;
    $xPosition = 7; // Adjust the x-axis position here

    // Output asset tags
    foreach ($assetTags as $assetTag) {
        $pdf->SetXY($xPosition, $yPosition);
        $pdf->SetX($xPosition); // Set the x-position explicitly
        // Set logo
        $pdf->Image($logoPath, 10, 10, 30);
        $pdf->Cell(0, 10, $assetTag, 0, 1);
        $yPosition += 10; // Increase Y position for the next asset tag
        $xPosition += 10; // Increase Y position for the next asset tag
    }


    
    // Output PDF
    $pdf->Output('I', 'Asset_Tags.pdf');
    
    // Initiate print immediately
    echo "<script type='text/javascript'>window.print();</script>";
}


// Get the selected asset tags from the URL
$selectedAssets = $_GET['selectedAssets'];

// Convert the selected asset tags to an array
$assetTags = explode(',', $selectedAssets);

// Example usage
$logoPath = 'logo_info.png';

// Generate PDF and print
generatePDFAndPrint($logoPath, $assetTags);