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
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <title>Welcome To TravelBunch</title>
    <link rel="stylesheet" href="About_N_Contact/about_contact_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
<!--Header Here-->

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

<!--About_Us Here-->

    <div>
        <section class="about_us" id='about'>
            <div class="content">
                <h1 class="hidden">About Us</h1>
                <p class="title hidden">
                    Founded in 2012, TravelBunch has been in operation for several years. We are a non-profit organization with the goal of promoting Tourism in Malaysia. 
                    Over the years, TravelBunch has earned a strong reputation for assisting new tourists exploring Malaysia, discovering the true beauty of Malaysia.
                </p>
            </div>
        
            <div class="image">
                <img src="About_N_Contact/images/backpack_logo.jpg" alt="">
            </div>
        </section>
    </div>

<!--Label Here-->

    <nav class="navbar2">
        <div class="nav-buttons">
            <button onclick="scrollToSection('about')">About Us</button>   
            <button onclick="scrollToSection('contact')">Contact Us</button>           
        </div>
    </nav>

<!--Contact_Us Here-->

    <div>
        <section class="contact_us">
            <div class="content">
                <h1 class="hidden">Contact Us</h1>
                <p class="title hidden">
                    Address <br>
                    9th Floor, No. 2, Tower 1, <br>
                    Jalan P5/6, Presint 5, <br>
                    62200, Putrajaya, Malaysia <br>
                </p>
                
                <div class="title hidden">
                    <div class="icons">
                        <i class="fa fa-phone fa-rotate-90"></i>
                        <span>+6 012 345 6789</span>
                    </div>
        
                    <div class="icons">
                        <i class="fa fa-inbox"></i>
                        <span>support@TravelBunch.com</span>            
                    </div>
                </div>             
            </div>
    
            <div class="vid" id="contact">
                <video src="About_N_Contact/videos/World_Map_Grey_Background.mov" id="video-slider" loop autoplay muted></video>
            </div>
        </section>
    </div>

    <script>
        let searchBtn = document.querySelector('#search-btn');
let searchBar = document.querySelector('.search-bar-container');

let formBtn = document.querySelector('#login-btn');
let loginForm = document.querySelector('.login-form-container');
let formClose = document.querySelector('#form-close');

let menu = document.querySelector('#menu-bar');
let navbar = document.querySelector('.navbar');

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
});

menu.addEventListener('click', () =>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
});

formBtn.addEventListener('click', () =>{      //Add Form
    loginForm.classList.add('active');
});

formClose.addEventListener('click', () =>{    //Remove Form
    loginForm.classList.remove('active');
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

//Slide Effect Here
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        console.log(entry)
        if (entry.isIntersecting) {
            entry.target.classList.add("show")
        } else {
            entry.target.classList.remove("show")
        }
    });
});

const hiddenEle = document.querySelectorAll(".hidden");
hiddenEle.forEach((el) => observer.observe(el));

function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    section.scrollIntoView({ behavior: 'smooth' });
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


    </script>
</body>
</html>