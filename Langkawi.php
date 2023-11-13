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
        <link rel="stylesheet" href="Langkawi/Langkawi_styles.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=0.7">
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

            <nav class="navbar2">
                <div class="nav-buttons">
                <button onclick="scrollToSection('sec1')">Summary</button>
                <button onclick="scrollToSection('destination')">Tourist Spots</button>
                <button onclick="scrollToSection('activities')">Activities</button>
                <button onclick="scrollToSection('packages')">Merchant Packages</button>
                </div>
            </nav>
    
            <div class="parallax"></div>
    
            <div class="image-text">Langkawi, Kedah</div>
    
    
            <div id="sec1">
                <div class="title2">
                    <br>
                    <br>
                    <h2><b>Origins</b></h2>
                    <br>
                </div>
    
                <div class="summary-text">
                    <p>
                        Langkawi is a duty-free archipelago off Malaysia's northwest coast, is a popular tourist destination with a rich history. 
                        Its strategic location, diverse population, and thriving tourism industry make it an attractive place to visit. 
                        With a well-connected transportation network, including an international airport, Langkawi is easily accessible. 
                        The island's tropical climate, stunning natural beauty, and UNESCO Geopark status appeal to visitors seeking tax-free shopping, pristine beaches, lush rainforests, and cultural experiences.
                    </p>
                    <br>
                    <p>
                        It is an archipelago located in the Andaman Sea, about 30 kilometers off the northwestern coast of Peninsular Malaysia. 
                        It is situated near the Thai border and is part of the state of Kedah. Langkawi consists of 99 islands, with the main island known as Pulau Langkawi. 
                        The region is renowned for its stunning natural beauty, pristine beaches, lush rainforests, and abundant marine life, making it a popular tourist destination.
                    </p>
                </div>
    
            </div>
    
            <br>
            <br>
            <br>
            <br>
    
            <section class="destination" id="destination">
                <div class="title2">
                    <br>
                    <br>
                    <h2><b>Tourist Destinations</b></h2>
                    <br>   
                </div>
    
                <div class="box-container">
    
                    <div class="box">
                        <div class="image">
                            <img src="Langkawi/images/eagle_square.jpeg" alt ="">
                        </div>
                
                        <div class="content">
                            <h3 style="font-size:2rem; color:black;">Eagle Square</h3>
                            <BR>
                            <P> 
                                a famous landmark in Langkawi, Malaysia, known for its iconic eagle statue. 
                                It offers stunning views of the sea and serves as a gathering place for locals and tourists. It's a popular spot for photography and a starting point for boat tours. 
                            </P>
                            <BR>
                            <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                    <div class="box">
                        <div class="image">
                            <img src="Langkawi/images/sky_bridge.jpeg" alt ="">
                        </div>
                
                        <div class="content">
                            <h3 style="font-size:2rem; color:black;">Langkawi Sky Bridge</h3>
                            <BR>
                            <P>
                                a phenomenal feat of engineering, the Langkawi Ski Bridge curves gracefully through the air from its location atop of Mount Mat Cincang. 
                                The views from its pedestrian walkway are simply out of this world.
                            </p>
                            <br>
                            <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                    <div class="box">
                        <div class="image">
                            <img src="Langkawi/images/geopark.jpg" alt ="">
                        </div>
                
                        <div class="content">
                            <h3 style="font-size:2rem; color:black;">UNESCO Geopark</h3>
                            <BR>
                            <P>
                                a remarkable natural site recognized by UNESCO. It features stunning landscapes, ancient rock formations, diverse flora and fauna, and cultural heritage. 
                                Explore its captivating beauty through various activities like hiking, wildlife spotting, and boat tours. 
                            </P>
                            <BR>
                            <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                </div>
            </section>
    
            <br>
            <br>
            <br>
            <br>
    
            <section class="activities" id="activities">
                <div class="title2">
                    <br>
                    <br>
                    <h2><b>Things To Do In Langkawi</b></h2>
                    <br>   
                </div>
    
                <div class="act-box-container">
    
                    <div class="act-box">
                        <div class="act-image">
                            <img src="Langkawi/images/cable_car.jpg" alt ="">
                        </div>
                
                        <div class="act-content">
                            <h3 style="font-size:2rem; color:black;">Cable Car Ride</h3>
                            <BR>
                            <p> 
                                Experience the exhilaration of the Langkawi Cable Car as you soar above Langkawi Island's lush rainforest and turquoise waters. 
                                Marvel at breathtaking panoramas, step onto the suspended sky bridge, and create unforgettable memories with loved ones.  
                            </p>
                            <BR>
                            <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                    <div class="act-box">
                        <div class="act-image">
                            <img src="Langkawi/images/underwater_world.jpg" alt ="">
                        </div>
                
                        <div class="act-content">
                            <h3 style="font-size:2rem; color:black;">The Underwater World</h3>
                            <BR>
                            <P> 
                                Immerse yourself in the enchanting realm of Langkawi Underwater World! Embark on a captivating underwater voyage, encountering a vibrant array of marine life. 
                                Explore a mesmerizing kingdom beneath the waves, strolling through captivating tunnels and witnessing sharks, stingrays, and a kaleidoscope of tropical fish. 
                                Marvel at the fascinating oceanic inhabitants that reside there. 
                            </P>
                            <BR>
                            <a href="#">Read More <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                    <div class="act-box">
                        <div class="act-image">
                            <img src="Langkawi/images/crocodile_park.jpg" alt ="">
                        </div>
                
                        <div class="act-content">
                            <h3 style="font-size:2rem; color:black;">Crocodile Adventureland</h3>
                            <BR>
                            <P> 
                                Explore Crocodile Adventure Land Langkawi's ten-acre tropical oasis, witnessing captivating interactions between trainers and fearsome crocodiles. 
                                Marvel at Malaysia's diverse flora and fauna while collecting unforgettable memories and souvenirs from the nearby gift shop.
                            </P>
                            <BR>
                            <a href="#">Read More <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                    <div class="act-box">
                        <div class="act-image">
                            <img src="Langkawi/images/kayak.jpg" alt ="">
                        </div>
                
                        <div class="act-content">
                            <h3 style="font-size:2rem; color:black;">River Kayak</h3>
                            <BR>
                            <P> 
                                Embark on an exhilarating kayaking tour in Langkawi to immerse yourself in the beauty of the mangrove forest. 
                                Glide along the sparkling Kubang Badak River, surrounded by lush vegetation, and indulge in a hassle-free adventure filled with excitement and wonder. 
                            </P>
                            <BR>
                            <a href="#">Read More <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                    <div class="act-box">
                        <div class="act-image">
                            <img src="Langkawi/images/atv_ride.jpg" alt ="">
                        </div>
                
                        <div class="act-content">
                            <h3 style="font-size:2rem; color:black;">Energizing ATV Ride</h3>
                            <BR>
                            <P> 
                                Escape the bustling city life with a Langkawi ATV ride and immerse yourself in nature's beauty. 
                                Accompanied by a guide, enjoy a thrilling countryside adventure, discovering Lubuk Semilang waterfall and encountering locals. 
                                Complimentary pick-up and drop-off are available from Kuah or Cenang. 
                            </P>
                            <BR>
                            <a href="#">Read More <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                    <div class="act-box">
                        <div class="act-image">
                            <img src="Langkawi/images/wildlife_park.jpg" alt ="">
                        </div>
                
                        <div class="act-content">
                            <h3 style="font-size:2rem; color:black;">Visit the Wildlife Park</h3>
                            <BR>
                            <P> 
                                Langkawi Wildlife Park, Asia's unique treasure, showcases approximately 150 diverse animal species amidst lush greenery. 
                                Animal and nature enthusiasts will be captivated by the park's vibrant birds, including colorful macaws and distinctive pink flamingos. 
                            </P>
                            <BR>
                            <a href="#">Read More <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                </div>
            </section>
    
            <br>
            <br>
            <br>
            <br>


    <!-- merc_package section start -->
    <section class="review" id="review">
        <h1 class="heading" id="packages">
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
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

        <h2 class="credit">
            created by <span> TravelBunch </span> | All Rights Reserved 
        </h2>

    </div>


