<?php include "config/database.php" ?>
<?php include "assets/header.php" ?>
<?php
$id=$_GET['id'];
$res = mysqli_query($conn, "select * from blogs left join user on blogs.author_id=user.user_id where blog_id=$id");
$blog=$res->fetch_assoc();
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mb-4">
                <img src="<?= $blog['image']?>" class="card-img-top" alt="Blog Post Image">
                <div class="card-body">
                    <h2 class="card-title"><?= $blog['blog_title']?></h2>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= $blog['blog_content']?></p>
                </div>
            </div>

            <div class="mt-3">
                <a href="index.php" class="btn btn-primary">Back to Home</a>
            </div>
        </div>
    </div>
</div>

<?php include "assets/footer.php" ?>
