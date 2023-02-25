<?php
session_start();
require_once "postconfig.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $button_label = $_POST["button_label"];
    $button_link = $_POST["button_link"];
    $author = $_SESSION["username"];
    $author_id = $_SESSION["id"];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Файл не картинка/видео.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Извините, этот файл уже существует.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Извините, ваш файл слишком большой.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "mp4") {
        echo "Извините, только JPG, JPEG, PNG, GIF & MP4 файлы разрешинны.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Извините, мы не смогли загрузить ваш файл.";
        // if everything is ok, try to upload file
    } else {
        $mediaid = uniqid();
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $mediaid . "." . $imageFileType)) { 
            $media_type = $imageFileType == "mp4" ? "video" : "image";
            $file_path = $mediaid . "." . $imageFileType;


            $sql = "INSERT INTO posts (title, description, media_type, button_label, button_link, author, file_path, author_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssss", $title, $description, $media_type, $button_label, $button_link, $author, $file_path, $author_id);
            mysqli_stmt_execute($stmt);

            header("location: index.php");
        } else {
            echo "Извините, произошла ошибка во время создания поста.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="UTF-8">
    <title>Create New Post</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ 
            width: 500px; 
            padding: 20px;
            margin: auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Создать новый пост.</h2>
    <p>Заполните эту форму для создания поста.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Название</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Описание</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>
    <div class="form-group">
        <label>Загрузить Фотографию или Видео</label>
        <input type="file" name="fileToUpload" id="fileToUpload" required>
    </div>
    <div class="form-group">
        <label>Надпись Кнопки</label>
        <input type="text" name="button_label" class="form-control">
    </div>
    <div class="form-group">
        <label>Ссылка</label>
        <input type="text" name="button_link" class="form-control">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Создать">
        <a href="index.php" class="btn btn-default">Отменить</a>
    </div>
</form>