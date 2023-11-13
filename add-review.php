<?php
    include("config.php");
    session_start();

    if (isset($_POST["review-submit"])) {
        if (isset($_SESSION["user_id"])) {
            $id = $_SESSION['user_id'];
        } else if (isset($_SESSION["merc_id"])) {
            $id = $_SESSION["merc_id"];
        }

        if (!empty($id)) {
            $acc_type = isset($_SESSION["user_id"]) ? "user_id" : "merc_id";
            $isExist_review = $conn->query("SELECT review_id FROM review WHERE $acc_type='$id'");

            if ($isExist_review->num_rows > 0) {
                header("Location: index.php?review-stat=0");
            } else {
                $rating = $_POST["rating"];
                $rating = htmlspecialchars($rating);
                $comment = $_POST["comment"];
                $comment = htmlspecialchars($comment);
    
                $add_review = $conn->query("INSERT INTO review ($acc_type, rating, description) VALUES ('$id', '$rating', '$comment')");
    
                if ($add_review === TRUE) {
                    header("Location: index.php?stat=1");
                } else {
                    header("Location: index.php?stat=0");
                }
            }

        } else {
            header("Location: index.php?log-stat=0");
        }
    }

    $conn->close();
?>