</section>

<!-- footer section ends -->

        <script>
            function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    section.scrollIntoView({ behavior: 'smooth' });
}

let searchBtn = document.querySelector('#search-btn')
let searchBar = document.querySelector('.search-bar-container')

let formBtn = document.querySelector('#login-btn')
let loginForm = document.querySelector('.login-form-container')
let formClose = document.querySelector('#form-close')

let menu = document.querySelector('#menu-bar')
let navbar = document.querySelector('.navbar')

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

formBtn.addEventListener('click', () =>{      //Add Form
    loginForm.classList.add('active');
})

formClose.addEventListener('click', () =>{    //Remove Form
    loginForm.classList.remove('active');
})

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

<?php
    //account type checking
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
    } else {
        echo"
        formBtn.addEventListener('click', () =>{      //Add Form
            loginForm.classList.add('active');
        })

        formClose.addEventListener('click', () =>{    //Remove Form
                loginForm.classList.remove('active');
            })
        ";
    }

    //image set checking
    function isset_image($inputImage) {
        $image = '';

        if (!empty($inputImage)) {
            $image = '<img src="uploaded_img/'.$inputImage.'">';
        } else {
            $image = '<img src="images/default-avatar.png">';
        }

        return $image;
    }
?>

        </script>
    </body>
</html>