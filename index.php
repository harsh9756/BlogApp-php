<?php include "config/database.php" ?>
<?php include "assets/header.php" ?>
    <?php
    session_start();
    $res = mysqli_query($conn, "select * from blogs left join user on blogs.author_id=user.user_id");
    if ($res) { ?>
        <div class="container rounded mt-2 p-3 bg-dark">
            <h1 class="text-light text-center">Latest Blogs</h1>
            <hr style="color: white;">
            <div class="row">
                <?php
                while ($row = $res->fetch_assoc()) {
                ?>
                    <div class="card m-1 col-lg-3">
                        <div class="card-body">
                            <h5 class="card-text"><?= $row['blog_title'] ?></h5>
                            <hr>
                            <h6 class="card-subtitle mb-2 text-muted"><?= date('d-M-Y', strtotime($row['date'])) ?></h6>
                            <p class="card-title d-flex">By:&nbsp<?= $row['name'] ?></p>
                            <a href="blogs.php?id=<?= $row['blog_id'] ?>" class="btn btn-info">Read More</a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
            </div>
        </div>
<?php include "assets/footer.php" ?>