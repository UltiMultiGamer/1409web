


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.cdnfonts.com/css/proxima-nova-2" rel="stylesheet">
    <title>Create New Post</title>
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="forms.css">
    <style type="text/css">
    </style>
</head>
<body>
<div class="bgimg"></div>
<div class="form-wrapper" id="form-wrapper">
    <h2 id="form-title">Создать новый пост.</h2>
    <p id="form-label">Заполните эту форму для создания поста.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group lessmargin">
        <input type="file" name="fileToUpload" id="fileToUpload" required style="visibility:hidden;height: 0px;margin: 0px;">
        <label class="uploadlabel" for="fileToUpload" onclick="activate()">Загрузить</label>
        
    </div>
    <img src="" alt="" id="preview">
    <div class="form-group">
        <input type="text" name="title" class="text-input" required placeholder=" ">
        <label>Название</label>
    </div>
    <div class="form-group">
        
        <textarea name="description" class="text-input" required placeholder=" "></textarea>
        <label>Описание</label>
    </div>
    
    <div class="form-group">
        
        <input type="text" name="button_label" class="text-input" placeholder=" ">
        <label>Надпись Кнопки</label>
    </div>
    <div class="form-group">
        <input type="text" name="button_link" class="text-input" placeholder=" ">
        <label>Ссылка</label>
    </div>
    <div id="fileToUploadError"></div>
    <div class="form-group align-horiz">


        <input type="submit" class="button" value="Создать">
        <input onclick="cancel()" class="button" type="submit" value="Отменить">
    </div>
</form>
</div>
<?php
session_start();
require_once "../auth/postconfig.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $button_label = $_POST["button_label"];
    $button_link = $_POST["button_link"];
    $author = $_SESSION["username"];
    $author_id = $_SESSION["id"];

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>document.getElementById('fileToUploadError').innerHTML='Файл не картинка/видео.';</script>";
            $uploadOk = 0;
        }
    }

    // Check image dimensions
    $min_width = 100; // set minimum width
    $min_height = 100; // set minimum height
    $max_width = 2600; // set maximum width
    $max_height = 2600; // set maximum height
    list($width, $height) = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($width < $min_width || $height < $min_height) {
        echo "<script>document.getElementById('fileToUploadError').innerHTML='Извините, ваш файл слишком маленький.';</script>";
        $uploadOk = 0;
    }
    if ($width > $max_width || $height > $max_height) {
        echo "<script>document.getElementById('fileToUploadError').innerHTML='Извините, ваш файл слишком большой.';</script>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<script>document.getElementById('fileToUploadError').innerHTML='Извините, этот файл уже существует.';</script>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 50000000) {
        echo "<script>document.getElementById('fileToUploadError').innerHTML='Извините, ваш файл слишком большой.';</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "mp4") {
        echo "<script>document.getElementById('fileToUploadError').innerHTML='Извините, только JPG, JPEG, PNG, GIF & MP4 файлы разрешинны.';</script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // echo "<script>document.getElementById('fileToUploadError').innerHTML='Извините, мы не смогли загрузить ваш файл.';</script>";
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
            // echo "<script>document.getElementById('fileToUploadError').innerHTML='Извините, произошла ошибка во время создания поста.';</script>";
        }
    }
}
?>





<script>

    
    const uploader = document.getElementById("fileToUpload")
    const preview = document.getElementById("preview")
    const body = document.querySelector("body")
    const wrapper = document.getElementById("form-wrapper")
    uploader.onchange = evt => {
  const [file] = uploader.files
  if (file) {
    console.log(file)
    preview.src = URL.createObjectURL(file)
    preview.style.borderRadius = "10px"
    preview.style.height ="150px"
    preview.style.width = "150px"
    preview.style.objectFit ="cover"
    preview.style.marginBottom ="32px"
    body.style.alignItems = "normal"
    body.style.margin = "auto"
    body.style.height="100vh"
    wrapper.style.height ="fit-content"


  }
}
function activate() {
    preview.style.display = "block";
}
function cancel() {
    window.location.href = "index.php";

}

// function checkHeightChange(element) {


// }

</script>
</body>
</html>