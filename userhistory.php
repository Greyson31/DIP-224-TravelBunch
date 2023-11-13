<?php
include 'config.php';
session_start();

$id = $_SESSION['user_id'];

if (!isset($id)) {
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <title>Purchased History</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5 border p-4">
    <h2>Purchased History</h2>

    <table class="table table-bordered table-hover mt-4">
        <thead class="thead-dark">
            <tr>
                <th>Destination</th>
                <th>Transportation</th>
                <th>Pax</th>
                <th>Price</th>
                <th>Description</th>
                <th>Departure</th>
                <th>Arrival Date</th>
                <th>Receipt</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch and display purchased history for the user
            $query = "SELECT * FROM `package_booked` WHERE user_id = '$id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr>
                            <td>' . $row['destination'] . '</td>
                            <td>' . $row['transportation'] . '</td>
                            <td>' . $row['pax'] . '</td>
                            <td>RM' . $row['price'] . '</td>
                            <td>' . $row['description'] . '</td>
                            <td>' . $row['departure'] . '</td>
                            <td>' . $row['arrivalDate'] . '</td>
                            <td>
                            <a href="uploaded_pdfs/receipt_' . $row['user_id'] . '_' . strtotime($row['booking_date']) . '.pdf" class="btn btn-primary" target="_blank">View Receipt</a>
                            </td>
                        </tr>
                    ';
                }
            } else {
                echo '<tr><td colspan="8">No purchase history available.</td></tr>';
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>


    <!-- Back button -->
    <a href="javascript:history.back()" class="btn btn-secondary">Back</a>

    <!-- Bootstrap JS scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</div>

</body>
</html>
