<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
    #main {
        min-height: 100vh;
    }
    </style>
    <title>iDiscuss - Coding Forum</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'?>
    <?php include 'partials/_navbar.php'?>
    <!-- slider -->
    <div class="container my-3" id="main">
        <h1 class="py-2">Search resultd from <em?>"<?php echo $_GET['search'] ?>"</em></h1>
        <?php
    $noResult = true;
          $query = $_GET["search"];
          $sql ="SELECT *FROM threads WHERE match (thread_title , thread_desc) against ('$query')";
          $result = mysqli_query($conn , $sql);
          while($row = mysqli_fetch_assoc($result))
          {
            $noResult = false;
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_id = $row['thread_id'];
            $url = "thread.php?threadid='.$thread_id.'";


            echo' <div class="result">
            <h3><a href="'.$url.'" class="text-dark">Cannot install pyaudi'.$title.'</a></h3>
            <p>'.$desc.'</p>
            </div>';
          }
          if($noResult){
            echo' <div class="jumbotron jumbotron-fluid">
                 <div class="container">
                 <h1 class="display-4">No Results Found</h1>
                 <p class="lead">Please Enter</p>
                 </div>
                 </div>';
          }
          ?>
    </div>
    <?php include 'partials/_footer.php'?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
</body>

</html>