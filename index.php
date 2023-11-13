<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, ($_POST['password']));

    $get_acc = $conn->prepare("SELECT id, email FROM user_form WHERE email=? AND password=? UNION SELECT id, email FROM merc_form WHERE email=? AND password=? UNION SELECT id, email FROM admin_form WHERE email=? AND password=?");
    $get_acc->bind_param("ssssss", $email, $pass, $email, $pass, $email, $pass);
    $get_acc->execute();
    $get_acc = $get_acc->get_result();

    if (mysqli_num_rows($get_acc) > 0) {
        $row = mysqli_fetch_assoc($get_acc);
        $email = $row['email'];

        // Check if the email contains '@merchant.com'
        if (strpos($email, '@merchant.com') !== false) {
            // This is a merchant
            $_SESSION['merc_id'] = $row['id'];
            header('location:merc_prof.php');

        } else if (strpos($email, '@admin.com') !== false) {

          //This is an admin
          $_SESSION['admin_id'] = $row['id'];
          header('location:admin_prof.php');
        }

        else {
            // This is a user
            $_SESSION['user_id'] = $row['id'];
            header('location:profile.php');
        }
    } else {
        $message[] = 'Incorrect email or password!';
    }

    $get_acc->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome To TravelBunch</title>
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="styles.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>

    <header>
        <div id="menu-bar" class="fas fa-bars"></div>
        <a href="index.php" class="logo"><span>T</span>ravelbunch</a>

        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="what_to_do.php">What To Do</a>
            <a href="about_contact.php">About Us</a>
        </nav>

        <div class="icons">
            <i class="fas fa-search" id="search-btn"></i>
            <i class="fas fa-user" id="login-btn"></i>
        </div>

        <div class="search-bar-container">
            <div class="search-box">
                <input type="search" id="search-bar" placeholder="Search Here...">
                <label for="search-bar" class="fas fa-search" id="search-icon"></label>
            </div>
            <div class="result-box-container">
                <div class="result-box"></div>
            </div>
        </div>
    </header>

    <!--login form-->
    <div class="login-form-container">

        <i class="fas fa-times" id="form-close"></i>

            <form action="" method="post" enctype="multipart/form-data">
                <h3>login now</h3>
                <?php
                if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message">'.$message.'</div>';
                    }
                }
                ?>
                <input type="email" name="email" placeholder="enter email" class="box" required>
                <input type="password" name="password" placeholder="enter password" class="box" required>
                <input type="submit" name="submit" value="login now" class="btn">
                <p>Don't have an account? <a href="register.php">Register Now</a></p>
                <p>Merchant? <a href="merc_reg.php">Click Here</a></p>
            </form>

    </div>


    <!--Home Section-->
    <section class="home" id="home">

        <div class="content">
            <h3>TravelBunch</h3>
            <p>Malaysia Travel and Recommendation Guide</p>
            <button class="btn" onclick="scrollToSection('packages')">Start Your Journey</button>
        </div>

        <div class="controls">
            <span class="vid-btn active" data-src="index/bgvideo.mp4"></span>
            <span class="vid-btn" data-src="index/Malaysia Truly Asia.mp4"></span>
            <span class="vid-btn" data-src="index/The Soul of Malaysia (Malaysia Truly Asia).mp4"></span>
        </div>

        <div class="video-container">
            <video src="index/bgvideo.mp4" id="video-slider" loop autoplay muted></video>
        </div>
    </section>

     <!-- book section start -->
    <section class="book" id="book">
        <h1 class="heading">
            Book Now
        </h1>

        <br><br>

     <div class="row">

        <div class="image">
            <img src="5831236-removebg-preview.png" alt="">
        </div>

        <form action="booking.php" method="post" enctype="multipart/form-data">
            <div class="inputBox">
                <h3>Departure</h3>
                <input type="text" placeholder="From where?" id="departure" name="departure">
            </div>
            <div class="inputBox">
                <h3>Destination</h3>
                <select name="destination" id="destination" required>
                    <option value="langkawi">Langkawi</option>
                    <option value="ipoh">Ipoh</option>
                    <option value="melaka">Melaka</option>
                    <option value="georgetown">Georgetown</option>
                </select>
            </div>
            <div class="inputBox">
                <h3>Transportation</h3>
                <select name="transportation" id="transportation" required>
                    <option value="bus">Bus</option>
                    <option value="plane">Plane</option>
                </select>
            </div>
            <div class="inputBox">
                <h3>How many pax?</h3>
                <input type="number" min="0" placeholder="Enter Pax" id="pax" name="pax" required>
            </div>
            <div class="inputBox">
                <h3>arrivals</h3>
                <input type="date" name="arrivingDate">

            </div>
            <div class="inputBox">
                <h3>leaving</h3>
                <input type="date" name="leavingDate">
            </div>


            <div class="form-group">
                <button type="submit" class="btn" onclick="showMessage()"> Book Now</button>
            </div>
        </form>
        <!-- </div> -->
    </div>
    </section>



    <!-- book section end -->

    <!-- packages section start -->

    <section class="packages" id="packages">

        <h1 class="heading">
            Places To Go
        </h1>

        <br><br>

        <div class="box-container">
        <div class="box">
            <img src="gallery/langkawi.jpg" alt="langkawi">
            <div class="content">
                <h3><i class="fas fa-map-marker-alt"></i> Langkawi</h3>
                <div class="stars">
                    <!-- fas fa-star is colored star -->
                    <!-- far far fa-star is uncolored star -->
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>

                    <i class="fas fa fa-star"></i>
                </div>
                <br>
                <p> Langkawi is an archipelago made up of 99 islands on the west coast of Malaysia. Surrounded by the Andaman Sea, the main island offers....</p>

                <!-- <div class="prices">RM120.00 <span> RM150.00</span></div> -->
                <a href="Langkawi.php" class="btn">learn more</a>
            </div>
        </div>


        <div class="box">
            <img src="gallery/ipoh.jpg" alt="ipoh">
            <div class="content">
                <h3> <i class="fas fa-map-marker-alt"></i> Ipoh</h3>
                <div class="stars">
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                </div>
                <br>
                <p>Ipoh is the capital of Perak and Malaysia's third-largest city. It is located between George Town and Kuala Lumpur and is a popular destination for lovers of adventure, art...</p>

                <!-- <div class="prices">RM67.00 <span> RM90.00</span></div> -->
                <a href="IpohSpots.php" class="btn ">learn more</a>
            </div>
        </div>

        <div class="box">
            <img src="gallery/Melacca.jpg" alt="Melacca">
            <div class="content">
                <h3> <i class="fas fa-map-marker-alt"></i> Melaka</h3>
                <div class="stars">
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                </div>
                <br>
                <p>What is Malacca known for?
                    Among its other historic architectural sites, the Baba Nyonya Heritage Museum and the Malacca Sultanate Palace are one of the most renowned places. Having a great deal of history behind its name, Malacca is...</p>

                <!-- <div class="prices"> RM45.00 <span> RM70.00</span></div> -->
                <a href="Malacca.php" class="btn">learn more</a>
            </div>
        </div>

        <div class="box">
            <img src="gallery/georgetown.jpg" alt="penang">
            <div class="content">
                <h3> <i class="fas fa-map-marker-alt"></i> Georgetown </h3>
                <div class="stars">
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                    <i class="fas fa fa-star"></i>
                    <i class="far far fa-star"></i>
                </div>
                <br>
                <p>What is the description of George Town? George Town (Malaysia) – Travel guide at Wikivoyage George Town is the capital city of the Malaysian state of Penang. It is Malaysia's sixth largest city, with a population of about 708,000, with 2.4 million in...</p>

                <!-- <div class="prices"> RM85.00 <span> RM90.00</span></div> -->
                <a href="base.php" class="btn">learn more</a>
            </div>
        </div>
    </div>


    </section>








    <!-- packages section end -->

    <!-- services section start -->
    <section class="services" id="services">
        <h1 class="heading">
            Services
        </h1>

        <br><br>

    <div class="box-container">
        <div class="box">
            <i class="fas fa-hotel"></i>
            <h3>accommodation</h3>
            <p>choose the right places to stay overnight</p>
        </div>
        <div class="box">
            <i class="fas fa-utensils"></i>
            <h3>food and beverage</h3>
            <p>offers an abundance of gastronomical delights with a boundless variety of regional and seasonal dishes.</p>
        </div>
        <div class="box">
            <i class="fas fa-subway"></i>
            <h3>transportation</h3>
            <p>offers the best mode of transport for your trip</p>
        </div>
    </div>
    </section>

    <!-- services section end -->
    <br><br><br>


    <!-- login popup message -->
    <?php
        if (isset($_GET["log-stat"])) {
            echo'
            <div class="popup-container">
                <div class="popup">
                    <i id="lock-icon" class="fa-solid fa-lock fa-beat"></i>
                    <h2>log in!!</h2>
                    <p>please login first.</p>
                    <button id="ok-btn" onclick="hidePopup()">OK</button>
                </div>
            </div>
            ';
        }
    ?>

    <!-- review popup message -->
    <?php
        if (isset($_GET["stat"])) {
            $stat = intval($_GET["stat"]);

            if ($stat === 1) {
                echo'
                <div class="popup-container">
                    <div class="popup">
                        <i id="check-icon" class="fa-solid fa-circle-check fa-beat"></i>
                        <h2>succeed!!</h2>
                        <p>review has been added.</p>
                        <button id="ok-btn" onclick="hidePopup()">OK</button>
                    </div>
                </div>
                ';
            } else if ($stat === 2) {
                echo'
                <div class="popup-container">
                    <div class="popup">
                        <i id="check-icon" class="fa-solid fa-circle-check fa-beat"></i>
                        <h2>succeed!!</h2>
                        <p>purchase has completed. <br> <a href="uploaded_pdfs/' . $_GET["pdfFileName"] . '" download>Download PDF Receipt</a></p>
                        <button id="ok-btn" onclick="hidePopup()">OK</button>
                    </div>
                </div>
                ';} else {
                echo'
                <div class="popup-container">
                    <div class="popup">
                        <i id="cross-icon" class="fa-solid fa-circle-xmark fa-beat"></i>
                        <h2>error!!</h2>
                        <p>failed to add review.</p>
                        <button id="ok-btn" onclick="hidePopup()">OK</button>
                    </div>
                </div>
                ';
            }
        }
    ?>

    <!-- review exist popup message-->
    <?php
        if (isset($_GET["review-stat"])) {
            echo'
            <div class="popup-container">
                <div class="popup">
                    <i id="cross-icon" class="fa-solid fa-circle-xmark fa-beat"></i>
                    <h2>error!!</h2>
                    <p>you\'ve already reviewed.</p>
                    <button id="ok-btn" onclick="hidePopup()">OK</button>
                </div>
            </div>
            ';
        }
    ?>

    <!-- review section start -->
    <section class="review" id="review">

        <h1 class="heading">
            Reviews
        </h1>

        <br>

        <form class="review-container" action="add-review.php" method="post" enctype="multipart/form-data">

            <!-- total comments -->
            <div class="total-comments">
            <?php
                include("config.php");

                $get_total_comments = $conn->query("SELECT COUNT(*) as count FROM review");

                if ($get_total_comments->num_rows > 0) {
                    $row = $get_total_comments->fetch_assoc();
                    echo $row["count"]. " Comments";
                } else {
                    echo "No Comments";
                }

                $conn->close();
            ?>
            </div>

            <div class="review-box">
                <label for="rating">Rating:</label>
                <select name="rating" id="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <textarea name="comment" id="comment" placeholder="Share Your Thoughts . . ." cols="30" rows="5" maxlength="1000" required></textarea>
                <input type="submit" name="review-submit" value="Comment" class="comment-btn">
            </div>
        </form>

        <br><br>

        <div class="mySwiper review-slider">
            <div class="swiper-wrapper"><?php include("display-review.php"); ?></div>
        </div>
    </section>
