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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Blogpost</title>
</head>
<body>
    
    <?php include 'header.php'; ?>
    
      <main>
      <?php  
      $blog_id=$_GET['id'];
      $blogquery="SELECT * FROM `blog` WHERE id=$blog_id";
      $runPQ=mysqli_query($conn, $blogquery);   
      $blog=mysqli_fetch_assoc($runPQ);
      ?>

      <section class="about">

         <div class="flex">
         
            <div class="image">
               <img src="uploaded_img/<?php echo $blog['image']; ?>" alt="" >
            </div>
      
            <div class="content">
               <h3><?php echo $blog['title']; ?></h3>
               <br>
               <p><?php echo $blog['content']; ?></p>
              
            </div>
         </div>
      
      </section>
   
      

         
     </main>
     
     <!-- books and products  -->

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>


   
      
   
   
</body>
</html>