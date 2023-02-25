<?php
session_start();
// Include the database configuration file
require_once "postconfig.php";

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
$media_path = "uploads/" . $post_details["file_path"];
$created_at = $post_details["created_at"];
$time_diff = time_diff($created_at);


function time_diff($created_at) {
    date_default_timezone_set('Europe/Moscow');
    $timestamp = strtotime($created_at);
    $diff = time() - $timestamp;
  
    if ($diff < 60) {
      return $diff . " seconds ago";
    } elseif ($diff < 3600) {
      return floor($diff / 60) . " minutes ago";
    } elseif ($diff < 86400) {
      return floor($diff / 3600) . " hours ago";
    } elseif ($diff < 604800) {
      return floor($diff / 86400) . " days ago";
    } elseif ($diff < 2592000) {
      return floor($diff / 604800) . " weeks ago";
    } elseif ($diff < 31536000) {
      return floor($diff / 2592000) . " months ago";
    } else {
      return floor($diff / 31536000) . " years ago";
    }
  }




// Generate the URLs for the next and previous posts based on the sorting option
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
        "id" => $next_post_row["id"],
        "title" => $next_post_row["title"],
        "description" => $next_post_row["description"],
        "media_type" => $next_post_row["media_type"],
        "file_path" => $next_post_row["file_path"],
        "button_label" => $next_post_row["button_label"],
        "button_link" => $next_post_row["button_link"],
        "author" => "@" . $next_post_row["author"],
        "author_id" => $next_post_row["author_id"],
        "created_at" => $next_post_row["created_at"],
        "likes" => $next_post_row["likes"],
        "dislikes" => $next_post_row["dislikes"]
    );
    $next_post_media_path = "uploads/" . $next_post_details["file_path"];
}




// Generate the HTML for the post
?>
<head>

    <link rel="stylesheet" href="viewingpost.css">
    <link href="https://fonts.cdnfonts.com/css/proxima-nova-2" rel="stylesheet">
    <meta name="viewport" content="width=device-width initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<div class="superwrapper">
<div class="post-details">
    <?php if ($post_details["media_type"] == "image") { ?>
        <img src="<?php echo $media_path; ?>" alt="<?php echo $post_details["title"]; ?>">
    <?php } else if ($post_details["media_type"] == "video") { ?>
        <video src="<?php echo $media_path; ?>" controls muted autoplay></video>
    <?php } ?>
    <div class="post-meta">
        <div>
    <h3 class="title"><?php echo $post_details["title"]; ?></h3>
    <span class="author"><i><?php echo $post_details["author"]; ?></i></span>
        </div>
    <div class="rating">
        <span class="likes"><?php echo $post_details["likes"]; ?>👍</span>
        <span class="dislikes"><?php echo $post_details["dislikes"]; ?>👎</span>
        </div>
    <p class="description"><?php echo $post_details["description"]; ?></p>
    <div class="btnwrapper">
    <?php if (!empty($post_details["button_label"])) { ?>
        <a href="<?php echo $post_details["button_link"]; ?>" class="button"><?php echo $post_details["button_label"]; ?></a>
    <?php } ?>
    </div>
    <span class="timedifference"><?php echo $time_diff; ?></span>
        
        
    </div>
</div>
<!-- <div class="navigation">
    <?php if ($prev_post_url != "index.php") { ?>
        <a href="<?php echo $prev_post_url; ?>" class="previous-post">
            <img class="left" src="left.png" alt="Previous Post" height="50" width="50">
        </a>
    <?php } ?>
    <?php if ($next_post_url != "index.php") { ?>
        <a href="<?php echo $next_post_url; ?>" class="next-post">
            <img class="right" src="right.png" alt="Next Post" height="50" width="50">
        </a>
    <?php } ?>
</div> -->

<div class="post-preview">
    <?php if ($next_post_result->num_rows > 0) { ?>
        <a href="<?php echo $next_post_url; ?>">
            <?php if ($next_post_details["media_type"] == "image") { ?>
                <img src="<?php echo $next_post_media_path; ?>" alt="<?php echo $next_post_details["title"]; ?>">
            <?php } else if ($next_post_details["media_type"] == "video") { ?>
                <video src="<?php echo $next_post_media_path; ?>" controls></video>
            <?php } ?>

        </a>
    <?php } ?>
</div>
</div>
<script>
        $(document).ready(function() {
            // Swipe event listeners for touch devices
            var xDown = null;
            var yDown = null;

            function getTouches(evt) {
                return evt.touches ||             // browser API
                    evt.originalEvent.touches; // jQuery
            }

            function handleTouchStart(evt) {
                const firstTouch = getTouches(evt)[0];
                xDown = firstTouch.clientX;
                yDown = firstTouch.clientY;
            };

            function handleTouchMove(evt) {
                if (!xDown || !yDown) {
                    return;
                }

                var xUp = evt.touches[0].clientX;
                var yUp = evt.touches[0].clientY;

                var xDiff = xDown - xUp;
                var yDiff = yDown - yUp;

                if (Math.abs(xDiff) > Math.abs(yDiff)) {
                    if (xDiff > 0) {
                        // swipe left
                        window.location.href = "<?php echo $next_post_url; ?>";
                    } else {
                        // swipe right
                        window.location.href = "<?php echo $prev_post_url; ?>";
                    }
                } else {
                    if (yDiff > 0) {
                        // swipe up
                        window.location.href = "<?php echo $next_post_url; ?>";
                    } else {
                        // swipe down
                        window.location.href = "<?php echo $prev_post_url; ?>";
                        
                    }
                }
                /* reset values */
                xDown = null;
                yDown = null;
            };

            // Swipe event listeners for desktop
            var isDragging = false;
            var startX, endX;

            function handleMouseDown(evt) {
                isDragging = true;
                startX = evt.clientX;
            }

            function handleMouseMove(evt) {
                if (!isDragging) {
                    return;
                }
                endX = evt.clientX;
            }

            function handleMouseUp(evt) {
                isDragging = false;
                if (startX - endX > 0) {
                    // swipe left
                    
                } else {
                    // swipe right
                    
                }
            }

            // Add event listeners
            document.addEventListener('touchstart', handleTouchStart, false);
            document.addEventListener('touchmove', handleTouchMove, false);
            document.addEventListener('mousedown', handleMouseDown, false);
            document.addEventListener('mousemove', handleMouseMove, false);
            document.addEventListener('mouseup', handleMouseUp, false);
        });
    </script>


