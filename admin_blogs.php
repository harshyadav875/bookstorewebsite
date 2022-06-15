<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_blog'])){

   $title = mysqli_real_escape_string($conn, $_POST['title']);
   $author = mysqli_real_escape_string($conn, $_POST['author']);
   $content = mysqli_real_escape_string($conn, $_POST['content']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_blog_name = mysqli_query($conn, "SELECT title FROM `blog` WHERE title = '$title'") or die('query failed');

   if(mysqli_num_rows($select_blog_name) > 0){
      $message[] = 'Blog name already added';
   }else{
      $add_blog_query = mysqli_query($conn, "INSERT INTO `blog`(title, author, content, image) VALUES('$title', '$author', '$content', '$image')") or die('query failed');

      if($add_blog_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Blog added successfully!';
         }
      }else{
         $message[] = 'Blog could not be added!';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `blog` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `blog` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_blogs.php');
}

if(isset($_POST['update_blog'])){

   $update_b_id = $_POST['update_b_id'];
   $update_title = $_POST['update_title'];
   $update_author = $_POST['update_author'];
   $update_content = $_POST['update_content'];

   mysqli_query($conn, "UPDATE `blog` SET title = '$update_title', author = '$update_author', content = '$update_content'  WHERE id = '$update_b_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `blog` SET image = '$update_image' WHERE id = '$update_b_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_blogs.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Blog Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">BLOG DASHBOARD</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Add Blog</h3>
      <input type="text" name="title" class="box" placeholder="enter blog name" required>
      <input type="text" name="author" class="box" placeholder="enter author name" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <textarea name="content" class="box" rows="15"></textarea>
      <input type="submit" value="post blog" name="add_blog" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $select_blogs = mysqli_query($conn, "SELECT * FROM `blog`") or die('query failed');
         if(mysqli_num_rows($select_blogs) > 0){
            while($fetch_blogs = mysqli_fetch_assoc($select_blogs)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_blogs['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_blogs['title']; ?></div>
         <div class="price"><?php echo $fetch_blogs['author']; ?></div>
         <a href="admin_blogs.php?update=<?php echo $fetch_blogs['id']; ?>" class="option-btn">update</a>
         <a href="admin_blogs.php?delete=<?php echo $fetch_blogs['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no blog added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `blog` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_b_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_title" value="<?php echo $fetch_update['title']; ?>" class="box" required placeholder="enter blog name">
      <input type="text" name="update_author" value="<?php echo $fetch_update['author']; ?>" class="box" required placeholder="enter blog author">
      <input type="text" name="update_content" value="<?php echo $fetch_update['content']; ?>" class="box" required placeholder="enter blog content">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_blog" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>







<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>