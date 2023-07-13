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
    
    // Output asset tags
    foreach ($assetTags as $assetTag) {
        $pdf->Cell(0, 10, $assetTag, 0, 1);
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
$logoPath = 'path/to/custom/logo.png';

// Generate PDF and print
generatePDFAndPrint($logoPath, $assetTags);