<!-- review section ends -->


<!-- merc_package section start -->
<section class="review" id="review">
    <h1 class="heading">
        Package created by merchant
    </h1>

    <br>

        <!-- Initialize swiper container -->
        <div class="mySwiper package-slider">
            <div class="swiper-wrapper">
                <?php
                $mysqli = new mysqli("localhost", "root", "", "travelbunch");

                $sql = "SELECT * FROM merc_package";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="swiper-slide">
                            <div class="box">
                                ' . isset_image($row['image']) . '
                                <h3>' . $row['destination'] . '</h3>
                                <p>Transportation: ' . $row['transportation'] . '</p>
                                <p>Pax: ' . $row['pax'] . '</p>
                                <p>Departure: ' . $row['departure'] . '</p>
                                <p>Arrival Date: ' . $row['arrivalDate'] . '</p>
                                <p>Price: RM ' . $row['price'] . '</p>
                                <p>' . $row['description'] . '</p>

                                <form method="post" action="user_purchase.php">
                                    <input type="hidden" name="destination" value="' . $row['destination'] . '">
                                    <input type="hidden" name="transportation" value="' . $row['transportation'] . '">
                                    <input type="hidden" name="pax" value="' . $row['pax'] . '">
                                    <input type="hidden" name="price" value="' . $row['price'] . '">
                                    <input type="hidden" name="departure" value="' . $row['departure'] . '">
                                    <input type="hidden" name="arrivalDate" value="' . $row['arrivalDate'] . '">

                                    <!-- Add additional input form for user to input date -->
                                    <label for="purchase_date">Purchase Date:</label>
                                    <input type="date" id="purchase_date" name="purchase_date" required>

                                    <button type="submit" class="btn">Buy Now</button>
                                </form>
                            </div>
                        </div>
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

                $mysqli->close();
                ?>
            </div>
        </div>
    </section>

    <!-- Include the Swiper library -->
    <link rel="stylesheet" href="path-to-swiper-css/swiper.min.css">
    <script src="path-to-swiper-js/swiper.min.js"></script>

