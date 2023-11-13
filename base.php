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
        <link rel="stylesheet" href="Georgetown/style.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <div class="image-text">Georgetown, Penang</div>


        <div id="sec1">
            <div class="title2">
                <br>
                <br>
                <h2><b>Origins</b></h2>
                <br>
            </div>

            <div class="summary-text">
                <p>
                Georgetown, with its rich history and diverse cultural heritage, holds a significant place in Malaysia. 
                The area where George Town is situated was once home to the indigenous Malays and the Orang Asli communities, 
                fostering a deep-rooted connection to the land. 
                Over time, the region experienced the influence of various Malay kingdoms, contributing to its cultural tapestry. 
                Later, the Siamese and Kedah Sultanate also left their mark on the area.</p>
                <br>
                <p>
                Located on the northeastern coast of Penang Island, Georgetown occupies a strategic position within the Strait of Malacca. 
                This bustling city stands as a testament to the historical importance of the strait, 
                which has been a major trade route for centuries. 
                The confluence of the Strait of Malacca and the Andaman Sea further enhances Georgetown's significance, 
                facilitating maritime connections and cultural exchange.</p>
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
                        <img src="Georgetown/kek.jpg" alt ="">
                    </div>
            
                    <div class="content">
                        <h3 style="font-size:2rem; color:black;">Kek Lok Si Temple</h3>
                        <BR>
                        <P> Located in Georgetown, Penang. Kek Lok Si Temple is a renowned Buddhist temple complex and is the largest buddhist temple in Malaysia.
                            It features impressive architecture, such as the towering statue of the Goddess of Mercy. </P>
                        <BR>
                        <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                    </div>
                </div>

                <div class="box">
                    <div class="image">
                        <img src="Georgetown/hill.jpg" alt ="">
                    </div>
            
                    <div class="content">
                        <h3 style="font-size:2rem; color:black;">Penang Hill</h3>
                        <BR>
                        <P>Situated in Penang, Malaysia, Penang Hill is a popular tourist attraction. 
                            Visitors can reach the summit by a funicular railway and enjoy breathtaking views of Penang Island. </P>
                        <BR>
                        <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                    </div>
                </div>

                <div class="box">
                    <div class="image">
                        <img src="Georgetown/art.jpg" alt ="">
                    </div>
            
                    <div class="content">
                        <h3 style="font-size:2rem; color:black;">Penang Street Art</h3>
                        <BR>
                        <P>Penang, Malaysia, is renowned for its captivating street art. 
                            George Town, the capital city, is adorned with vibrant murals and interactive installations by local and international artists. </P>
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
                <h2><b>Things To Do In Georgetown</b></h2>
                <br>   
            </div>

            <div class="act-box-container">

                <div class="act-box">
                    <div class="act-image">
                        <img src="Georgetown/cuisine.jpg" alt ="">
                    </div>
            
                    <div class="act-content">
                        <h3 style="font-size:2rem; color:black;">Indulge In Local Cuisine</h3>
                        <BR>
                        <p> Explore the hawker stalls and local eateries to taste Penang's culinary delights, such as char kway teow, nasi lemak, and assam laksa.  </p>
                        <BR>
                        <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                    </div>
                </div>

                <div class="act-box">
                    <div class="act-image">
                        <img src="Georgetown/jetty.jpg" alt ="">
                    </div>
            
                    <div class="act-content">
                        <h3 style="font-size:2rem; color:black;">Visit The Clan Jetties</h3>
                        <BR>
                        <P> Explore the unique Clan Jetties, which are traditional Chinese waterfront settlements. Each jetty is named after a Chinese clan, and you can walk along the wooden boardwalks to learn about the history, culture, and daily lives of the residents. </P>
                        <BR>
                        <a href="#">Read More <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>

                <div class="act-box">
                    <div class="act-image">
                        <img src="Georgetown/cultural.jpg" alt ="">
                    </div>
            
                    <div class="act-content">
                        <h3 style="font-size:2rem; color:black;">Cultural Heritage</h3>
                        <BR>
                        <P> Immerse yourself in the cultural heritage of Georgetown by visiting the various temples, mosques, and churches that dot the city. Some notable landmarks include the Kuan Yin Temple, Kapitan Keling Mosque, and St. George's Church.</P>
                        <BR>
                        <a href="#">Read More <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>

                <div class="act-box">
                    <div class="act-image">
                        <img src="Georgetown/beach.jpg" alt ="">
                    </div>
            
                    <div class="act-content">
                        <h3 style="font-size:2rem; color:black;">Batu Ferringhi Beaches</h3>
                        <BR>
                        <P> Known for its stunning shoreline, Batu Ferringhi offers a range of activities including water sports, sunbathing, and relaxing by the sea. The area is also famous for its lively night market, where visitors can shop, dine on local street food, and experience the bustling atmosphere. </P>
                        <BR>
                        <a href="#">Read More <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>

                <div class="act-box">
                    <div class="act-image">
                        <img src="Georgetown/museum.jpg" alt ="">
                    </div>
            
                    <div class="act-content">
                        <h3 style="font-size:2rem; color:black;">Penang State Museum and Art Gallery</h3>
                        <BR>
                        <P> Explore the history and culture of Penang at the Penang State Museum and Art Gallery. Discover artifacts, exhibits, and artworks that showcase the diverse heritage and artistic expressions of the region. </P>
                        <BR>
                        <a href="#">Read More <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>

                <div class="act-box">
                    <div class="act-image">
                        <img src="Georgetown/trishaw.jpg" alt ="">
                    </div>
            
                    <div class="act-content">
                        <h3 style="font-size:2rem; color:black;">Take a Trishaw Ride</h3>
                        <BR>
                        <P> Experience a nostalgic mode of transportation by taking a trishaw ride through the streets of Georgetown. </P>
                        <BR>
                        <a href="#">Read More <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>

            </div>
        </section>

        <br><br><br><br>

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
                <a href="index.html">Home Page</a>
                <a href="what_to_do.html">What To Do</a>
                <a href="about_contact.html">About Us</a> 
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