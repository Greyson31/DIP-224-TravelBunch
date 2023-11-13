<?php
$mysqli = new mysqli("localhost", "root", "", "travelbunch");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get data 
$destination = $_POST['destination'];
$transportation = $_POST['transportation'];
$pax = $_POST['pax'];
$description = $_POST['description'];
$price = $_POST['price'];
$image = $_FILES['image']['name'];
$image_size = $_FILES['image']['size'];
$image_tmp_name = $_FILES['image']['tmp_name'];
$image_folder = 'uploaded_img/' . $image;
$departure_date = $_POST['departure_date'];
$arrival_date = $_POST['arrival_date'];

// Insert data 
$sql = "INSERT INTO Merc_Package (destination, transportation, pax, description, price, image, departure, arrivalDate) 
        VALUES ('$destination', '$transportation', $pax, '$description', $price, '$image', '$departure_date', '$arrival_date')";


if ($mysqli->query($sql) === true) {
    if (move_uploaded_file($image_tmp_name, $image_folder)) {
        // Display success message in the center
        echo '<div class="text-center mt-5">';
        echo '<h1 class="display-4">Package created successfully</h1>';
        // Add a button with Bootstrap styling
        echo '<a href="index.php" class="btn btn-primary btn-lg mt-3">Go to Home</a>';
        echo '</div>';
    } else {
        echo "Error moving the uploaded image to the folder.";
    }
} elseif ($image_size > 2000000) {
    $message[] = 'Image size is too large!';
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}

$mysqli->close();
?>
