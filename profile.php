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
    <div class='container text-center mx-5 mt-3 p-3 col-lg-4'>
        <table class='table bg-info table-hover'>
            <h3>User Details</h3>
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
    <section class="container-fluid my-2">
        <h1 class="text-center bg-success text-light">Your Blogs</h1>
        <?php
        $blogs = mysqli_query($conn, "select * from blogs left join user on blogs.author_id=user.user_id where user_id=$user_id order by blogs.date desc");
        $rows = mysqli_num_rows($blogs);
        $count = 0;
        if ($rows > 0) { ?>
            <div class="container">
                <table class="table text-center table-bordered">
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th colspan="2">Actions</th>
                    </tr>
                    <?php
                    while ($res = mysqli_fetch_assoc($blogs)) {
                    ?>
                        <tr>
                            <td> <?= ++$count ?></td>
                            <td> <?= $res['blog_title'] ?></td>
                            <td> <?= date('d-M-Y', strtotime($res['date'])) ?></td>
                            <td><a class="btn btn-sm btn-success" href="edit_blog.php">Edit</a></td>
                            <td>
                                <form method="POST" onsubmit=" return confirm('Are you sure you want to delete?')">
                                    <input type="text" hidden name='delid' value="<?= $res['blog_id'] ?>">
                                    <input type="text" hidden name='image' value="<?= $res['image'] ?>">
                                    <button class="btn btn-sm btn-danger" type="submit" name="del_btn" value="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            <?php } else { ?>
                <h2>No Blogs Yet</h2>
            <?php } ?>
            <a class="btn btn-info" href="addblog.php">Add Blog</a>
            </div>
    </section>
<?php endif; ?>
<?php include "assets/footer.php" ?>
<?php
if(isset($_POST['del_btn'])){
    $id=$_POST['delid'];
    $image=$_POST['image'];
    mysqli_query($conn,"delete from blogs where blog_id=$id");
    unlink($image);
    header("Location:profile.php");
}
?>