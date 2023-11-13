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
        <title>Welcome To TravelBunch</title>
        <link rel="stylesheet" href="Malacca/Malacca_styles.css">
        <meta charset="UTF-8">
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
    
            <form>
                <h3>Login</h3>
                <input type="email" class="box" placeholder="Enter your email">
                <input type="password" class="box" placeholder="Enter your password">
                <input type="submit" value="login now" class="btn">
                <input type="checkbox" id="remember">
                <label for="remember">Remember Me</label>
                <p>Forgotten Password? <a href="#">click here</a></p>
                <p>Don't have an account? <a href="#">register now</a></p>
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
    
            <div class="image-text">Malacca</div>
    
    
            <div id="sec1">
                <div class="title2">
                    <br>
                    <br>
                    <h1><b>Origins</b></h1>
                    <br>
                </div>
    
                <div class="summary-text">
                    <p>
                        Malacca, also known as Melaka, is a city and state located in the southern region of the Malay Peninsula in Malaysia. The origins of Malacca can be traced back to the 14th century when it was founded by a Sumatran prince named Parameswara. 
                    </p>
                    <br>
                    <p>
                        Today, Malacca is a popular tourist destination, offering visitors a glimpse into its rich history through its well-preserved architecture, museums, and cultural sites. The city continues to thrive economically, with tourism, manufacturing, and services contributing to its growth. 
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
                            <img src="Malacca/Dutch_Windmill_Square.jpg" alt=" ">
                        </div>
                
                        <div class="content">
                            <h3 style="font-size:2rem; color:black;">Dutch Windmill Square</h3>
                            <BR>
                            <P> It is amazing to see the entire square in red. Around the square, you will find local food, souvenirs & ricksaws. </P>
                            <BR>
                            <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                    <div class="box">
                        <div class="image">
                            <img src="Malacca/St.Paul_Church.jpg" alt=" ">
                        </div>
                
                        <div class="content">
                            <h3 style="font-size:2rem; color:black;">St.Paul's Church</h3>
                            <BR>
                            <P>This church has a long history - occupied by the Portuguese, Dutch. It was used to store artillery by the British too. The architecture fo the church is absolutely stunning with an open top roof.</P>
                            <BR>
                            <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                    <div class="box">
                        <div class="image">
                            <img src="Malacca/A-famosa.jpg" alt=" ">
                        </div>
                
                        <div class="content">
                            <h3 style="font-size:2rem; color:black;">A Famosa</h3>
                            <BR>
                            <P>You will find this small ruin at the base of St.Paul's Church. Interestingly, it was previously a Portuguese fortress and is the oldest surviving European architectural monument in South East Asia. When the Dutch drove the Portuguese out of Melaka it changed hands and became a dutch fort.</P>
                            <BR>
                            <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>

                    <div class="box">
                        <div class="image">
                            <img src="Malacca/Jonker_Street.jpg" alt=" ">
                        </div>
                
                        <div class="content">
                            <h3 style="font-size:2rem; color:black;">Jonker Street</h3>
                            <BR>
                            <P>Jonker Street is a iconic shopping street in Malacca and also home to the iconic heritage houses. It is a foodie's paradise, there are some iconic Malaccan food such as chicken rice balls, cendol and coconut shakes in Jonker Street.</P>
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
                    <h1><b>Things To Do In Melacca</b></h1>
                    <br>   
                </div>
    
                <div class="act-box-container">
    
                    <div class="act-box">
                        <div class="act-image">
                            <img src="Malacca/Stadthuys.jpg" alt ="">
                        </div>
                
                        <div class="act-content">
                            <h3 style="font-size:2rem; color:black;">Walk around Stadthuys</h3>
                            <BR>
                            <p>Stadthuys is one of the most famous landmarks in Malacca and you will recognize it immediately thanks to the crimson façade.
                                The building dates from 1650 which makes it the oldest of its kind that was built during the Dutch colonial period and is modeled on the Stadhuis or town hall in Hoorn in the Netherlands.</p>
                            <BR>
                            <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
    
                    <div class="act-box">
                        <div class="act-image">
                            <img src="Malacca/Food.jpg" alt ="">
                        </div>
                
                        <div class="act-content">
                            <h3 style="font-size:2rem; color:black;">Enjoy the local cuisine</h3>
                            <BR>
                            <P> In Malacca, there are wide range of local cuisine that attracts your sight. The famous Nyonya cuisine is the highlight of Malacca's cuisine. If it doesn't match your taste, there are Malay and Chinese cuisine such as spring roll, sugar cane juice and sup kambing. </P>
                            <BR>
                            <a href="#">Read More <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>

                    <div class="act-box">
                        <div class="act-image">
                            <img src="Malacca/SultanatePalace.jpg" alt ="">
                        </div>
                
                        <div class="act-content">
                            <h3 style="font-size:2rem; color:black;">Admire the Sultanate Palace</h3>
                            <BR>
                            <p>The Sultanate Palace is actually a model of the original wooden palace that belonged to Sultan Mansur Shah who would have been the ruler of Malacca from 1456 to 1477. The home has now been transformed into a cultural museum which is flanked by pretty gardens and what makes 
                                the building even more impressive is that it was made without using any nails to hold it together.</p>
                            <BR>
                            <a href="#">Read More<i class="fas fa-angle-right"></i></a>
                        </div> 
                    </div>
                </div>
            </section>
    
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