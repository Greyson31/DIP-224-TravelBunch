<?php
require('fpdf/fpdf.php'); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $departure = $_POST["departure"];
    $destination = $_POST["destination"];
    $transport = $_POST["transportation"];
    $num_people = $_POST["pax"];
    $arrival = $_POST["arrivingDate"];
    $leave = $_POST["leavingDate"];
    $price = $_POST["price"];
    
    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Booking Receipt', 0, 1, 'C'); // Centered title
    $pdf->Ln(10); // Extra space after the title

    // Add user input details to the PDF
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Departure: ' . $departure);
    $pdf->Ln(8);
    $pdf->Cell(40, 10, 'Destination: ' . $destination);
    $pdf->Ln(8);
    $pdf->Cell(40, 10, 'Transportation: ' . $transport);
    $pdf->Ln(8);
    $pdf->Cell(40, 10, 'Pax: ' . $num_people);
    $pdf->Ln(8);
    $pdf->Cell(40, 10, 'Arriving Date: ' . $arrival);
    $pdf->Ln(8);
    $pdf->Cell(40, 10, 'Leaving Date: ' . $leave);
    $pdf->Ln(8);
    $pdf->Cell(40, 10, 'Price: $' . $price);

    // Save PDF to a file and display a link to download
    $pdf->Output('booking_receipt.pdf', 'D'); // 'D' option sends PDF to the browser for download

} else {
    echo "Invalid Request.";
}
?>
