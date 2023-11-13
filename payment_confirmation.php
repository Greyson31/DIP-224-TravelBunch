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

    // Create a PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Booking Receipt', 0, 1, 'C');
    $pdf->Ln(10);

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

    // Save PDF to a file
    $pdf->Output('booking_receipt.pdf', 'F');
    
    // Store data in your database
    $conn = new mysqli('localhost', 'root', '', 'booking');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO user_book (departure, destination, transportation, pax, arrivingDate, leavingDate, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $departure, $destination, $transport, $num_people, $arrival, $leave, $price);
    $stmt->execute();
    
    echo "Successfully booked. <a href='booking_receipt.pdf' target='_blank'>Download Booking Receipt</a>";

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid Request.";
}
?>




