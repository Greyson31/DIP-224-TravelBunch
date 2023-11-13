<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $departure = $_POST["departure"];
    $destination = $_POST["destination"];
    $transport = $_POST["transportation"];
    $num_people = $_POST["pax"];
    $arrival = $_POST["arrivingDate"];
    $leave = $_POST["leavingDate"];
    
    // Price data
    $priceData = array(
        "ipoh" => 120,
        "georgetown" => 150,
        "melaka" => 220,
        "langkawi" => 250
    );
    $busPrice = 50;
    $planePrice = 90;
    
    // Calculate the price based on destination and transportation
    if (isset($priceData[$destination])) {
        $basePrice = $priceData[$destination];
        $totalPrice = ($basePrice + ($transport === "bus" ? $busPrice : $planePrice)) * $num_people;
    } else {
        echo "Invalid destination selected.";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $departure = $_POST["departure"];
        $destination = $_POST["destination"];
        $transport = $_POST["transportation"];
        $num_people = $_POST["pax"];
        $arrival = $_POST["arrivingDate"];
        $leave = $_POST["leavingDate"];
    
        // Price data
        $priceData = array(
            "ipoh" => 120,
            "georgetown" => 150,
            "melaka" => 220,
            "langkawi" => 250
        );
        $busPrice = 50;
        $planePrice = 90;
    
        // Calculate the price based on destination and transportation
        if (isset($priceData[$destination])) {
            $basePrice = $priceData[$destination];
            $totalPrice = ($basePrice + ($transport === "bus" ? $busPrice : $planePrice)) * $num_people;
        } else {
            echo "Invalid destination selected.";
            exit;
        }
    
        // Display the user input and calculated price
        echo '<h2>Your Booking Details</h2>';
        echo '<p><strong>Departure:</strong> ' . $departure . '</p>';
        echo '<p><strong>Destination:</strong> ' . $destination . '</p>';
        echo '<p><strong>Transportation:</strong> ' . $transport . '</p>';
        echo '<p><strong>Pax:</strong> ' . $num_people . '</p>';
        echo '<p><strong>Arriving Date:</strong> ' . $arrival . '</p>';
        echo '<p><strong>Leaving Date:</strong> ' . $leave . '</p>';
        echo '<p><strong>Price:</strong> $' . $totalPrice . '</p>';
    
        // Add a "Pay Now" button and form to store data in the database
        echo '<form method="post" action="payment_confirmation.php">
            <input type="hidden" name="departure" value="' . $departure . '">
            <input type="hidden" name="destination" value="' . $destination . '">
            <input type="hidden" name="transportation" value="' . $transport . '">
            <input type="hidden" name="pax" value="' . $num_people . '">
            <input type="hidden" name="arrivingDate" value="' . $arrival . '">
            <input type="hidden" name="leavingDate" value="' . $leave . '">
            <input type="hidden" name="price" value="' . $totalPrice . '">
            <button type="submit">Pay Now</button>
        </form>';
    } else {
        echo "Invalid Request.";
    }
}    
?>
