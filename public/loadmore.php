<?php
require_once "../auth/config.php";

// Get the offset and limit parameters from the request
$offset = $_GET["offset"];
$limit = $_GET["limit"];

// Construct the SQL query to fetch posts from the database with a limit and offset
$sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $response = array();
  while($row = $result->fetch_assoc()) {
    $title = $row["title"];
    $postid= $row["id"];
    $file_path = $row["file_path"];
    $author = "@" . $row["author"];
    $likes = $row["likes"];
    $dislikes = $row["dislikes"];
    $created_at = $row["created_at"];
    $time_diff = time_diff($created_at);
    $media_type = $row["media_type"];

    // Construct an array of post data for this post
    $post_data = array(
      "postid" => $postid,
      "title" => $title,
      "file_path" => $file_path,
      "author" => $author,
      "likes" => $likes,
      "dislikes" => $dislikes,
      "time_diff" => $time_diff,
      "media_type" => $media_type
    );

    // Add the post data to the response array
    array_push($response, $post_data);
  }

  // Send the response array as a JSON-encoded string back to the client
  echo json_encode($response);
} else {
  // If no more posts are found, send an empty JSON array back to the client
  echo json_encode(array());
}

$conn->close();

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
