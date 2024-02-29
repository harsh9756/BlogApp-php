<?php include "assets/header.php" ?>
<?php include "config/database.php" ?>
<div class="container mt-5">
    <h2>Add Blog</h2>
    <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <h5 for="title">Title:</h5>
                <input type="text" class="form-control" id="title" name="title" >
            </div>
            <div class="form-group">
                <h5 for="content">Content:</h5>
                <textarea class="form-control" id="content" name="content" rows="3" ></textarea>
            </div>
            <div class="form-group mt-3">
                <H5 for="image">Image:</H5>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" >
            </div>
        <button type="submit" name="add_blog" class="btn btn-success mt-2">Submit</button>
    </form>
</div>
<?php
session_start();
if(isset($_POST['add_blog'])){
    $title=$_POST['title'];
    $body=$_POST['content'];
    $targetDir = "uploads/";  // Change this to the desired directory
    $File = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($File, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        // Check if the file already exists
        if (file_exists($File)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Allow only certain file formats
        $allowedFormats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Move the file to the specified directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $File)) {
                echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
                $author_id=$_SESSION['user_id'];
                $res=mysqli_query($conn,"insert into blogs(blog_title, blog_content, author_id, image) values ('$title','$body','$author_id','$File')");
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
?>
<?php include "assets/footer.php" ?>