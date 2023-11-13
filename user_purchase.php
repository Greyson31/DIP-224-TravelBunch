<?php
$mysqli = new mysqli("localhost", "root", "", "travelbunch");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$get_package = $mysqli->query("SELECT merc_package.destination, merc_package.transportation, merc_package.pax, merc_package.description, merc_package.price, merc_package.image, merc_package.departure, merc_package.arrivalDate FROM merc_package");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="userpurchase.css">
    <title>Purchases</title>
</head>
<body>

<div class="container mt-5">
    <?php
        if ($get_package->num_rows > 0) {
            while ($row = $get_package->fetch_assoc()) {
                echo '
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="package-container mb-4">
                                <div class="box">
                                    ' . isset_image($row['image']) . '
                                    <h3>' . $row['destination'] . '</h3>
                                    <p>Transportation: ' . $row['transportation'] . '</p>
                                    <p>Pax: ' . $row['pax'] . '</p>
                                    <p>Price: RM' . $row['price'] . '</p>
                                    <p>Description: ' . $row['description'] . '</p>
                                    <p>Departure: ' . $row['departure'] . '</p>
                                    <p>Arrival Date: ' . $row['arrivalDate'] . '</p>

                                    <!-- Add input forms for departure and arrival date -->
                                    <form method="post" action="payment_confirmation2.php">
                                        <input type="hidden" name="destination" value="' . $row['destination'] . '">
                                        <input type="hidden" name="transportation" value="' . $row['transportation'] . '">
                                        <input type="hidden" name="pax" value="' . $row['pax'] . '">
                                        <input type="hidden" name="price" value="' . $row['price'] . '">
                                        <input type="hidden" name="description" value="' . $row['description'] . '">
                                        <input type="hidden" name="departure" value="' . $row['departure'] . '">
                                        <input type="hidden" name="arrivalDate" value="' . $row['arrivalDate'] . '">
                                        <!-- Add other hidden fields as needed -->
                                    
                                        <button type="submit" class="btn btn-orange">Buy Now</button>
                                    </form>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                ';
            }
        }else {
                echo '
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="package-container">
                                <div class="box">
                                    <h3>No packages available.</h3>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }

    $mysqli->close();
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
function isset_image($inputImage) {
    $image = '';

    if (!empty($inputImage)) {
        $image = '<img src="uploaded_img/' . $inputImage . '" class="img-fluid">';
    } else {
        $image = '<img src="#" alt="No Image" class="img-fluid">';
    }

    return $image;
}
?>
