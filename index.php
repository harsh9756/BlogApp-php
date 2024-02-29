<?php include "config/database.php" ?>
<?php include "assets/header.php" ?>

<?php
session_start();
$res = mysqli_query($conn, "select * from blogs left join user on blogs.author_id=user.user_id");
if ($res) { ?>
    <h1 class="text-light text-center">Latest Blogs</h1>
    <hr style="color: white;">
    <div class="row mx-1">
        <?php
        while ($row = $res->fetch_assoc()) {
        ?>
            <div class="card col-lg-3 mx-auto rounded-3">
                <div class="card-body">
                    <h5 class="card-text"><?= $row['blog_title'] ?></h5>
                    <hr style="border-top: 1px solid black;">
                    <h6 class="card-subtitle mb-2"><?= date('d-M-Y', strtotime($row['date'])) ?></h6>
                    <p class="card-title d-flex">By: <?= $row['name'] ?></p>
                    <a href="blogs.php?id=<?= $row['blog_id'] ?>" class="btn btn-secondary">Read More</a>
                </div>
            </div>

    <?php
        }
    }
    ?>
    </div>
    <?php include "assets/footer.php" ?>