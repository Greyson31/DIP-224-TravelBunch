<?php
    include("config.php");

    $get_review = $conn->query("SELECT review.description, review.rating, user_form.name, user_form.image FROM review INNER JOIN user_form ON review.user_id = user_form.id UNION ALL SELECT review.description, review.rating, merc_form.name, merc_form.image FROM review INNER JOIN merc_form ON review.merc_id = merc_form.id ORDER BY rating DESC");

    if ($get_review->num_rows > 0) {
        while($row = $get_review->fetch_assoc()) {
            echo '
            <div class="swiper-slide">
                <div class="box">
                    '.isset_image($row['image']).'
                    <h3>'.$row['name'].'</h3>
                    <div class="stars">
                        '.generateStars(intval($row['rating'])).'
                    </div>
                    <p>
                        '.$row['description'].'
                    </p>
                </div>
            </div>
            <br>
            ';
        }
    } else {
        echo '
        <div class="swiper-slide">
            <div class="box">
                <h3>No review added yet.</h3>
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
            $image = '<img src="images/default-avatar.png">';
        }

        return $image;
    }
    
    function generateStars($rating) {
        $stars = '';
    
        for ($i = 0; $i < 5; $i++) {
            if ($i < $rating) {
                $stars .= '<i class="fa-solid fa-star"></i>';
            } else {
                $stars .= '<i class="fa-regular fa-star"></i>';
            }
        }
    
        return $stars;
    }

    $conn->close();
?>