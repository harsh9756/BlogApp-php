<?php include "config/database.php" ?>
<?php include "assets/header.php" ?>

<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = mysqli_query($conn, "select * from user where user_id='$user_id'");
    $res = mysqli_fetch_assoc($query);
} else {
    echo "<h4 class='text-center mt-4'>Please Login or Signup to view this page</h4>";
}
?>

<?php if (isset($_SESSION['user_id'])) : ?>
    <div class='text-center rounded border mx-auto col-lg-6 mt-3 p-3 bg-light'>
        <h1 class="mb-4">User Details</h1>
        <table class='table table-hover table-bordered'>
            <tr>
                <th>Name</th>
                <td><?php echo $res['name']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $res['email']; ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo $res['username']; ?></td>
            </tr>
        </table>
    </div>

    <section class="container-fluid rounded border border-dark my-2 py-3">
        <h1 class="text-center border-bottom border-dark mb-4">Your Blogs</h1>

        <?php
        $blogs = mysqli_query($conn, "select * from blogs left join user on blogs.author_id=user.user_id where user_id=$user_id order by blogs.date desc");
        $rows = mysqli_num_rows($blogs);
        $count = 0;
        ?>

        <?php if ($rows > 0) : ?>
            <div class="container">
                <table class="table text-center table-bordered">
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th colspan="2">Actions</th>
                    </tr>

                    <?php while ($res = mysqli_fetch_assoc($blogs)) : ?>
                        <tr>
                            <td><?= ++$count ?></td>
                            <td><?= $res['blog_title'] ?></td>
                            <td><?= date('d-M-Y', strtotime($res['date'])) ?></td>
                            <td>
                                <form method="POST" onsubmit=" return confirm('Are you sure you want to delete?')">
                                    <input type="text" hidden name='delid' value="<?= $res['blog_id'] ?>">
                                    <input type="text" hidden name='image' value="<?= $res['image'] ?>">
                                    <button class="btn btn-sm btn-danger" type="submit" name="del_btn" value="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                </table>

            </div>
        <?php else : ?>
            <h2 class="text-center mt-4">No Blogs Yet</h2>
        <?php endif; ?>

        <div class="text-center mt-3">
            <a class="btn btn-primary" href="addblog.php">Add Blog</a>
        </div>
    </section>

<?php endif; ?>

<?php include "assets/footer.php" ?>

<?php
if (isset($_POST['del_btn'])) {
    $id = $_POST['delid'];
    $image = $_POST['image'];
    mysqli_query($conn, "delete from blogs where blog_id=$id");
    unlink($image);
    header("Location:profile.php");
}
?>
