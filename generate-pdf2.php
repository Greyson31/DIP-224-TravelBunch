<?php
require('fpdf/fpdf.php');

$mysqli = new mysqli("localhost", "root", "", "merchant");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$get_package = $mysqli->query("SELECT merc_package.destination, merc_package.transportation, merc_package.pax, merc_package.description, merc_package.price, merc_package.image, merc_package.departure, merc_package.arrivalDate FROM merc_package");

// Create a PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Package Details', 0, 1, 'C');
$pdf->Ln(10);

if ($get_package->num_rows > 0) {
    while ($row = $get_package->fetch_assoc()) {
        // Add package details to the PDF
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, 'Destination: ' . $row['destination']);
        $pdf->Ln(8);
        $pdf->Cell(40, 10, 'Transportation: ' . $row['transportation']);
        $pdf->Ln(8);
        $pdf->Cell(40, 10, 'Pax: ' . $row['pax']);
        $pdf->Ln(8);
        $pdf->Cell(40, 10, 'Price: RM' . $row['price']);
        $pdf->Ln(8);
        $pdf->Cell(40, 10, 'Description: ' . $row['description']);
        $pdf->Ln(8);
        $pdf->Cell(40, 10, 'Departure: ' . $row['departure']);
        $pdf->Ln(8);
        $pdf->Cell(40, 10, 'Arrival Date: ' . $row['arrivalDate']);
        $pdf->Ln(8);
        $pdf->Cell(40, 10, 'Image:');
        $pdf->Ln(8);

        // Check if the image exists
        if (!empty($row['image'])) {
            $imagePath = 'uploaded_img/' . $row['image'];
            if (file_exists($imagePath)) {
                $pdf->Image($imagePath, $pdf->GetX(), $pdf->GetY(), 40);
                $pdf->Ln(40); // Move down to leave space for the image
            }
        } else {
            $pdf->Cell(40, 10, 'No Image');
            $pdf->Ln(8);
        }

        $pdf->Ln(10); // Add some space between packages
    }
} else {
    $pdf->Cell(40, 10, 'No packages available.');
}

$mysqli->close();

// Output PDF to the browser
$pdf->Output('package_details.pdf', 'D');
?>
