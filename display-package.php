<?php
$mysqli = new mysqli("localhost", "root", "", "travelbunch");


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$get_package = $mysqli->query("SELECT merc_package.destination, merc_package.transportation, merc_package.pax, merc_package.description, merc_package.price, merc_package.image FROM merc_package");

if ($get_package->num_rows > 0) {
    while ($row = $get_package->fetch_assoc()) {
        echo '
        <div class="swiper-slide">
            <div class="box">
                ' . isset_image($row['image']) . '
                <h3>' . $row['destination'] . '</h3>
                <p>Transportation: ' . $row['transportation'] . '</p>
                <p>Pax: ' . $row['pax'] . '</p>
                <p>Price: ' . $row['price'] . '</p>
                <p>Description: ' . $row['description'] . '</p>

            </div>
        </div>
        <br>
        ';
    }
} else {
    echo '
    <div class="swiper-slide">
        <div class="box">
            <h3>No packages available.</h3>
            <p></p>
        </div>
    </div>
    ';
}



function isset_image($inputImage) {
    $image = '';

    if (!empty($inputImage)) {
        $image = '<img src="uploaded_img/'.$inputImage.'">';
    } else {
        $image = '<img src="#" alt="No Image">';
    }

    return $image;
}



$mysqli->close();
?>
