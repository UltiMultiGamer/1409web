<?php
session_start();
// Include the database configuration file
require_once "../auth/postconfignoverify.php";

// Get the post ID from the URL parameter
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
} else {
    // Redirect the user to the dashboard if the post ID is not set
    header("Location: index.php");
    exit();
}

// Get the sorting option from the URL parameter
if (isset($_GET['sort'])) {
    $sorting_option = $_GET['sort'];
} else {
    // Set the default sorting option to "new"
    $sorting_option = "new";
}

// Get the post details from the database
$sql = "SELECT * FROM posts WHERE id = $post_id LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Redirect the user to the dashboard if the post ID is invalid
    header("Location: index.php");
    exit();
}

// Get the post details
$row = $result->fetch_assoc();
$post_details = array(
    "id" => $row["id"],
    "title" => $row["title"],
    "description" => $row["description"],
    "media_type" => $row["media_type"],
    "file_path" => $row["file_path"],
    "button_label" => $row["button_label"],
    "button_link" => $row["button_link"],
    "author" => "@" . $row["author"],
    "author_id" => $row["author_id"],
    "created_at" => $row["created_at"],
    "likes" => $row["likes"],
    "dislikes" => $row["dislikes"]
);
$media_path = "../uploads/" . $post_details["file_path"];
$created_at = $post_details["created_at"];
$time_diff = time_diff($created_at);


function time_diff($created_at) {
    date_default_timezone_set('Europe/Moscow');
    $timestamp = strtotime($created_at);
    $diff = time() - $timestamp;
  
    if ($diff < 60) {
      return $diff . " секунд назад";
    } elseif ($diff < 3600) {
      return floor($diff / 60) . " минут назад";
    } elseif ($diff < 86400) {
      return floor($diff / 3600) . " часа назад";
    } elseif ($diff < 604800) {
      return floor($diff / 86400) . " дня назад";
    } elseif ($diff < 2592000) {
      return floor($diff / 604800) . " недель назад";
    } elseif ($diff < 31536000) {
      return floor($diff / 2592000) . " месяца назад";
    } else {
      return floor($diff / 31536000) . " года назад";
    }
  }




// Generate the URLs for the next and previous posts based on the sort
if ($sorting_option == "new") {
    $next_post_sql = "SELECT id FROM posts WHERE created_at > '$created_at' ORDER BY created_at ASC LIMIT 1";
    $prev_post_sql = "SELECT id FROM posts WHERE created_at < '$created_at' ORDER BY created_at DESC LIMIT 1";
} else {
    $next_post_sql = "SELECT id FROM posts WHERE likes > $post_details[likes] ORDER BY likes ASC, created_at ASC LIMIT 1";
    $prev_post_sql = "SELECT id FROM posts WHERE likes < $post_details[likes] ORDER BY likes DESC, created_at DESC LIMIT 1";
}

$next_post_result = $conn->query($next_post_sql);
$prev_post_result = $conn->query($prev_post_sql);

if ($next_post_result->num_rows > 0) {
    $next_post_id = $next_post_result->fetch_assoc()["id"];
    $next_post_url = "post.php?id=$next_post_id&sort=$sorting_option";
} else {
    // If there are no more posts, redirect the user to the dashboard
    $next_post_url = "index.php";
}

if ($prev_post_result->num_rows > 0) {
    $prev_post_id = $prev_post_result->fetch_assoc()["id"];
    $prev_post_url = "post.php?id=$prev_post_id&sort=$sorting_option";
} else {
    // If there are no previous posts, redirect the user to the dashboard
    $prev_post_url = "index.php";
}

// Get the post details for the next post
if ($next_post_result->num_rows > 0) { 
    $next_post_sql = "SELECT * FROM posts WHERE id = $next_post_id LIMIT 1";
    $next_post_result = $conn->query($next_post_sql);
    $next_post_row = $next_post_result->fetch_assoc();
    $next_post_details = array(
        // "id" => $next_post_row["id"],
        "title" => $next_post_row["title"],
        // "description" => $next_post_row["description"],
        "media_type" => $next_post_row["media_type"],
        "file_path" => $next_post_row["file_path"]
        // "button_label" => $next_post_row["button_label"],
        // "button_link" => $next_post_row["button_link"],
        // "author" => "@" . $next_post_row["author"],
        // "author_id" => $next_post_row["author_id"],
        // "created_at" => $next_post_row["created_at"],
        // "likes" => $next_post_row["likes"],
        // "dislikes" => $next_post_row["dislikes"]
    );
    $next_post_media_path = "../uploads/" . $next_post_details["file_path"];
}

