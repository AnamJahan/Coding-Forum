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
    #ques {
        min-height: 433px;
    }
    </style>
    <title>iDiscuss - Coding Forum</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'?>
    <?php include 'partials/_navbar.php'?>
    <!-- slider -->
    <?php
    $id = $_GET['threadid'];
          $sql ="SELECT *FROM `threads` WHERE thread_id = $id";
          $result = mysqli_query($conn ,$sql);
          while($row = mysqli_fetch_assoc($result))
          {
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_user_id = $row['thread_user_id'];


            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $posted_by = $row2['user_email'];
          }
          ?>

    <?php   
              $method = $_SERVER['REQUEST_METHOD'];
            //   echo $method;
            $showAlert = false;
              if($method=='POST')
              {
                    $showAlert = true;
                    $comment = $_POST['comment'];
                    $comment = str_replace("<" , "&lt;" , $comment);
                    $comment = str_replace(">" , "&gt;" , $comment);
                    $sno = $_POST['sno'];
                    $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_time`, `comment_by`) VALUES ( '$comment', '$id', current_timestamp(), ' $sno')";
                    $result=mysqli_query($conn , $sql);
                    if($showAlert)
                    {
                        echo'
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strongSuccessHoly guacamole!</strong> Your comment has been added.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button> 
                        </div>
                        ';
                    }
              }
          ?>
    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4"><?php  echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <!-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> -->
            <p>Posted by :<em><?php echo $posted_by; ?> </em></p>
        </div>
    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
    {
    echo '<div class="container">
        <h1 class="py-2">Post a Comment</h1>
        <form action= "'. $_SERVER['REQUEST_URI'] . '" method="post">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
    }
    else
    {
        echo '
        <div class="container">
        <h1 class="py-2">Post a Comment</h1>
            <p class="lead">"You are not logged in . Please login to start a Discussion"</p>
        </div>';
    }
    ?>
    <div class="container mb-5" id="ques">
        <h1 class="py-2">Discussions</h1>
        <?php
          $id = $_GET['threadid'];
          $sql ="SELECT *FROM `comments` WHERE thread_id = $id";
          $result = mysqli_query($conn ,$sql);
          $noResult = true;
          while($row = mysqli_fetch_assoc($result))
          {
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $thread_user_id = $row['comment_by']; 
            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            echo '<div class="media my-3">
            <img src="partials/user.png" width="54px" class="mr-3" alt="...">
            <div class="media-body">
               <p class="font-weight-bold my-0">'. $row2['user_email'] .' at '. $comment_time. '</p> '. $content . '
            </div>
        </div>';
        }
            if($noResult){
                
                echo' <div class="jumbotron jumbotron-fluid">
                <div class="container">
                <h1 class="display-4">No Comments Found</h1>
                <p class="lead">Be the first to ask a questions</p>
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