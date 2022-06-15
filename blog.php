<?php
// require('includes/blogdb.php');
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Blog</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Blogs</h3>
   <p> <a href="home.php">home</a> / <a href="https://www.instagram.com/theindianbiblio">follow</a></p>
</div>

<!-- book and products -->





<!-- card starts here -->

   <div class="container py-5" >
      <div class="row">
      <?php  
         $select_blog = mysqli_query($conn, "SELECT * FROM `blog`") or die('query failed');
         if(mysqli_num_rows($select_blog) > 0){
            while($fetch_blog = mysqli_fetch_assoc($select_blog)){
      ?>
      
      <div class="col-md-4">
      <div class="card">
      <img src="uploaded_img/<?php echo $fetch_blog['image']; ?>" class="card-img-top" alt="...">
         <div class="card-body">
            <h4 class="card-title" style="text-align:center"><?php echo $fetch_blog['title']; ?></h4>
            <h5 class="card-title" style="text-align:center"><?php echo $fetch_blog['author']; ?></h5>
            <p class="card-text text-truncate"> <?php echo $fetch_blog['content']; ?> </p>
            <a href="blogpost.php?id=<?php echo $fetch_blog['id']; ?>" class="btn btn-primary">Read More</a>
         </div>
      </div>
   </div>
   <?php
}
         
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
?>
   </div>
   </div>


   
<!-- card starts here -->




<!-- books and products  -->

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

</body>
</html>