if ($prev_post_result->num_rows > 0) { 
    $prev_post_sql = "SELECT * FROM posts WHERE id = $prev_post_id LIMIT 1";
    $prev_post_result = $conn->query($prev_post_sql);
    $prev_post_row = $prev_post_result->fetch_assoc();
    $prev_post_details = array(
        // "id" => $prev_post_row["id"],
        "title" => $prev_post_row["title"],
        // "description" => $prev_post_row["description"],
        "media_type" => $prev_post_row["media_type"],
        "file_path" => $prev_post_row["file_path"]
        // "button_label" => $prev_post_row["button_label"],
        // "button_link" => $prev_post_row["button_link"],
        // "author" => "@" . $prev_post_row["author"],
        // "author_id" => $prev_post_row["author_id"],
        // "created_at" => $prev_post_row["created_at"],
        // "likes" => $prev_post_row["likes"],
        // "dislikes" => $prev_post_row["dislikes"]
    );
    $prev_post_media_path = "../uploads/" . $prev_post_details["file_path"];
}



// Generate the HTML for the post
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.cdnfonts.com/css/proxima-nova-2" rel="stylesheet">
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="viewingpost.css">
    <link rel="stylesheet" href="player.css">
    <title>Просмотр</title>
    <!-- PLEASE NOTE I MESSED UP AND NOW THE NEXT IS THE PREVIOUS AND THE PREVIOUS IS THE NEXT!!! what i mean is that the NEXT post is VISUALLY the PREVIOUS, and vice versa  -->
</head>
<body>
<div class="bgimg"></div>
<div class="superwrapper" id="superwrapper">
<div class="post-preview">
    <?php if ($next_post_result->num_rows > 0) { ?>
        <a id="next"></a>
        <a href="<?php echo $next_post_url; ?>">
            <?php if ($next_post_details["media_type"] == "image") { ?>
                <img src="<?php echo $next_post_media_path; ?>" alt="<?php echo $next_post_details["title"]; ?>">
            <?php } else if ($next_post_details["media_type"] == "video") { ?>
                <video src="<?php echo $next_post_media_path; ?>"></video>
            <?php } ?>

        </a>
    <?php } ?>
</div>



<div class="post-details">
<a id="main"></a>
    <?php if ($post_details["media_type"] == "image") { ?>
        <img src="<?php echo $media_path; ?>" alt="<?php echo $post_details["title"]; ?>">
    <?php } else if ($post_details["media_type"] == "video") { ?>


            
            <video id="mainvid" src="<?php echo $media_path; ?>" loop playsinline></video>
            <div id="playpause" class="preplay">
            <div class="play-icon"></div>
            <div class="pause-icon"></div>

            </div>
    <?php } ?>
    <div class="exit"></div>
    <div class="sidebar">

                <div class="like"><img src="heart.png" alt="like" width="50" height="50"></div>
                <div class="dislike"><img src="cross.png" alt="dislike" width="44" height="44"></div>
               <!-- <div class="comments"><img src="comment.png" alt="comment" width="50" height="50"></div> -->
                
            </div>
    <div class="post-meta">
        <div>
            <!-- <h3 class="title"><?php echo $post_details["title"]; ?></h3> -->
            <span class="author"><span class="author-content"><?php echo $post_details["author"]; ?></span><span class="timedifference"><?php echo $time_diff; ?></span></span>
        </div>
        <!-- <div class="rating">
            <span class="likes"><?php echo $post_details["likes"]; ?>👍</span>
            <span class="dislikes"><?php echo $post_details["dislikes"]; ?>👎</span>
        </div> -->
        <p class="description" id="description-main"><?php echo $post_details["description"]; ?></p>
        <div class="btnwrapper">
            <?php if (!empty($post_details["button_label"])) { ?>
                <a href="<?php echo $post_details["button_link"]; ?>" class="button"><?php echo $post_details["button_label"]; ?></a>
            <?php } ?>
        </div>
        
    </div>
    <div class="fulldesc-cont">
        <div class="fulldesc">
            <span class="fulldesc-title"><h2><?php echo $post_details["title"]; ?></h2></span>
            <span class="fulldesc-description"><?php echo $post_details["description"]; ?></span>
        </div>
    </div>
