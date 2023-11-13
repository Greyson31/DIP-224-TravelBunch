<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in and the user_id session variable is set
    if (isset($_SESSION['user_id'])) {
        // Retrieve data from the POST request
        $destination = $_POST['destination'];
        $transportation = $_POST['transportation'];
        $pax = $_POST['pax'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $departure = $_POST['departure'];
        $arrival = $_POST['arrivalDate'];
        // Retrieve other fields as needed

        // Get the user ID from the session
        $user_id = $_SESSION['user_id'];

        // Insert the data into the 'package_booked' table
        $mysqli = new mysqli("localhost", "root", "", "travelbunch");

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $insert_query = "INSERT INTO package_booked (user_id, destination, transportation, pax, price, description, departure, arrivalDate) VALUES ('$user_id', '$destination', '$transportation', '$pax', '$price','$description','$departure','$arrival')";

        if ($mysqli->query($insert_query) === TRUE) {
   
            require('fpdf/fpdf.php');

 
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(40, 10, 'Purchase Complete');

  
            $pdf->Ln(); 
            $pdf->SetFont('Arial', '', 12); 
            $pdf->Cell(40, 10, 'Destination:', 0, 0, 'L');
            $pdf->Cell(60, 10, $destination, 0, 1, 'L');
            $pdf->Cell(40, 10, 'Transportation:', 0, 0, 'L');
            $pdf->Cell(60, 10, $transportation, 0, 1, 'L');
            $pdf->Cell(40, 10, 'Pax:', 0, 0, 'L');
            $pdf->Cell(60, 10, $pax, 0, 1, 'L');
            $pdf->Cell(40, 10, 'Price:', 0, 0, 'L');
            $pdf->Cell(60, 10, 'RM' . $price, 0, 1, 'L');
            $pdf->Cell(40, 10, 'Description:', 0, 0, 'L');
            $pdf->Cell(60, 10, $description, 0, 1, 'L'); 
            $pdf->Cell(40, 10, 'Departure:', 0, 0, 'L');
            $pdf->Cell(60, 10, $departure, 0, 1, 'L'); 
            $pdf->Cell(40, 10, 'Arrival Date:', 0, 0, 'L');
            $pdf->Cell(60, 10, $arrival, 0, 1, 'L'); 
            

          

            // Save the PDF to a file
            $pdfFileName = 'receipt_' . $user_id . '_' . time() . '.pdf';
            $pdf->Output('uploaded_pdfs/' . $pdfFileName, 'F');

            // Provide a link for the user to download the PDF
            header("Location: index.php?stat=2&pdfFileName=" .$pdfFileName);
        } else {
            echo "Error: " . $mysqli->error;
        }

        $mysqli->close();
    } else {
        // Handle the case where the user is not logged in
        header("Location: index.php?log-stat=0");
    }
}
?>
