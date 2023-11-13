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
        <link rel="stylesheet" href="WhatToDo/WhatToDo_styles.css">
        <meta charset="UTF-8">
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

        <section class = "home">
            <img class="background-image active" src="WhatToDo/Ipoh.jpg" alt=" ">
            <img class="background-image" src="WhatToDo/Langkawi.jpg" alt=" ">
            <img class="background-image" src="WhatToDo/GeorgeTown.jpg" alt=" ">
            <img class="background-image" src="WhatToDo/Malacca.jpg" alt=" ">

            <div class = "content active">
                <h1> Ipoh,<br><span>Perak</span></h1>
                <br>
                <p>
                    Tourists that are seeking for a relieve from the busy metropolis. The Recreational Park is the right place to go, there is also a cultural village within the park. The natural caves in Ipoh are attractives for tourists whom like to explore the unknown, be sure to keep and eye out where you might find underground streams and waterfalls. Rafting is what you wouldn't miss out in Ipoh, a chance to get up close with the nature and exciting experience down the river. 
                </p>
                <a href="IpohSpots.php">Read More</a>
            </div>

            <div class = "content">
                <h1> Langkawi,<br><span>Kedah</span></h1>
                <p>
                    Cable Car Ride provide a complete view of the whole Langkawi where you can see the Lush Rainforest and Turquoise Waters. If the cable car ride couldn't fulfill you, Kayaking and ATV ride are definitely the choice. Underwater world and wildlife park is the place that you must visit to admire the local ecosystem. 
                </p>
                <a href="Langkawi.php">Read More</a>
            </div>

            <div class = "content">
                <h1> George Town,<br><span>Penang</span></h1>
                <p>
                    George Town not only famous of it's view, the cuisine here are also a must try especially Char Kway Teow, Penang White Curry and Asam Laksa. After a nice meal, take a ride on the Trishaw a special vehicle in Penang. Clan Jetties is a must go in Penang, it is a Chinese Waterfront Settlements, the jetty there were named after a chinese clan. The Cultural Heritage in Penang will amaze you for how special they are.  
                </p>
                <a href="base.php">Read More</a>
            </div>

            <div class = "content">
                <h1> Malacca </h1>
                <p>
                    Colourful Ricksaw are here to serve the tourists, it is even more interesting having to ride the ricksaw at night. It is illuminated and belt out pop music. The Nyonya cuisine here are famous where all locals come to Malacca just to take a bite. There is also chiken rice ball that is difference from normal chicken rice you saw.
                </p>
                <a href="Malacca.php">Read More</a>
            </div>

            <div class="slider-navigation">
                <div class="nav-btn active"></div>
                <div class="nav-btn"></div>
                <div class="nav-btn"></div>
                <div class="nav-btn"></div>
            </div>
            
        </section>

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

            const btns = document.querySelectorAll(".nav-btn");
            const image = document.querySelectorAll(".background-image");
            const contents = document.querySelectorAll(".content");

            var sliderNav = function(manual){
                btns.forEach((btn) => {
                    btn.classList.remove("active")
                });

                image.forEach((image) => {
                    image.classList.remove("active")
                });

                contents.forEach((contents) => {
                    contents.classList.remove("active")
                });

                btns[manual].classList.add("active");
                image[manual].classList.add("active");
                contents[manual].classList.add("active");
            }

            btns.forEach((btn, i) => {
                btn.addEventListener("click", () => {
                    sliderNav(i);
                });
            });

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
            if (isset($_SESSION['user_id'])) {
                $id = $_SESSION['user_id'];
                echo"
                formBtn.addEventListener('click', () =>{      //Add Form
                    window.location.href = 'profile.php'
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
         ?>
        </script>
    </body>
</html>