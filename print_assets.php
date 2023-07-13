<?php
require('fpdf/fpdf.php');

// Function to generate PDF and print immediately
function generatePDFAndPrint($logoPath, $assetTags)
{
    // Create PDF object
    $pdf = new FPDF();
    
    // Add a new page
    $pdf->AddPage('P', array(8.5, 11));
    
    // Set font
    $pdf->SetFont('Arial', '', 12);
    
    // Set table parameters
    $tableWidth = 8; // Adjust the table width here
    $cellHeight = 0.5; // Adjust the cell height here
    $cellMargin = 0.2; // Adjust the cell margin here
    
    // Set initial position for table
    $xPosition = 0.25; // Adjust the x-axis position here
    $yPosition = 0.5; // Adjust the y-axis position here
    
    // Output asset tags in a table format
    foreach ($assetTags as $assetTag) {
        // Set position for current cell
        $pdf->SetXY($xPosition, $yPosition);
        
        // Set logo
        $pdf->Image($logoPath, $xPosition + 0.25, $yPosition, 1.5);
        
        // Output asset tag cell
        $pdf->Cell($tableWidth - 1.75, $cellHeight, $assetTag, 1, 1, 'C');
        
        // Update y-position for the next cell
        $yPosition += $cellHeight + $cellMargin;
        
        // Check if reaching the end of the page
        if ($yPosition + $cellHeight + $cellMargin > 11) {
            // Add a new page
            $pdf->AddPage('P', array(8.5, 11));
            
            // Reset y-position for the new page
            $yPosition = 0.5;
        }
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