<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect them to dashboard page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $username = $_SESSION["username"];
    $id = $_SESSION["id"];
}
?>


<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta name="viewport" content="width=device-width initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="mainstyle.css" rel="stylesheet" >
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&display=swap" rel="stylesheet">
<meta name="description" content="Офицальный сайт самоуправления школы 1409">

    <meta property="og:title" content="MY1409">
  <meta property="og:description" content="Офицальный сайт самоуправления школы 1409!">
  <meta property="og:image" content="https://my.school1409.ru/public/logo.png">

<link href="https://fonts.cdnfonts.com/css/proxima-nova-2" rel="stylesheet">
<link rel="icon" href="logo.png">
<link rel="stylesheet" href="temp.css">
<title>MY1409</title>
</head>




<body>
<div class="annoucement">Сайт в разработке! 🚧 Оставте предложения или сообщите о ошибках ниже 👇</div>
<div id="main">
        <div class="navbarCont"style="left: 200px;">
        <a href="index.php" style="height: 52px;"><div class="logo"></div></a>

        <button id="hamburgerbutton" class="hamburgerbutton" aria-controls="primary-navigation" aria-expanded="false" aria-label="Toggle navigation" >
            <svg class="hamburger" viewBox = "0 0 100 100" width="40" height="50">
                <rect class="line first" x="10" y="25px" width="80" height="10" rx="5" fill="#6d6dd6"></rect>
                <rect class="line second" x="10" y="45px" width="80" height="10" rx="5" fill="#6d6dd6"></rect>
                <rect class="line third" x="10" y="65px" width="80" height="10" rx="5" fill="#6d6dd6"></rect>
            </svg> 
        </button>

        <div class="nav-container">
  <ul class="nav-list">
    <li>
      <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
        <a href="user.php?uid=<?php echo $id; ?>"><img src="defpfp.png" alt="pfp" width="30" height="30"><i>@<?php echo $username; ?></i></a>
      <?php } else { ?>
        <a href="login.php"><img src="defpfp.png" alt="pfp" width="25" height="25"><i>Гость</i></a>
      <?php } ?>
      </li>
    <li><a href="https://info.school1409.ru/support">Техподдержка</a></li>
    <li><a href="https://info.school1409.ru/idea">Фидбек</a></li>
    <li><a href="https://info.school1409.ru/my1409">О нас</a></li>
    <li>
      <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
        <a href="logout.php" >Выход</a>
      <?php } else { ?>
        <a href="login.php" >Вход</a>
      <?php } ?>
    </li>
  </ul>
</div>
        </div> 

        <!-- end of navbar -->
        <h1 style="text-align:center;">Прямой Зфир</h1>
        <div class="livestream-cont">
        <iframe class="livestream" src="https://vk.com/video_ext.php?oid=-101430906&id=456242606&hash=8a443cacb7ad1291&hd=4&autoplay=1" width="1600" height="1400" allow="autoplay; encrypted-media; fullscreen; picture-in-picture;" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
  
</div>
        <footer>
        <div id="footer-cont1">
          <img src="logo.png" width="100" height="100">

            <div id="footer-textcont1">
                <h1>В Моменте</h1>
                <h2>ул. Авиаконструктора Микояна, дом 2, Москва, 125167</h2>
                <h2></h2>
                <h2></h2>
            </div>
        </div>
        <div id="footer-socials">
        <a href="">
            <img src="telegram.png" alt="telegram" width="50" height="50">
        </a>
        <a href="https://vk.com/im?sel=-210064026">
            <img src="VK.png" alt="vk" width="50" height="50">
        </a>

        </div>
        </footer>
</body>
</html>


<script src="webscript.js"></script>

    