</div>



<div class="post-preview">
    <?php if ($prev_post_result->num_rows > 0) { ?>
        <a id="prev"></a>
        
        <a href="<?php echo $prev_post_url; ?>">
            <?php if ($prev_post_details["media_type"] == "image") { ?>
                <img src="<?php echo $prev_post_media_path; ?>" alt="<?php echo $prev_post_details["title"]; ?>">
            <?php } else if ($prev_post_details["media_type"] == "video") { ?>
                <video src="<?php echo $prev_post_media_path; ?>"></video>
            <?php } ?>

        </a>
    <?php } ?>
</div>

</div>
</body>
<script>


const amongus = document.getElementById("superwrapper")

if (document.getElementById("prev") != null) {
        var prevExist = true
    } else {
        var prevExist = false
    }
    if (document.getElementById("next") != null) {
        var nextExist = true
    } else {
        var nextExist = false
    }

    console.log(nextExist)
    console.log(prevExist)|

    function XOR(a,b) {
  return ( a || b ) && !( a && b );
}
    
   if (prevExist != nextExist || prevExist == nextExist ) {
    
     if (prevExist==false) {
         if (window.innerWidth >=1000) {
             amongus.scroll(0,1000)
             console.log("Oversized viewport!")
         } else {
             console.log("Standard viewport")
             amongus.scroll(0,500)
         }
         
     } if (nextExist == false) {
         
     } else {
         if (window.innerWidth >=1000) {
             amongus.scroll(0,1000)
             console.log("Oversized viewport!")
         } else {
             console.log("Standard viewport")
             amongus.scroll(0,500)
         }
         
     }
   } else {
    console.log("no other posts...")
   }

// PLEASE NOTE I MESSED UP AND NOW THE NEXT IS THE PREVIOUS AND THE PREVIOUS IS THE NEXT!!!
function handleScroll() {
    const nextlink = "<?php echo $prev_post_url; ?>"
    const prevlink = "<?php echo $next_post_url; ?>"
    
    const superwrapper = document.querySelector('#superwrapper');


if (prevExist != nextExist || (prevExist == true || nextExist == true) ) {
        
    if (nextExist == false) {
      if (superwrapper.scrollTop + superwrapper.clientHeight+1 >= superwrapper.scrollHeight) {
        // User has scrolled to the bottom of #superwrapper
        window.location.href = nextlink;
      }
    } if(prevExist == false) {
        if (superwrapper.scrollTop === 0) {
        // User has scrolled to the top of #superwrapper
        window.location.href = prevlink;
      }
    } else {
      if (superwrapper.scrollTop === 0) {
        // User has scrolled to the top of #superwrapper
        window.location.href = prevlink;
      } else if (superwrapper.scrollTop + superwrapper.clientHeight >= superwrapper.scrollHeight-10) {
        // User has scrolled to the bottom of #superwrapper
        window.location.href = nextlink;
      }
    }
      
} else {

    
}
}

document.querySelector('#superwrapper').onscroll = handleScroll;

const mainvid = document.querySelector("#mainvid")
const playstat = document.querySelector(".preplay")



if (playstat != null) {
    playstat.addEventListener("click", handlePlay);
    
    function handlePlay() {
        if (playstat.classList[0] == "playing") {
        mainvid.pause()
        playstat.classList.remove("playing")
        playstat.classList.add("paused")
        playstat.style.opacity = "1"
        return 0
    } if (playstat.classList[0]  == "paused") {
        mainvid.play()
        playstat.classList.remove("paused")
        playstat.classList.add("playing") 
        playstat.style.opacity = "0"
        return 0
    } if (playstat.classList[0] == "preplay"  ) {
        
        mainvid.play()
        playstat.classList.remove("preplay")
        playstat.classList.add("playing")
        playstat.style.opacity = "0"
        return 0
    }
    }
}


function toggleFullDescription() {
  const fullDesc = document.querySelector('.fulldesc');
  fullDesc.classList.toggle('visible');
}

const descriptionMain = document.getElementById('description-main');
descriptionMain.addEventListener('click', toggleFullDescription);

</script>
</html>