<script>
    var packageSwiper = new Swiper('.package-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>

<!-- merc_package section end -->

<br><br>

<!-- footer section start-->
    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>about us</h3>
                <p> Founded in 2012, TravelBunch has been in operation for several years. We are a non-profit organization with the goal of promoting Tourism in Malaysia. Over the years, TravelBunch has earned a strong reputation for assisting new tourists exploring Malaysia, discovering the true beauty of Malaysia.</p>
            </div>

            <div class="box">
                <h3>home links</h3>
                <a href="index.php">Home Page</a>
                <a href="what_to_do.php">What To Do</a>
                <a href="about_contact.php">About Us</a>
            </div>
            <div class="box">
                <h3>follow us</h3>
                <a href="#">facebook</a>
                <a href="#">instagram</a>
                <a href="#">twitter</a>
                <a href="#">linkedin</a>
            </div>

            <h1 class="credit">
                created by <span> TravelBunch </span> | All Rights Reserved
            </h1>

        </div>


    </section>

<!-- footer section ends -->


    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<!-- new version font-awesome icons -->
    <script src="https://kit.fontawesome.com/60b882034e.js" crossorigin="anonymous"></script>

    <script>
        var swiper = new Swiper(".mySwiper", {});
        let searchBtn = document.querySelector('#search-btn')
let searchBar = document.querySelector('.search-bar-container')

let formBtn = document.querySelector('#login-btn')
let loginForm = document.querySelector('.login-form-container')
let formClose = document.querySelector('#form-close')

let menu = document.querySelector('#menu-bar')
let navbar = document.querySelector('.navbar')

let videoBtn = document.querySelectorAll('.vid-btn')

window.onscroll = () =>{
    searchBtn.classList.remove('fa-times');
    searchBar.classList.remove('active');
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');
    loginForm.classList.remove('active');
}

searchBtn.addEventListener('click', () =>{
    searchBtn.classList.toggle('fa-times');
    searchBar.classList.toggle('active');
})

menu.addEventListener('click', () =>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
})

