<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect them to dashboard page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $username = $_SESSION["username"];
    $id = $_SESSION["id"];
}


// Define function to calculate time difference
function time_diff($created_at) {
    date_default_timezone_set('Europe/Moscow');
    $diff = time() - strtotime($created_at);

    if ($diff < 60) {
        return $diff . " second" . ($diff > 1 ? "s" : "") . " ago";
    } elseif ($diff < 3600) {
        $diff = floor($diff / 60);
        return $diff . " minute" . ($diff > 1 ? "s" : "") . " ago";
    } elseif ($diff < 86400) {
        $diff = floor($diff / 3600);
        return $diff . " hour" . ($diff > 1 ? "s" : "") . " ago";
    } else {
        $diff = floor($diff / 86400);
        return $diff . " day" . ($diff > 1 ? "s" : "") . " ago";
    }
}
if(isset($_POST['logout'])){
    logout();
}

// Database configuration and connection
require_once "../auth/postconfignoverify.php";
// Set limit for number of posts to display at a time
$limit = 10;
// Check if page variable is set, if not set to 1
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
// Calculate offset for query
$offset = ($page - 1) * $limit;
// Get number of posts in database
$sql = "SELECT COUNT(*) as total FROM posts";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_pages = ceil($row['total'] / $limit);
// Get posts with limit and offset
$sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
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
<link href="https://fonts.cdnfonts.com/css/proxima-nova-2" rel="stylesheet">
<link rel="icon" href="chatbot.png">
<link rel="stylesheet" href="temp.css">
<title>MY1409</title>
</head>




<body>
<div id="main">
        <div class="navbarCont"style="left: 200px;">
        <a href="index.html" style="height: 52px;"><div class="logo"></div></a>
<div class="nav-user-wrapper">
<?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) : ?>
    <h3>Здравствуйте, <?php echo $username; ?>!</h3>
<?php else : ?>
    <a href="login.php"><h3>Пожалуйста, зайдите в ваш аккаунт.</h3></a>
<?php endif; ?>
        <button id="hamburgerbutton" class="hamburgerbutton" aria-controls="primary-navigation" aria-expanded="false" aria-label="Toggle navigation" >
            <svg class="hamburger" viewBox = "0 0 100 100" width="40" height="50">
                <rect class="line first" x="10" y="25px" width="80" height="10" rx="5" fill="#6d6dd6"></rect>
                <rect class="line second" x="10" y="45px" width="80" height="10" rx="5" fill="#6d6dd6"></rect>
                <rect class="line third" x="10" y="65px" width="80" height="10" rx="5" fill="#6d6dd6"></rect>
            </svg> 
        </button>
</div>
        <div id="nav-menu" class="hidething">
            <hr>
            <a href="#">Чат Бот</a>
            <hr>
            <a href="#">Контакты</a>
            <hr>
            <a href="logout.php">Логаут/Логин</a>
            <hr>
        </div>
    </div>
       
        <div class="element-main-extended" style="display:none ;"></div>       

        
        <div class="element-main">
            
            <h3 id="prompt-question">Знаете, как сделать школу лучше? <br>- Напишите нам!</h3>


            <form id="message-form">
            <div class="form-field">
                <textarea class="text-input" type="text" id="message" cols="30" rows="10" placeholder=" " onclick="addClass()"></textarea>
                <label for="message">Сообщение</label>
            </div>
            <div class="form-field">
                <input class="text-input" type="text" id="email" placeholder=" ">
                <label for="email">Е-Mail</label>
            </div>
            <div class="button-container">
                <button class="survey-button" onclick="sendEmail()" type="button">
                Отправить! 
                </button>
                <button class="survey-button" onclick="clearInputs(); removeClass()" type="button">
                Отменить 
                </button>
            </div>
            </form>


              
            
        </div>
        
        <div class="news-section">
            <p class="news-caption">Последние события:</p>
                    <!-- THIS IS THE CAROSEL -->
                <!-- <div class="newsCaro">
                
                </div> -->

                <div class="preview-carousel">
        <div class="carousel-container">
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                $title = $row["title"];
                $media_path = "../uploads/" . $row["file_path"];
                $author = "@" . $row["author"];
                $likes = $row["likes"];
                $dislikes = $row["dislikes"];
                $created_at = $row["created_at"];
                $time_diff = time_diff($created_at);
                $media_type = $row["media_type"];
                

                
                ?>
        <a href="post.php?id=<?php echo $row['id']; ?>" class="post-link">
                <div class="post-card">
        <?php if ($media_type == "image"): ?>
            <img src="<?php echo $media_path; ?>" alt="">
        <?php elseif ($media_type == "video"): ?>
            <video src="<?php echo $media_path; ?>" controls></video>
        <?php endif; ?>
        <div class="post-details">
            <div class="title"><h3><?php echo $title; ?><h3></div>
            <div class="author"><i><?php echo $author; ?></i></div>
        <div class="rating">
            <div class="likes"><?php echo $likes; ?>👍</div><div class="dislikes"><?php echo $dislikes; ?>👎</div>
        </div>
            <div class="time-diff"><?php echo $time_diff; ?></div>
        </div>
    </div>
    </a>
    <?php
}
// If there are more posts, show the "Load More" button
if ($result->num_rows == 10) {
    ?>
    <button id="load-more" class="btn btn-primary">Загрузить больше</button>

<?php
}
} else {
    echo "<p>Нет постов.</p>";
    }
    
    $conn->close();
?>
                <!-- END OF CARO -->
            
        </div>
        
        <div class="chipscontainer">
             <a href="create.php">📸 Создать Пост</a>
        </div>

        <div class="schedule-section">
            <div id="lesson-time-container">
                <div id="lesson-and-sched">
                <p id="lesson"></p>
                <p id="sched"></p>  
                </div>
                <div id="remaining-container">
                <!-- <p id="time" onload="currentTime()"></p> -->
                <p id="remaining"></p> 
                </div>
            </div>
        </div>
        <div>
            <div class="chatbotcaption">
            <img src="chatbot.png" style="width: 30px;height: 30px;"> <p class="news-caption">Чат Бот</p>
            </div>
            <br>
            <div class="chipscontainer">
             <a href="https://vk.com/im?sel=-210064026">📕 Подобрать олимпиаду</a>
            </div>
            <div class="chipscontainer">
            <a href="https://vk.com/im?sel=-210064026">🥤 В кулере нет стаканчиков</a>
            </div>
            <div class="chipscontainer">
            <a href="https://vk.com/im?sel=-210064026">🔑 Создать аккаунт</a>
            </div>
            <div class="chipscontainer">
            <a href="https://vk.com/im?sel=-210064026">✉️ Еще...</a>
            </div>

        </div>
</div>
        <footer>
        <div id="footer-cont1">
          <img src="logo.png">

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
        <a href="">
            <img src="VK.png" alt="vk" width="50" height="50">
        </a>

        </div>
        </footer>
        <script src="webscript.js">
                
         </script>
        <script src="getmore.js">

        </script>
    