videoBtn.forEach(btn =>{
    btn.addEventListener('click', ()=>{
        document.querySelector('.controls .active').classList.remove('active');
        btn.classList.add('active');
        let src = btn.getAttribute('data-src');
        document.querySelector('#video-slider').src = src
    });
});

function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    section.scrollIntoView({ behavior: 'smooth' });
  }

  function showMessage() {
    alert("Thank you for Submission.");
  }

  function showWarning() {
    var warning = document.getElementById("warning-message");
    warning.style.display = "block";
  }

  function hideWarning() {
    var warning = document.getElementById("warning-message");
    warning.style.display = "none";
  }

<?php
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        echo"
        formBtn.addEventListener('click', () =>{      //Add Form
            window.location.href = 'profile.php'
        })
        ";
    } else if (isset($_SESSION['merc_id'])) {
        $merc_id = $_SESSION['merc_id'];
        echo"
        formBtn.addEventListener('click', () =>{      //Add Form
            window.location.href = 'merc_prof.php'
        })
        ";

    } else if (isset($_SESSION['admin_id'])) {
        $admin_id = $_SESSION['admin_id'];
        echo"
        formBtn.addEventListener('click', () =>{      //Add Form
            window.location.href = 'admin_prof.php'
        })
        ";

    }

    else {
        echo"
        formBtn.addEventListener('click', () =>{      //Add Form
            loginForm.classList.add('active');
        })

        formClose.addEventListener('click', () =>{    //Remove Form
                loginForm.classList.remove('active');
            })
        ";
    }
?>

//review js start here

function hidePopup() {
  //get rid of url that's after '?'
  var currentUrl = window.location.href.split('?')[0];
  window.history.replaceState({}, document.title, currentUrl);

  var popup = document.querySelector(".popup-container");
  popup.style.display = "none";
}

//review js end here

//Destinations Search Start Here

let destinations = ["Langkawi", "Ipoh", "Malacca", "Georgetown"]

const resultBox = document.querySelector(".result-box")
const searchInput = document.getElementById("search-bar")
const resultBoxContainer = document.querySelector(".result-box-container")
const searchIcon = document.getElementById("search-icon")

searchInput.onkeyup = function() {
    let result = []
    let value = searchInput.value.toLowerCase()
    if (value.length) {
        resultBoxContainer.style.display = "block"

        result = destinations.filter(keyword => {
            return keyword.toLowerCase().includes(value)
        })
    }
    display(result)

    if (!value.length || !result.length) {
        resultBoxContainer.style.display = "none"
    }
}

function display(result) {
    const content = result.map(list => {
        return "<li onclick=inputSelect(this)>" + list + "</li>"
    })

    resultBox.innerHTML = "<ul>" + content.join("") + "</ul>"
}

function inputSelect(list) {
    selectedInput = searchInput.value = list.innerHTML
    resultBoxContainer.style.display = "none"
}

searchIcon.addEventListener('click', () => {
    identifyDestinations()
})

searchInput.addEventListener("keydown", e => {
    if (e.key === "Enter") {
        identifyDestinations()
    }
})

function identifyDestinations() {
    let searchLocation = searchInput.value.toLowerCase()

    if (searchLocation === "langkawi") {
        window.location.href = "Langkawi.php"
    } else if (searchLocation === "malacca") {
        window.location.href = "Malacca.php"
    } else if (searchLocation === "georgetown") {
        window.location.href = "base.php"
    } else if (searchLocation === "ipoh") {
        window.location.href = "IpohSpots.php"
    }
}

//Destinations Search End Here
    </script>

</body>

</html>
